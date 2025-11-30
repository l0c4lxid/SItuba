<?php

namespace App\Http\Controllers\Puskesmas;

use App\Enums\UserRole;
use App\Http\Controllers\Controller;
use App\Models\FamilyMember;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Pagination\LengthAwarePaginator;

class PatientController extends Controller
{
    public function index(Request $request)
    {
        abort_if($request->user()->role !== UserRole::Puskesmas, 403);

        $perPage = 10;
        $kaderIds = User::query()
            ->where('role', UserRole::Kader->value)
            ->whereHas('detail', fn($detail) => $detail->where('supervisor_id', $request->user()->id))
            ->pluck('id')
            ->all();

        $patients = empty($kaderIds)
            ? new LengthAwarePaginator([], 0, $perPage, 1, [
                'path' => $request->url(),
                'query' => $request->query(),
            ])
            : User::query()
                ->with(['detail', 'detail.supervisor'])
                ->where('role', UserRole::Pasien->value)
                ->whereHas('detail', fn($detail) => $detail->whereIn('supervisor_id', $kaderIds))
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

        return view('puskesmas.patients', [
            'patients' => $patients,
            'search' => $request->input('q', ''),
        ]);
    }

    public function family(Request $request, User $patient)
    {
        abort_if($request->user()->role !== UserRole::Puskesmas, 403);
        abort_if($patient->role !== UserRole::Pasien, 404);

        $patient->loadMissing(['detail.supervisor.detail', 'familyMembers']);

        $kader = optional($patient->detail)->supervisor;
        abort_if(!$kader, 404);
        abort_if(optional($kader->detail)->supervisor_id !== $request->user()->id, 403);

        return view('puskesmas.patient-family', [
            'patient' => $patient,
            'familyMembers' => $patient->familyMembers()->latest()->get(),
        ]);
    }

    public function updateFamilyMember(Request $request, User $patient, FamilyMember $member)
    {
        abort_if($request->user()->role !== UserRole::Puskesmas, 403);
        abort_if($patient->role !== UserRole::Pasien, 404);
        abort_if($member->patient_id !== $patient->id, 404);

        $patient->loadMissing(['detail.supervisor.detail']);
        $kader = optional($patient->detail)->supervisor;
        abort_if(!$kader, 404);
        abort_if(optional($kader->detail)->supervisor_id !== $request->user()->id, 403);

        $validated = $request->validate([
            'screening_status' => ['required', 'in:pending,in_progress,suspect,clear'],
            'notes' => ['nullable', 'string', 'max:1000'],
        ]);

        $member->update($validated);

        return back()->with('status', 'Status anggota keluarga diperbarui.');
    }
}
