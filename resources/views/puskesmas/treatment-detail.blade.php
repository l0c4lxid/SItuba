@extends('layouts.soft')

@section('content')
    <div class="row">
        <div class="col-12 mb-3 d-flex justify-content-between align-items-center flex-wrap gap-2">
            <div>
                <a href="{{ route('puskesmas.treatment') }}" class="btn btn-sm btn-outline-secondary">
                    <i class="fa fa-arrow-left"></i> Kembali ke daftar
                </a>
            </div>
            <div class="d-flex gap-2">
                <a href="{{ route('puskesmas.patient.family', $patient) }}" class="btn btn-sm btn-outline-primary">
                    Kelola Anggota Keluarga
                </a>
            </div>
        </div>

        <div class="col-lg-6 mb-4">
            <div class="card shadow-sm border-0 h-100">
                <div class="card-header">
                    <h6 class="mb-0">Profil Pasien</h6>
                    <p class="text-sm text-muted mb-0">Identitas dan kontak pasien binaan.</p>
                </div>
                <div class="card-body">
                    <div class="mb-3">
                        <p class="text-xs text-muted mb-1">Nama</p>
                        <h6 class="mb-0">{{ $patient->name }}</h6>
                        <p class="text-xs text-muted mb-0">{{ $patient->phone }}</p>
                    </div>
                    <div class="mb-3">
                        <p class="text-xs text-muted mb-1">Alamat</p>
                        <p class="mb-0">{{ $patient->detail->address ?? '-' }}</p>
                    </div>
                    <div class="mb-3">
                        <p class="text-xs text-muted mb-1">Kader Penghubung</p>
                        <p class="mb-0 fw-semibold">{{ optional($patient->detail->supervisor)->name ?? '-' }}</p>
                        <p class="text-xs text-muted mb-0">{{ optional($patient->detail->supervisor)->phone ?? '-' }}</p>
                    </div>
                    <div>
                        <p class="text-xs text-muted mb-1">Hasil Skrining Terakhir</p>
                        @php
                            $latestScreening = $patient->screenings->first();
                            $positiveCount = $latestScreening ? collect($latestScreening->answers ?? [])->where('ya')->count() : 0;
                        @endphp
                        @if ($latestScreening)
                            <span class="badge bg-gradient-{{ $positiveCount >= 2 ? 'danger' : ($positiveCount === 1 ? 'warning text-dark' : 'success') }}">
                                {{ $positiveCount }} indikasi "Ya"
                            </span>
                            <p class="text-xs text-muted mb-0">{{ $latestScreening->created_at->format('d M Y H:i') }}</p>
                        @else
                            <span class="badge bg-gradient-secondary">Belum ada skrining</span>
                        @endif
                    </div>
                </div>
            </div>
        </div>

        <div class="col-lg-6 mb-4">
            <div class="card shadow-sm border-0 h-100">
                <div class="card-header d-flex justify-content-between align-items-center">
                    <div>
                        <h6 class="mb-0">Perbarui Status Pengobatan</h6>
                        <p class="text-sm text-muted mb-0">Catat progres kunjungan dan jadwal kontrol.</p>
                    </div>
                    @if ($treatment)
                        <span class="badge bg-gradient-info">{{ ucfirst(str_replace('_', ' ', $treatment->status)) }}</span>
                    @endif
                </div>
                <div class="card-body">
                    @if ($treatment)
                        <form method="POST" action="{{ route('puskesmas.treatment.update', $patient) }}" class="row g-3">
                            @csrf
                            <div class="col-12">
                                <label class="form-label">Status Pengobatan</label>
                                <select name="status" class="form-select">
                                    @foreach (['contacted' => 'Sudah Dihubungi', 'scheduled' => 'Terjadwal Datang', 'in_treatment' => 'Sedang Berobat', 'recovered' => 'Selesai / Sembuh'] as $value => $label)
                                        <option value="{{ $value }}" @selected($treatment->status === $value)>{{ $label }}</option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="col-md-6">
                                <label class="form-label">Jadwal Kontrol Berikutnya</label>
                                <input type="date" name="next_follow_up_at" class="form-control" value="{{ optional($treatment->next_follow_up_at)->toDateString() }}">
                            </div>
                            <div class="col-12">
                                <label class="form-label">Catatan</label>
                                <textarea name="treatment_notes" rows="3" class="form-control">{{ $treatment->notes }}</textarea>
                            </div>
                            <div class="col-12 d-flex justify-content-end">
                                <button type="submit" class="btn btn-success">Simpan</button>
                            </div>
                        </form>
                    @else
                        <p class="text-muted mb-0">Tidak ada data pengobatan untuk pasien ini.</p>
                    @endif
                </div>
            </div>
        </div>

        <div class="col-12 mb-4">
            <div class="card shadow-sm border-0">
                <div class="card-header d-flex justify-content-between align-items-center">
                    <div>
                        <h6 class="mb-0">Riwayat Pengobatan</h6>
                        <p class="text-sm text-muted mb-0">Log perubahan status dan jadwal kontrol.</p>
                    </div>
                    <span class="badge bg-gradient-primary">{{ $patient->treatments->count() }} catatan</span>
                </div>
                <div class="card-body">
                    @if ($patient->treatments->isEmpty())
                        <p class="text-muted mb-0">Belum ada riwayat.</p>
                    @else
                        <div class="table-responsive">
                            <table class="table align-items-center">
                                <thead>
                                    <tr>
                                        <th>Status</th>
                                        <th>Catatan</th>
                                        <th>Jadwal Kontrol</th>
                                        <th>Diperbarui</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($patient->treatments as $history)
                                        <tr>
                                            <td>
                                                <span class="badge bg-gradient-info">{{ ucfirst(str_replace('_', ' ', $history->status)) }}</span>
                                                @if ($history->completed_at)
                                                    <span class="text-xs text-muted d-block">Selesai {{ $history->completed_at->format('d M Y') }}</span>
                                                @endif
                                            </td>
                                            <td>{{ $history->notes ?? '-' }}</td>
                                            <td>{{ optional($history->next_follow_up_at)->format('d M Y') ?? '-' }}</td>
                                            <td class="text-xs text-muted">{{ $history->updated_at->format('d M Y H:i') }}</td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    @endif
                </div>
            </div>
        </div>

        <div class="col-12">
            <div class="card shadow-sm border-0">
                <div class="card-header d-flex justify-content-between align-items-center">
                    <div>
                        <h6 class="mb-0">Detail Keluarga</h6>
                        <p class="text-sm text-muted mb-0">Pantau status skrining anggota keluarga.</p>
                    </div>
                    <a href="{{ route('puskesmas.patient.family', $patient) }}" class="btn btn-sm btn-outline-primary">Kelola di Halaman Anggota</a>
                </div>
                <div class="card-body">
                    @if ($patient->familyMembers->isEmpty())
                        <p class="text-muted mb-0">Belum ada anggota keluarga yang tercatat.</p>
                    @else
                        <div class="table-responsive">
                            <table class="table table-sm align-middle">
                                <thead>
                                    <tr>
                                        <th>Nama</th>
                                        <th>NIK</th>
                                        <th>Relasi</th>
                                        <th>Kontak</th>
                                        <th>Status Skrining</th>
                                        <th>Skrining Terakhir</th>
                                        <th>Ubah Status</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($patient->familyMembers as $member)
                                        @php
                                            $memberStatusKey = $member->screening_status ?? 'pending';
                                            $familyStatus = $familyStatuses[$memberStatusKey] ?? [
                                                'label' => ucfirst(str_replace('_', ' ', $memberStatusKey)),
                                                'badge' => 'bg-gradient-secondary',
                                            ];
                                        @endphp
                                        <tr>
                                            <td>
                                                <div class="fw-semibold">{{ $member->name }}</div>
                                                @if ($member->notes)
                                                    <div class="text-xs text-muted">{{ $member->notes }}</div>
                                                @endif
                                            </td>
                                            <td>{{ $member->nik ?? '-' }}</td>
                                            <td>{{ $member->relation ?? '-' }}</td>
                                            <td>{{ $member->phone ?? '-' }}</td>
                                            <td>
                                                <span class="badge {{ $familyStatus['badge'] ?? 'bg-gradient-secondary' }}">{{ $familyStatus['label'] }}</span>
                                                @if ($member->converted_user_id)
                                                    <span class="badge bg-gradient-success ms-1">Sudah jadi pasien</span>
                                                @endif
                                            </td>
                                            <td>
                                                @if ($member->last_screened_at)
                                                    <span class="text-xs text-muted">{{ $member->last_screened_at->format('d M Y H:i') }}</span>
                                                @else
                                                    <span class="text-xs text-muted">Belum ada</span>
                                                @endif
                                            </td>
                                            <td>
                                                <form method="POST" action="{{ route('puskesmas.patient.family.update', [$patient, $member]) }}" class="d-flex flex-wrap gap-2 align-items-center">
                                                    @csrf
                                                    <select name="screening_status" class="form-select form-select-sm">
                                                        @foreach ($familyStatuses as $value => $config)
                                                            <option value="{{ $value }}" @selected($member->screening_status === $value)>{{ $config['label'] }}</option>
                                                        @endforeach
                                                    </select>
                                                    <button type="submit" class="btn btn-sm btn-primary">Simpan</button>
                                                </form>
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
@endsection
