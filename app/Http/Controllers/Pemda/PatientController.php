<?php

namespace App\Http\Controllers\Pemda;

use App\Enums\UserRole;
use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Http\Request;

class PatientController extends Controller
{
    public function index(Request $request)
    {
        abort_if($request->user()->role !== UserRole::Pemda, 403);

        $kelurahanPuskesmasId = null;
        if ($request->filled('kelurahan_id')) {
            $kelurahan = User::query()
                ->with('detail')
                ->where('role', UserRole::Kelurahan->value)
                ->find($request->input('kelurahan_id'));
            $kelurahanPuskesmasId = optional($kelurahan?->detail)->supervisor_id;
        }

        $puskesmasOptions = User::query()
            ->where('role', UserRole::Puskesmas->value)
            ->orderBy('name')
            ->get(['id', 'name']);

        $kelurahanOptions = User::query()
            ->where('role', UserRole::Kelurahan->value)
            ->orderBy('name')
            ->get(['id', 'name']);

        $months = [
            1 => 'Januari',
            2 => 'Februari',
            3 => 'Maret',
            4 => 'April',
            5 => 'Mei',
            6 => 'Juni',
            7 => 'Juli',
            8 => 'Agustus',
            9 => 'September',
            10 => 'Oktober',
            11 => 'November',
            12 => 'Desember',
        ];

        $currentYear = now()->year;
        $years = [];
        for ($i = 0; $i < 5; $i++) {
            $years[] = $currentYear - $i;
        }

        $perPage = 10;

        $patientsQuery = User::query()
            ->with([
                'detail',
                'detail.supervisor',
                'detail.supervisor.detail',
                'screenings' => fn($query) => $query->latest()->limit(1),
                'treatments' => fn($query) => $query->latest()->limit(1),
            ])
            ->where('role', UserRole::Pasien->value)
            ->when($request->filled('q'), function ($query) use ($request) {
                $term = '%' . $request->input('q') . '%';
                $query->where(function ($sub) use ($term) {
                    $sub->where('name', 'like', $term)
                        ->orWhere('phone', 'like', $term)
                        ->orWhereHas('detail', function ($detail) use ($term) {
                            $detail->where('address', 'like', $term)
                                ->orWhere('nik', 'like', $term);
                        });
                });
            })
            ->when($request->filled('puskesmas_id'), function ($query) use ($request) {
                $puskesmasId = $request->input('puskesmas_id');
                $query->whereHas('detail.supervisor.detail', fn(Builder $detail) => $detail->where('supervisor_id', $puskesmasId));
            })
            ->when($request->filled('kelurahan_id'), function ($query) use ($kelurahanPuskesmasId) {
                if (!$kelurahanPuskesmasId) {
                    $query->whereRaw('0 = 1');
                    return;
                }
                $query->whereHas('detail.supervisor.detail', fn(Builder $detail) => $detail->where('supervisor_id', $kelurahanPuskesmasId));
            })
            ->when($request->filled('month'), function ($query) use ($request) {
                $query->whereMonth('created_at', $request->input('month'));
            })
            ->when($request->filled('year'), function ($query) use ($request) {
                $query->whereYear('created_at', $request->input('year'));
            })
            ->latest();

        $patientsForStats = (clone $patientsQuery)->get();
        $patients = $patientsQuery->paginate($perPage)->withQueryString();

        $stats = [
            'total' => $patientsForStats->count(),
            'belum_skrining' => $patientsForStats->filter(fn($patient) => $patient->screenings->isEmpty())->count(),
            'sudah_skrining' => $patientsForStats->filter(fn($patient) => $patient->screenings->isNotEmpty())->count(),
            'suspect' => $patientsForStats->filter(function ($patient) {
                $latest = $patient->screenings->first();
                if (!$latest) {
                    return false;
                }
                $positive = collect($latest->answers ?? [])->filter(fn($ans) => $ans === 'ya')->count();
                return $positive >= 2;
            })->count(),
        ];

        return view('pemda.patients', [
            'patients' => $patients,
            'search' => $request->input('q', ''),
            'filters' => [
                'puskesmas_id' => $request->input('puskesmas_id', ''),
                'kelurahan_id' => $request->input('kelurahan_id', ''),
                'month' => $request->input('month', ''),
                'year' => $request->input('year', ''),
            ],
            'stats' => $stats,
            'puskesmasOptions' => $puskesmasOptions,
            'kelurahanOptions' => $kelurahanOptions,
            'months' => $months,
            'years' => $years,
        ]);
    }

    public function show(Request $request, User $patient)
    {
        abort_if($request->user()->role !== UserRole::Pemda, 403);
        abort_if($patient->role !== UserRole::Pasien, 404);

        $patient->loadMissing([
            'detail.supervisor.detail',
            'screenings' => fn($query) => $query->latest()->limit(5),
            'treatments' => fn($query) => $query->latest()->limit(5),
            'familyMembers' => fn($query) => $query->latest(),
        ]);

        return view('pemda.patient-detail', [
            'patient' => $patient,
            'kader' => optional($patient->detail)->supervisor,
            'puskesmas' => optional(optional($patient->detail)->supervisor)->detail->supervisor,
        ]);
    }
}
