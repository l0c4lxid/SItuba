@extends('layouts.soft')

@section('content')
    <div class="row">
        <div class="col-12">
            <div class="card shadow-sm border-0">
                <div class="card-header d-flex flex-wrap gap-3 justify-content-between align-items-center">
                    <div>
                        <h5 class="mb-0">Data Pasien SIGAP TBC</h5>
                        <p class="text-sm text-muted mb-0">Pemda dapat memonitor seluruh pasien beserta relasi kader dan puskesmas.</p>
                    </div>
                    <form method="GET" action="{{ route('pemda.patients') }}" class="d-flex gap-2">
                        <div class="input-group input-group-sm">
                            <span class="input-group-text bg-white"><i class="fa fa-search text-muted"></i></span>
                            <input type="text" name="q" class="form-control" placeholder="Cari nama / nomor HP / alamat" value="{{ $search ?? '' }}">
                        </div>
                        <button type="submit" class="btn btn-sm btn-outline-primary">Cari</button>
                    </form>
                </div>
                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table align-items-center mb-0">
                            <thead>
                                <tr>
                                    <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">#</th>
                                    <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">Nama</th>
                                    <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7 ps-2">Kontak</th>
                                    <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7 ps-2">Alamat</th>
                                    <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7 ps-2">Kader</th>
                                    <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7 ps-2">Puskesmas</th>
                                    <th class="text-center text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">Status</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse ($patients as $patient)
                                    @php
                                        $kader = optional($patient->detail)->supervisor;
                                        $puskesmas = optional($kader?->detail)->supervisor;
                                    @endphp
                                    <tr>
                                        <td>{{ $loop->iteration }}</td>
                                        <td>
                                            <h6 class="mb-0 text-sm">{{ $patient->name }}</h6>
                                            <p class="text-xs text-muted mb-0">NIK: {{ $patient->detail->nik ?? '-' }}</p>
                                        </td>
                                        <td>
                                            <p class="text-xs mb-0">Nomor HP: {{ $patient->phone }}</p>
                                        </td>
                                        <td>
                                            <p class="text-xs mb-0">{{ $patient->detail->address ?? '-' }}</p>
                                        </td>
                                        <td>
                                            @if ($kader)
                                                <div class="d-flex flex-column">
                                                    <span class="text-sm fw-semibold">{{ $kader->name }}</span>
                                                    <span class="text-xs text-muted">HP: {{ $kader->phone }}</span>
                                                </div>
                                            @else
                                                <span class="text-xs text-muted">Belum ada kader</span>
                                            @endif
                                        </td>
                                        <td>
                                            @if ($puskesmas)
                                                <div class="d-flex flex-column">
                                                    <span class="text-sm fw-semibold">{{ $puskesmas->name }}</span>
                                                    <span class="text-xs text-muted">{{ $puskesmas->detail->address ?? '-' }}</span>
                                                </div>
                                            @else
                                                <span class="text-xs text-muted">Belum terhubung</span>
                                            @endif
                                        </td>
                                        <td class="text-center">
                                            @if ($patient->is_active)
                                                <span class="badge bg-gradient-success text-white">Aktif</span>
                                            @else
                                                <span class="badge bg-gradient-warning text-dark">Tidak Aktif</span>
                                            @endif
                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="7" class="text-center py-4 text-muted">Belum ada data pasien.</td>
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
