<?php

namespace App\Http\Controllers\Kader;

use App\Enums\UserRole;
use App\Http\Controllers\Controller;
use App\Models\PatientScreening;
use App\Models\User;
use App\Models\UserDetail;
use App\Support\FamilyTreatment;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rule;

class PatientController extends Controller
{
    public function index(Request $request)
    {
        abort_if(auth()->user()->role !== UserRole::Kader, 403);

        $perPage = 10;

        $patients = User::query()
            ->with(['detail', 'screenings' => fn($query) => $query->latest()])
            ->where('role', UserRole::Pasien->value)
            ->whereRelation('detail', 'supervisor_id', $request->user()->id)
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

        return view('kader.patients', [
            'patients' => $patients,
            'search' => $request->input('q', ''),
        ]);
    }

    public function screeningIndex(Request $request)
    {
        abort_if(auth()->user()->role !== UserRole::Kader, 403);

        $perPage = 10;
        $patientsQuery = User::query()
            ->with([
                'detail.supervisor.detail.supervisor',
                'screenings' => fn($query) => $query->latest()->limit(1),
                'treatments' => fn($query) => $query->latest()->limit(1),
                'familyMembers' => fn($query) => $query->orderBy('name'),
            ])
            ->where('role', UserRole::Pasien->value)
            ->whereRelation('detail', 'supervisor_id', $request->user()->id)
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
            });

        $status = $request->input('status');
        if ($status === 'belum') {
            $patientsQuery->doesntHave('screenings');
        } elseif ($status === 'sudah') {
            $patientsQuery->has('screenings');
        }

        $patients = $patientsQuery->latest()->paginate($perPage)->withQueryString();

        return view('kader.screening-index', [
            'patients' => $patients,
            'search' => $request->input('q', ''),
            'status' => $status,
        ]);
    }

    public function create(Request $request)
    {
        abort_if(auth()->user()->role !== UserRole::Kader, 403);

        $kader = $request->user();

        return view('kader.patients-create', [
            'kader' => $kader,
        ]);
    }

    public function store(Request $request)
    {
        abort_if(auth()->user()->role !== UserRole::Kader, 403);

        $kader = $request->user();

        $validated = $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'phone' => ['required', 'string', 'max:25', Rule::unique('users', 'phone')],
            'nik' => ['required', 'string', 'max:30', Rule::unique('user_details', 'nik')],
            'address' => ['required', 'string', 'max:255'],
        ]);

        $password = 'tbc' . random_int(1000, 9999);

        $user = User::create([
            'name' => $validated['name'],
            'phone' => $validated['phone'],
            'role' => UserRole::Pasien,
            'password' => Hash::make($password),
            'is_active' => true,
        ]);

        UserDetail::create([
            'user_id' => $user->id,
            'nik' => $validated['nik'],
            'address' => $validated['address'],
            'supervisor_id' => $kader->id,
            'initial_password' => $password,
        ]);

        return redirect()->route('kader.patients')->with('status', 'Pasien baru berhasil dibuat. Password sementara: ' . $password);
    }

    public function show(Request $request, User $patient)
    {
        abort_if($request->user()->role !== UserRole::Kader, 403);
        abort_if($patient->role !== UserRole::Pasien, 404);

        $patient->loadMissing(['detail', 'familyMembers']);
        abort_if(optional($patient->detail)->supervisor_id !== $request->user()->id, 404);

        return view('kader.patients-show', [
            'patient' => $patient,
        ]);
    }

    public function storeFamily(Request $request, User $patient)
    {
        abort_if($request->user()->role !== UserRole::Kader, 403);
        abort_if($patient->role !== UserRole::Pasien, 404);

        $patient->loadMissing('detail');
        abort_if(optional($patient->detail)->supervisor_id !== $request->user()->id, 404);

        $validated = $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'relation' => ['nullable', 'string', 'max:100'],
            'nik' => ['nullable', 'string', 'max:30'],
            'phone' => ['nullable', 'string', 'max:25'],
            'notes' => ['nullable', 'string', 'max:1000'],
        ]);

        $patient->familyMembers()->create($validated);

        return back()->with('status', 'Anggota keluarga risiko berhasil ditambahkan.');
    }

    public function family(Request $request, User $patient)
    {
        abort_if($request->user()->role !== UserRole::Kader, 403);
        abort_if($patient->role !== UserRole::Pasien, 404);

        $patient->loadMissing(['detail', 'familyMembers' => fn($query) => $query->latest()]);
        abort_if(optional($patient->detail)->supervisor_id !== $request->user()->id, 404);

        return view('kader.patient-family', [
            'patient' => $patient,
            'familyMembers' => $patient->familyMembers,
        ]);
    }

    public function screeningForm(Request $request, User $patient)
    {
        abort_if($request->user()->role !== UserRole::Kader, 403);
        abort_if($patient->role !== UserRole::Pasien, 404);

        $patient->loadMissing('detail');
        abort_if(optional($patient->detail)->supervisor_id !== $request->user()->id, 404);

        if ($patient->screenings()->exists()) {
            return redirect()->route('kader.screening.index')->with('status', 'Pasien ini sudah pernah dilakukan skrining.');
        }

        $questions = [
            'batuk_kronis' => 'Apakah pasien batuk lebih dari 2 minggu?',
            'dahak_darah' => 'Apakah batuk mengeluarkan dahak berdarah?',
            'berat_badan' => 'Apakah berat badan turun tanpa sebab jelas?',
            'demam_malam' => 'Apakah sering demam atau berkeringat di malam hari?',
        ];

        return view('kader.patients-screening', [
            'patient' => $patient,
            'questions' => $questions,
        ]);
    }

    public function storeScreening(Request $request, User $patient)
    {
        abort_if($request->user()->role !== UserRole::Kader, 403);
        abort_if($patient->role !== UserRole::Pasien, 404);

        $patient->loadMissing('detail');
        abort_if(optional($patient->detail)->supervisor_id !== $request->user()->id, 404);

        if ($patient->screenings()->exists()) {
            return redirect()->route('kader.screening.index')->with('status', 'Pasien ini sudah pernah dilakukan skrining.');
        }

        $questions = [
            'batuk_kronis' => 'Apakah pasien batuk lebih dari 2 minggu?',
            'dahak_darah' => 'Apakah batuk mengeluarkan dahak berdarah?',
            'berat_badan' => 'Apakah berat badan turun tanpa sebab jelas?',
            'demam_malam' => 'Apakah sering demam atau berkeringat di malam hari?',
        ];

        $rules = [];
        foreach ($questions as $key => $label) {
            $rules[$key] = ['required', 'in:ya,tidak'];
        }

        $validated = $request->validate($rules);

        $patient->detail ?? UserDetail::create(['user_id' => $patient->id, 'supervisor_id' => $request->user()->id]);

        PatientScreening::create([
            'patient_id' => $patient->id,
            'kader_id' => $request->user()->id,
            'answers' => $validated,
            'notes' => null,
        ]);

        $positiveCount = collect($validated)->filter(fn($answer) => $answer === 'ya')->count();
        if ($positiveCount >= 2) {
            FamilyTreatment::ensure($patient, 'contacted');
        }

        return redirect()->route('kader.patients')->with('status', 'Skrining pasien telah dicatat.');
    }

    public function updateStatus(Request $request, User $patient)
    {
        abort_if($request->user()->role !== UserRole::Kader, 403);
        abort_if($patient->role !== UserRole::Pasien, 404);

        $patient->loadMissing('detail');
        abort_if(optional($patient->detail)->supervisor_id !== $request->user()->id, 404);

        $validated = $request->validate([
            'status' => ['required', 'in:active,inactive'],
        ]);

        $patient->is_active = $validated['status'] === 'active';
        $patient->save();

        return back()->with('status', 'Status akun pasien diperbarui.');
    }
}
