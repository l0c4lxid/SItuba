@extends('layouts.soft')

@section('content')
    <div class="row">
        <div class="col-12">
            <div class="card shadow-sm border-0">
                <div class="card-header d-flex flex-wrap gap-3 justify-content-between align-items-center">
                    <div>
                        <h5 class="mb-0">Data Pasien Binaan</h5>
                        <p class="text-sm text-muted mb-0">Menampilkan warga yang terdaftar dengan kader ini.</p>
                    </div>
                    <div class="d-flex flex-wrap gap-2">
                        <a href="{{ route('kader.patients.create') }}" class="btn btn-sm btn-primary">
                            <i class="fa fa-plus me-1"></i> Tambah Pasien
                        </a>
                        <form method="GET" action="{{ route('kader.patients') }}" class="d-flex gap-2">
                            <div class="input-group input-group-sm">
                                <span class="input-group-text bg-white"><i class="fa fa-search text-muted"></i></span>
                                <input type="text" name="q" class="form-control" placeholder="Cari nama / nomor HP / alamat" value="{{ $search ?? '' }}">
                            </div>
                            <button type="submit" class="btn btn-sm btn-outline-primary">Cari</button>
                        </form>
                    </div>
                </div>
                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table align-items-center mb-0">
                            <thead>
                                <tr>
                                    <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">Nama</th>
                                    <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7 ps-2">Kontak</th>
                                    <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7 ps-2">Alamat</th>
                                    <th class="text-center text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">NIK</th>
                                    <th class="text-center text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">Didaftarkan</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse ($patients as $patient)
                                    <tr>
                                        <td>
                                            <div class="d-flex align-items-center gap-3">
                                                <div class="icon icon-shape bg-gradient-info shadow text-center border-radius-md">
                                                    <i class="fa-solid fa-user text-white"></i>
                                                </div>
                                                <div>
                                                    <h6 class="mb-0 text-sm">{{ $patient->name }}</h6>
                                                    <p class="text-xs text-muted mb-0">{{ $patient->detail->organization ?? 'Pasien' }}</p>
                                                </div>
                                            </div>
                                        </td>
                                        <td>
                                            <p class="text-xs mb-0">HP utama: {{ $patient->phone }}</p>
                                            @if ($patient->detail?->phone)
                                                <p class="text-xs text-muted mb-0">Alternatif: {{ $patient->detail->phone }}</p>
                                            @endif
                                        </td>
                                        <td>
                                            <p class="text-xs mb-0">{{ $patient->detail->address ?? '-' }}</p>
                                        </td>
                                        <td class="text-center">
                                            <span class="text-xs font-weight-bold">{{ $patient->detail->nik ?? '-' }}</span>
                                        </td>
                                        <td class="text-center">
                                            <span class="text-xs text-muted">{{ $patient->created_at->format('d M Y') }}</span>
                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="5" class="text-center py-4 text-muted">Belum ada pasien binaan.</td>
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
