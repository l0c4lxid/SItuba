<?php

namespace App\Http\Controllers\Patient;

use App\Enums\UserRole;
use App\Http\Controllers\Controller;
use App\Models\FamilyMember;
use App\Models\PatientScreening;
use App\Support\FamilyTreatment;
use App\Support\SigapMaterial;
use Illuminate\Http\Request;

class PatientController extends Controller
{
    public function materials(Request $request)
    {
        abort_if($request->user()->role !== UserRole::Pasien, 403);

        return view('kader.materi', [
            'downloads' => SigapMaterial::downloads(),
        ]);
    }

    public function screeningForm(Request $request)
    {
        abort_if($request->user()->role !== UserRole::Pasien, 403);

        $questions = [
            'batuk_kronis' => 'Apakah Anda batuk lebih dari 2 minggu?',
            'dahak_darah' => 'Apakah batuk Anda mengeluarkan dahak berdarah?',
            'berat_badan' => 'Apakah berat badan Anda turun tanpa sebab jelas?',
            'demam_malam' => 'Apakah Anda sering demam atau berkeringat di malam hari?',
        ];

        $latestScreening = $request->user()->screenings()->latest()->first();

        return view('patient.screening', [
            'questions' => $questions,
            'screening' => $latestScreening,
        ]);
    }

    public function storeScreening(Request $request)
    {
        abort_if($request->user()->role !== UserRole::Pasien, 403);

        $user = $request->user()->loadMissing('detail');

        abort_if($user->screenings()->exists(), 403, 'Anda sudah melakukan skrining mandiri.');

        $kaderId = optional($user->detail)->supervisor_id;
        abort_if(empty($kaderId), 422, 'Data kader pendamping belum tersedia.');

        $questions = [
            'batuk_kronis',
            'dahak_darah',
            'berat_badan',
            'demam_malam',
        ];

        $rules = [];
        foreach ($questions as $key) {
            $rules[$key] = ['required', 'in:ya,tidak'];
        }

        $validated = $request->validate($rules);

        PatientScreening::create([
            'patient_id' => $user->id,
            'kader_id' => $kaderId,
            'answers' => $validated,
            'notes' => null,
        ]);

        $positiveCount = collect($validated)->filter(fn($answer) => $answer === 'ya')->count();
        if ($positiveCount >= 2) {
            FamilyTreatment::ensure($user, 'contacted');
        }

        return redirect()->route('patient.screening')->with('status', 'Terima kasih, skrining mandiri berhasil dikirim.');
    }

    public function family(Request $request)
    {
        abort_if($request->user()->role !== UserRole::Pasien, 403);

        $patient = $request->user()->loadMissing('familyMembers');

        return view('patient.family-members', [
            'patient' => $patient,
            'familyMembers' => $patient->familyMembers()->latest()->get(),
        ]);
    }

    public function storeFamily(Request $request)
    {
        abort_if($request->user()->role !== UserRole::Pasien, 403);

        $validated = $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'relation' => ['nullable', 'string', 'max:100'],
            'nik' => ['nullable', 'string', 'max:30'],
            'phone' => ['nullable', 'string', 'max:25'],
            'notes' => ['nullable', 'string', 'max:1000'],
        ]);

        $request->user()->familyMembers()->create($validated);

        return back()->with('status', 'Anggota keluarga berhasil ditambahkan.');
    }

    public function familyScreening(Request $request, FamilyMember $member)
    {
        abort_if($request->user()->role !== UserRole::Pasien, 403);
        abort_if($member->patient_id !== $request->user()->id, 404);

        $questions = [
            'batuk_kronis' => 'Apakah anggota batuk lebih dari 2 minggu?',
            'dahak_darah' => 'Apakah batuk mengeluarkan dahak berdarah?',
            'berat_badan' => 'Apakah berat badan turun tanpa sebab jelas?',
            'demam_malam' => 'Apakah sering demam/keringat malam?',
        ];

        return view('patient.family-screening', [
            'member' => $member,
            'questions' => $questions,
        ]);
    }

    public function storeFamilyScreening(Request $request, FamilyMember $member)
    {
        abort_if($request->user()->role !== UserRole::Pasien, 403);
        abort_if($member->patient_id !== $request->user()->id, 404);

        $questions = [
            'batuk_kronis',
            'dahak_darah',
            'berat_badan',
            'demam_malam',
        ];

        $rules = [];
        foreach ($questions as $key) {
            $rules[$key] = ['required', 'in:ya,tidak'];
        }

        $validated = $request->validate($rules);

        $positive = collect($validated)->filter(fn($answer) => $answer === 'ya')->count();
        $status = $positive >= 2 ? 'suspect' : ($positive === 1 ? 'in_progress' : 'clear');

        $member->update([
            'screening_status' => $status,
            'last_screening_answers' => $validated,
            'last_screened_at' => now(),
        ]);

        return redirect()->route('patient.family')->with('status', 'Hasil skrining anggota disimpan.');
    }

    public function puskesmasInfo(Request $request)
    {
        abort_if($request->user()->role !== UserRole::Pasien, 403);

        $patient = $request->user()->loadMissing([
            'detail.supervisor.detail.supervisor',
            'treatments' => fn($query) => $query->latest(),
        ]);

        $kader = optional($patient->detail)->supervisor;
        $puskesmas = optional($kader?->detail)->supervisor;
        if (!$puskesmas) {
            $puskesmas = optional(optional($patient->detail)->supervisor)->detail->supervisor;
        }

        return view('patient.puskesmas-info', [
            'patient' => $patient,
            'kader' => $kader,
            'puskesmas' => $puskesmas,
            'latestTreatment' => $patient->treatments->first(),
        ]);
    }
}
