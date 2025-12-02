<?php

namespace App\Http\Controllers\Kelurahan;

use App\Enums\UserRole;
use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Pagination\LengthAwarePaginator;

class MonitoringController extends Controller
{
    public function puskesmas(Request $request)
    {
        abort_if($request->user()->role !== UserRole::Kelurahan, 403);

        $kelurahan = $request->user()->loadMissing('detail');
        $puskesmasId = optional($kelurahan->detail)->supervisor_id;

        $puskesmasList = $puskesmasId
            ? User::query()
                ->with('detail')
                ->where('role', UserRole::Puskesmas->value)
                ->where('id', $puskesmasId)
                ->when($request->filled('q'), function ($query) use ($request) {
                    $term = '%' . $request->input('q') . '%';
                    $query->where(function ($sub) use ($term) {
                        $sub->where('name', 'like', $term)
                            ->orWhereHas('detail', function ($detail) use ($term) {
                                $detail->where('address', 'like', $term)
                                    ->orWhere('organization', 'like', $term);
                            });
                    });
                })
                ->paginate(10)
                ->withQueryString()
            : new LengthAwarePaginator([], 0, 10, 1, [
                'path' => $request->url(),
                'query' => $request->query(),
            ]);

        return view('kelurahan.puskesmas', [
            'puskesmasList' => $puskesmasList,
            'search' => $request->input('q', ''),
        ]);
    }

    public function kaders(Request $request)
    {
        abort_if($request->user()->role !== UserRole::Kelurahan, 403);

        $kelurahan = $request->user();
        $perPage = 10;
        $puskesmasIds = collect(optional($kelurahan->detail)->supervisor_id ? [$kelurahan->detail->supervisor_id] : []);

        if ($puskesmasIds->isEmpty()) {
            $kaders = new LengthAwarePaginator([], 0, $perPage, 1, [
                'path' => $request->url(),
                'query' => $request->query(),
            ]);
        } else {
            $kaders = User::query()
                ->with(['detail.supervisor'])
                ->where('role', UserRole::Kader->value)
                ->whereHas('detail', fn($detail) => $detail->whereIn('supervisor_id', $puskesmasIds))
                ->when($request->filled('q'), function ($query) use ($request) {
                    $term = '%' . $request->input('q') . '%';
                    $query->where(function ($sub) use ($term) {
                        $sub->where('name', 'like', $term)
                            ->orWhere('phone', 'like', $term)
                            ->orWhereHas('detail', fn($detail) => $detail->where('area', 'like', $term));
                    });
                })
                ->latest()
                ->paginate($perPage)
                ->withQueryString();
        }

        return view('kelurahan.kaders', [
            'kaders' => $kaders,
            'search' => $request->input('q', ''),
        ]);
    }

    public function updateKaderStatus(Request $request, User $kader)
    {
        abort_if($request->user()->role !== UserRole::Kelurahan, 403);
        abort_if($kader->role !== UserRole::Kader, 404);

        $kelurahan = $request->user();
        $kader->loadMissing('detail.supervisor.detail.supervisor');
        $kelurahanOwner = optional(optional(optional($kader->detail)->supervisor)->detail)->supervisor;
        abort_if(optional($kelurahanOwner)->id !== $kelurahan->id, 403);

        $validated = $request->validate([
            'status' => ['required', 'in:active,inactive'],
        ]);

        $kader->is_active = $validated['status'] === 'active';
        $kader->save();

        return back()->with('status', 'Status kader diperbarui.');
    }

    public function patients(Request $request)
    {
        abort_if($request->user()->role !== UserRole::Kelurahan, 403);

        $kelurahan = $request->user();
        $perPage = 10;
        $puskesmasIds = collect(optional($kelurahan->detail)->supervisor_id ? [$kelurahan->detail->supervisor_id] : []);

        $filterPatients = function ($query) use ($puskesmasIds, $request) {
            return $query
                ->where('role', UserRole::Pasien->value)
                ->whereHas('detail.supervisor.detail', fn($detail) => $detail->whereIn('supervisor_id', $puskesmasIds))
                ->when($request->filled('q'), function ($query) use ($request) {
                    $term = '%' . $request->input('q') . '%';
                    $query->where(function ($sub) use ($term) {
                        $sub->where('name', 'like', $term)
                            ->orWhere('phone', 'like', $term)
                            ->orWhereHas('detail', fn($detail) => $detail->where('address', 'like', $term));
                    });
                });
        };

        if ($puskesmasIds->isEmpty()) {
            $patients = new LengthAwarePaginator([], 0, $perPage, 1, [
                'path' => $request->url(),
                'query' => $request->query(),
            ]);
            $stats = ['total' => 0, 'screened' => 0, 'unscreened' => 0];
        } else {
            $patientsQuery = $filterPatients(User::query())
                ->with([
                    'detail.supervisor.detail.supervisor',
                    'screenings' => fn($query) => $query->latest()->limit(1),
                    'treatments' => fn($query) => $query->latest()->limit(1),
                ])
                ->latest();

            $patients = $patientsQuery->paginate($perPage)->withQueryString();

            $statsQuery = $filterPatients(User::query());
            $total = (clone $statsQuery)->count();
            $screened = (clone $statsQuery)->whereHas('screenings')->count();
            $stats = [
                'total' => $total,
                'screened' => $screened,
                'unscreened' => max(0, $total - $screened),
            ];
        }

        return view('kelurahan.patients', [
            'patients' => $patients,
            'search' => $request->input('q', ''),
            'stats' => $stats,
        ]);
    }

    public function showPatient(Request $request, User $patient)
    {
        abort_if($request->user()->role !== UserRole::Kelurahan, 403);
        abort_if($patient->role !== UserRole::Pasien, 404);

        $patient->loadMissing([
            'detail.supervisor.detail.supervisor',
            'screenings' => fn($query) => $query->latest()->limit(5),
            'treatments' => fn($query) => $query->latest()->limit(5),
            'familyMembers' => fn($query) => $query->latest(),
        ]);

        $kader = optional($patient->detail)->supervisor;
        $puskesmas = optional($kader?->detail)->supervisor;
        $kelurahan = optional(optional($puskesmas?->detail)->supervisor);

        abort_if(optional($kelurahan)->id !== $request->user()->id, 403);

        return view('kelurahan.patient-detail', [
            'patient' => $patient,
            'puskesmas' => $puskesmas,
        ]);
    }
}
