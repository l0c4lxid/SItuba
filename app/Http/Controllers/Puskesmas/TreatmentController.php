<?php

namespace App\Http\Controllers\Puskesmas;

use App\Enums\UserRole;
use App\Http\Controllers\Controller;
use App\Models\PatientTreatment;
use App\Models\User;
use App\Support\FamilyTreatment;
use Illuminate\Http\Request;
use Illuminate\Pagination\LengthAwarePaginator;

class TreatmentController extends Controller
{
    public function index(Request $request)
    {
        abort_if($request->user()->role !== UserRole::Puskesmas, 403);

        $perPage = 10;
        $kaderIds = User::query()
            ->where('role', UserRole::Kader->value)
            ->whereHas('detail', fn($detail) => $detail->where('supervisor_id', $request->user()->id))
            ->pluck('id');

        $statuses = [
            'contacted' => 'Perlu Konfirmasi',
            'scheduled' => 'Terjadwal',
            'in_treatment' => 'Sedang Berobat',
            'recovered' => 'Selesai',
        ];

        $familyStatuses = [
            'pending' => ['label' => 'Belum Ditindaklanjuti', 'badge' => 'bg-gradient-secondary'],
            'in_progress' => ['label' => 'Dalam Pemantauan', 'badge' => 'bg-gradient-warning text-dark'],
            'suspect' => ['label' => 'Suspek TBC', 'badge' => 'bg-gradient-danger'],
            'clear' => ['label' => 'Tidak Ada Gejala', 'badge' => 'bg-gradient-success'],
        ];

        $statusParam = $request->input('status');
        $search = $request->input('q', '');

        if ($kaderIds->isEmpty()) {
            $counts = collect(array_fill_keys(array_keys($statuses), 0));
            $treatments = new LengthAwarePaginator([], 0, $perPage, 1, [
                'path' => $request->url(),
                'query' => $request->query(),
            ]);
        } else {
            $baseQuery = PatientTreatment::query()
                ->with([
                    'patient.detail',
                    'patient.detail.supervisor',
                    'patient.screenings' => fn($query) => $query->latest()->limit(1),
                    'patient.familyMembers' => fn($query) => $query->orderBy('name'),
                ])
                ->whereHas('patient.detail', function ($detail) use ($kaderIds) {
                    $detail->whereIn('supervisor_id', $kaderIds);
                });

            $counts = collect();
            foreach (array_keys($statuses) as $status) {
                $counts[$status] = (clone $baseQuery)->where('status', $status)->count();
            }

            $treatmentsQuery = (clone $baseQuery)
                ->when($statusParam && array_key_exists($statusParam, $statuses), function ($query) use ($statusParam) {
                    $query->where('status', $statusParam);
                })
                ->when($search !== '', function ($query) use ($search) {
                    $term = '%' . $search . '%';
                    $query->whereHas('patient', function ($patient) use ($term) {
                        $patient->where('name', 'like', $term)
                            ->orWhere('phone', 'like', $term)
                            ->orWhereHas('detail', function ($detail) use ($term) {
                                $detail->where('address', 'like', $term)
                                    ->orWhere('nik', 'like', $term);
                            });
                    });
                });

            $treatments = $treatmentsQuery
                ->latest()
                ->paginate($perPage)
                ->withQueryString();
        }

        return view('puskesmas.treatment', [
            'treatments' => $treatments,
            'statuses' => $statuses,
            'counts' => $counts,
            'activeStatus' => $statusParam,
            'familyStatuses' => $familyStatuses,
            'search' => $search,
        ]);
    }

    public function updateStatus(Request $request, User $patient)
    {
        abort_if($request->user()->role !== UserRole::Puskesmas, 403);
        abort_if($patient->role !== UserRole::Pasien, 404);

        $patient->loadMissing(['detail', 'treatments']);
        abort_if(!$patient->detail, 422);

        $validated = $request->validate([
            'status' => ['required', 'in:contacted,scheduled,in_treatment,recovered'],
            'next_follow_up_at' => ['nullable', 'date'],
            'treatment_notes' => ['nullable', 'string', 'max:1000'],
        ]);

        $treatment = $patient->treatments()->latest()->first();
        abort_if(!$treatment, 404);

        $treatment->update([
            'status' => $validated['status'],
            'next_follow_up_at' => $validated['next_follow_up_at'] ?? null,
            'notes' => $validated['treatment_notes'] ?? null,
        ]);

        return back()->with('status', 'Status pengobatan pasien diperbarui.');
    }

    public function show(Request $request, User $patient)
    {
        abort_if($request->user()->role !== UserRole::Puskesmas, 403);
        abort_if($patient->role !== UserRole::Pasien, 404);

        $patient->loadMissing([
            'detail.supervisor.detail',
            'screenings' => fn($q) => $q->latest()->limit(1),
            'treatments' => fn($q) => $q->latest(),
            'familyMembers' => fn($q) => $q->orderBy('name'),
        ]);

        $kader = optional($patient->detail)->supervisor;
        abort_if(!$kader, 404);
        abort_if(optional($kader->detail)->supervisor_id !== $request->user()->id, 403);

        $familyStatuses = [
            'pending' => ['label' => 'Belum Ditindaklanjuti', 'badge' => 'bg-gradient-secondary'],
            'in_progress' => ['label' => 'Dalam Pemantauan', 'badge' => 'bg-gradient-warning text-dark'],
            'suspect' => ['label' => 'Suspek TBC', 'badge' => 'bg-gradient-danger'],
            'clear' => ['label' => 'Tidak Ada Gejala', 'badge' => 'bg-gradient-success'],
        ];

        $treatment = $patient->treatments->first();

        return view('puskesmas.treatment-detail', [
            'patient' => $patient,
            'treatment' => $treatment,
            'familyStatuses' => $familyStatuses,
        ]);
    }

    public function store(Request $request)
    {
        abort_if($request->user()->role !== UserRole::Puskesmas, 403);

        $validated = $request->validate([
            'patient_id' => ['required', 'exists:users,id'],
            'status' => ['required', 'in:contacted,scheduled,in_treatment,recovered'],
            'next_follow_up_at' => ['nullable', 'date'],
            'treatment_notes' => ['nullable', 'string', 'max:1000'],
        ]);

        $patient = User::query()
            ->with(['detail.supervisor.detail', 'treatments'])
            ->where('role', UserRole::Pasien->value)
            ->findOrFail($validated['patient_id']);

        $kader = optional($patient->detail)->supervisor;
        abort_if(!$kader, 404);
        abort_if(optional($kader->detail)->supervisor_id !== $request->user()->id, 403);

        abort_if($patient->treatments()->exists(), 422, 'Pasien sudah ada dalam daftar pengobatan.');

        FamilyTreatment::ensure(
            $patient,
            $validated['status'],
            $validated['next_follow_up_at'] ?? null,
            $validated['treatment_notes'] ?? null,
        );

        return back()->with('status', 'Pasien ditambahkan ke daftar pengobatan.');
    }
}
