<?php

namespace App\Http\Controllers\Puskesmas;

use App\Enums\UserRole;
use App\Http\Controllers\Controller;
use App\Models\PatientScreening;
use App\Models\User;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Http\Request;
use Illuminate\Pagination\LengthAwarePaginator;
use Maatwebsite\Excel\Facades\Excel;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;

class ScreeningController extends Controller
{
    public function index(Request $request)
    {
        abort_if($request->user()->role !== UserRole::Puskesmas, 403);

        $perPage = 10;
        $kaderIds = User::query()
            ->where('role', UserRole::Kader->value)
            ->whereHas('detail', fn($detail) => $detail->where('supervisor_id', $request->user()->id))
            ->pluck('id');

        $patients = $kaderIds->isEmpty()
            ? new LengthAwarePaginator([], 0, $perPage, 1, [
                'path' => $request->url(),
                'query' => $request->query(),
            ])
            : User::query()
                ->with([
                    'detail',
                    'detail.supervisor',
                    'screenings' => fn($query) => $query->latest()->limit(1),
                ])
                ->where('role', UserRole::Pasien->value)
                ->whereHas('detail', fn($detail) => $detail->whereIn('supervisor_id', $kaderIds))
                ->when($request->filled('from'), fn($query) => $query->whereHas('screenings', fn($screening) => $screening->whereDate('created_at', '>=', $request->date('from'))))
                ->when($request->filled('to'), fn($query) => $query->whereHas('screenings', fn($screening) => $screening->whereDate('created_at', '<=', $request->date('to'))))
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
                ->latest()
                ->paginate($perPage)
                ->withQueryString();

        return view('puskesmas.screenings', [
            'patients' => $patients,
            'search' => $request->input('q', ''),
            'filters' => [
                'from' => $request->input('from', ''),
                'to' => $request->input('to', ''),
            ],
        ]);
    }

    public function show(Request $request, User $patient)
    {
        abort_if($request->user()->role !== UserRole::Puskesmas, 403);
        abort_if($patient->role !== UserRole::Pasien, 404);

        $patient->loadMissing([
            'detail.supervisor.detail',
            'screenings' => fn($query) => $query->latest()->limit(1),
        ]);

        $kader = optional($patient->detail)->supervisor;
        $puskesmasId = optional($kader?->detail)->supervisor_id;
        abort_if($puskesmasId !== $request->user()->id, 403);

        $latestScreening = $patient->screenings->first();

        return view('puskesmas.screening-detail', [
            'patient' => $patient,
            'kader' => $kader,
            'latestScreening' => $latestScreening,
        ]);
    }

    public function exportExcel(Request $request)
    {
        abort_if($request->user()->role !== UserRole::Puskesmas, 403);

        $questionLabels = [
            'batuk_kronis' => 'Batuk Kronis',
            'dahak_darah' => 'Dahak Darah',
            'berat_badan' => 'Berat Badan',
            'demam_malam' => 'Demam Malam',
        ];

        $kaderIds = User::query()
            ->where('role', UserRole::Kader->value)
            ->whereHas('detail', fn($detail) => $detail->where('supervisor_id', $request->user()->id))
            ->pluck('id');

        $screenings = $kaderIds->isEmpty()
            ? collect()
            : PatientScreening::query()
                ->with(['patient.detail', 'kader'])
                ->whereHas('patient.detail', fn($detail) => $detail->whereIn('supervisor_id', $kaderIds))
                ->when($request->filled('from'), fn($query) => $query->whereDate('created_at', '>=', $request->date('from')))
                ->when($request->filled('to'), fn($query) => $query->whereDate('created_at', '<=', $request->date('to')))
                ->orderByDesc('created_at')
                ->get();

        $export = new class($screenings, $questionLabels) implements FromCollection, WithHeadings {
            public function __construct(private $screenings, private $questionLabels)
            {
            }

            public function collection()
            {
                return $this->screenings->values()->map(function ($screening, $index) {
                    $answers = $screening->answers ?? [];
                    $getAnswer = function ($key) use ($answers) {
                        $value = $answers[$key] ?? null;
                        return $value === 'ya' ? 'Ya' : ($value === 'tidak' ? 'Tidak' : ($value ?? '-'));
                    };

                    $row = [
                        'No' => $index + 1,
                        'Nama' => $screening->patient?->name ?? '-',
                        'NIK' => $screening->patient?->detail?->nik ?? '-',
                        'Nomor HP' => $screening->patient?->phone ?? '-',
                        'Tanggal Skrining' => optional($screening->created_at)?->format('d/m/Y H:i') ?? '-',
                    ];

                    foreach ($this->questionLabels as $key => $label) {
                        $row[$label] = $getAnswer($key);
                    }

                    return $row;
                });
            }

            public function headings(): array
            {
                return array_merge(
                    ['No', 'Nama', 'NIK', 'Nomor HP', 'Tanggal Skrining'],
                    array_values($this->questionLabels),
                );
            }
        };

        return Excel::download($export, 'skrining-pasien.xlsx');
    }
}
