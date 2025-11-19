@extends('layouts.soft')

@php
    $treatmentStatuses = [
        'contacted' => ['label' => 'Perlu Konfirmasi', 'badge' => 'bg-gradient-warning text-dark'],
        'scheduled' => ['label' => 'Terjadwal', 'badge' => 'bg-gradient-info'],
        'in_treatment' => ['label' => 'Sedang Berobat', 'badge' => 'bg-gradient-primary'],
        'recovered' => ['label' => 'Selesai', 'badge' => 'bg-gradient-success'],
    ];
    $familyStatusBadges = [
        'pending' => 'bg-gradient-secondary',
        'in_progress' => 'bg-gradient-warning text-dark',
        'suspect' => 'bg-gradient-danger',
        'clear' => 'bg-gradient-success',
    ];
@endphp

@section('content')
    <div class="row">
        <div class="col-lg-6 mb-4">
            <div class="card shadow-sm border-0 h-100">
                <div class="card-header">
                    <h5 class="mb-0">Profil Pasien</h5>
                    <p class="text-sm text-muted mb-0">Informasi akun dan kontak pasien.</p>
                </div>
                <div class="card-body">
                    <div class="mb-3">
                        <label class="text-xs text-muted">Nama</label>
                        <p class="mb-0 fw-semibold">{{ $patient->name }}</p>
                    </div>
                    <div class="mb-3">
                        <label class="text-xs text-muted">Nomor HP</label>
                        <p class="mb-0">{{ $patient->phone }}</p>
                    </div>
                    <div class="mb-3">
                        <label class="text-xs text-muted">NIK</label>
                        <p class="mb-0">{{ $patient->detail->nik ?? '-' }}</p>
                    </div>
                    <div class="mb-3">
                        <label class="text-xs text-muted">Alamat</label>
                        <p class="mb-0">{{ $patient->detail->address ?? '-' }}</p>
                    </div>
                    <div class="mb-3">
                        <label class="text-xs text-muted">Status Akun</label>
                        <p class="mb-0">
                            <span class="badge {{ $patient->is_active ? 'bg-gradient-success' : 'bg-gradient-warning text-dark' }}">
                                {{ $patient->is_active ? 'Aktif' : 'Tidak Aktif' }}
                            </span>
                        </p>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-lg-6 mb-4">
            <div class="card shadow-sm border-0 h-100">
                <div class="card-header">
                    <h5 class="mb-0">Relasi Kader & Puskesmas</h5>
                    <p class="text-sm text-muted mb-0">Jejaring pendamping pasien.</p>
                </div>
                <div class="card-body">
                    <div class="mb-4">
                        <label class="text-xs text-muted">Kader Pendamping</label>
                        @if ($kader)
                            <p class="mb-0 fw-semibold">{{ $kader->name }} <span class="text-muted">(HP: {{ $kader->phone }})</span></p>
                        @else
                            <p class="mb-0 text-muted">Belum ditetapkan.</p>
                        @endif
                    </div>
                    <div>
                        <label class="text-xs text-muted">Puskesmas Induk</label>
                        @if ($puskesmas)
                            <p class="mb-0 fw-semibold">{{ $puskesmas->name }}</p>
                            <p class="text-xs text-muted mb-0">{{ $puskesmas->detail->address ?? '-' }}</p>
                        @else
                            <p class="mb-0 text-muted">Belum terhubung dengan Puskesmas.</p>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="row">
        <div class="col-lg-6 mb-4">
            <div class="card shadow-sm border-0 h-100">
                <div class="card-header">
                    <h5 class="mb-0">Riwayat Skrining</h5>
                    <p class="text-sm text-muted mb-0">Skrining mandiri maupun oleh kader.</p>
                </div>
                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table table-sm align-items-center mb-0">
                            <thead>
                                <tr>
                                    <th>Waktu</th>
                                    <th>Positif</th>
                                    <th>Petugas</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse ($patient->screenings as $screening)
                                    @php
                                        $positiveCount = collect($screening->answers ?? [])->filter(fn($ans) => $ans === 'ya')->count();
                                    @endphp
                                    <tr>
                                        <td class="text-xs text-muted">{{ $screening->created_at->format('d M Y H:i') }}</td>
                                        <td>
                                            <span class="badge bg-gradient-{{ $positiveCount >= 2 ? 'danger' : ($positiveCount === 1 ? 'warning text-dark' : 'success') }}">
                                                {{ $positiveCount }} ya
                                            </span>
                                        </td>
                                        <td class="text-xs text-muted">{{ $screening->kader->name ?? 'Mandiri' }}</td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="3" class="text-center text-muted">Belum ada data skrining.</td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-lg-6 mb-4">
            <div class="card shadow-sm border-0 h-100">
                <div class="card-header">
                    <h5 class="mb-0">Riwayat Pengobatan</h5>
                    <p class="text-sm text-muted mb-0">Catatan tindak lanjut dari Puskesmas.</p>
                </div>
                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table table-sm align-items-center mb-0">
                            <thead>
                                <tr>
                                    <th>Status</th>
                                    <th>Jadwal / Catatan</th>
                                    <th>Diperbarui</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse ($patient->treatments as $treatment)
                                    @php
                                        $statusInfo = $treatmentStatuses[$treatment->status] ?? ['label' => ucfirst(str_replace('_', ' ', $treatment->status)), 'badge' => 'bg-gradient-info'];
                                    @endphp
                                    <tr>
                                        <td>
                                            <span class="badge {{ $statusInfo['badge'] }}">{{ $statusInfo['label'] }}</span>
                                        </td>
                                        <td class="text-xs">
                                            <div>Jadwal: {{ optional($treatment->next_follow_up_at)->format('d M Y') ?? 'Belum' }}</div>
                                            @if ($treatment->notes)
                                                <div>Catatan: {{ $treatment->notes }}</div>
                                            @endif
                                        </td>
                                        <td class="text-xs text-muted">{{ $treatment->updated_at->format('d M Y H:i') }}</td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="3" class="text-center text-muted">Belum ada catatan pengobatan.</td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="row">
        <div class="col-12">
            <div class="card shadow-sm border-0">
                <div class="card-header">
                    <h5 class="mb-0">Anggota Keluarga</h5>
                    <p class="text-sm text-muted mb-0">Pemda dapat memonitor status keluarga yang sudah disaring.</p>
                </div>
                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table align-items-center mb-0">
                            <thead>
                                <tr>
                                    <th>Nama</th>
                                    <th>Kontak</th>
                                    <th>Status Skrining</th>
                                    <th>Catatan</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse ($patient->familyMembers as $member)
                                    <tr>
                                        <td>
                                            <strong>{{ $member->name }}</strong>
                                            <p class="text-xs text-muted mb-0">Relasi: {{ $member->relation ?? '-' }}</p>
                                        </td>
                                        <td>
                                            <p class="text-xs text-muted mb-0">{{ $member->phone ?? '-' }}</p>
                                            @if ($member->nik)
                                                <p class="text-xs text-muted mb-0">NIK: {{ $member->nik }}</p>
                                            @endif
                                        </td>
                                        <td>
                                            <span class="badge {{ $familyStatusBadges[$member->screening_status] ?? 'bg-secondary' }}">
                                                {{ ucfirst(str_replace('_', ' ', $member->screening_status ?? 'pending')) }}
                                            </span>
                                            @if ($member->last_screened_at)
                                                <p class="text-xs text-muted mb-0">Terakhir: {{ $member->last_screened_at->format('d M Y H:i') }}</p>
                                            @endif
                                        </td>
                                        <td>{{ $member->notes ?? '-' }}</td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="4" class="text-center text-muted">Belum ada anggota keluarga yang dicatat.</td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
