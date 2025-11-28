@extends('layouts.soft')

@section('content')
    <div class="row">
        <div class="col-12">
            <div class="card shadow-sm border-0">
                <div class="card-header d-flex flex-wrap gap-3 justify-content-between align-items-center">
                    <div>
                        <h5 class="mb-0">Data Kader Mitra</h5>
                        <p class="text-sm text-muted mb-0">Daftar kader yang bekerja sama dengan puskesmas ini.</p>
                    </div>
                    <form method="GET" action="{{ route('puskesmas.kaders') }}" class="d-flex flex-wrap gap-2 align-items-center">
                        <div class="input-group input-group-sm" style="min-width: 250px;">
                            <span class="input-group-text bg-white"><i class="fa fa-search text-muted"></i></span>
                            <input type="text" name="q" class="form-control" placeholder="Cari nama / nomor HP / catatan" value="{{ $search ?? '' }}">
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
                                    <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">Nama Kader</th>
                                    <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7 ps-2">Kontak</th>
                                    <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7 ps-2">Catatan</th>
                                    <th class="text-center text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">Status</th>
                                    <th class="text-center text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">Didaftarkan</th>
                                </tr>
                            </thead>
                            <tbody>
                                @php
                                    $firstNumber = method_exists($kaders, 'firstItem') ? $kaders->firstItem() : null;
                                @endphp
                                @forelse ($kaders as $kader)
                                    <tr>
                                        <td>{{ $firstNumber ? $firstNumber + $loop->index : $loop->iteration }}</td>
                                        <td>
                                            <h6 class="mb-0 text-sm">{{ $kader->name }}</h6>
                                            <p class="text-xs text-muted mb-0">{{ $kader->detail->organization ?? 'Kader' }}</p>
                                        </td>
                                        <td>
                                            <p class="text-xs mb-0">Nomor HP: {{ $kader->phone }}</p>
                                        </td>
                                        <td>
                                            <p class="text-xs mb-0">{{ $kader->detail->notes ?? '-' }}</p>
                                        </td>
                                        <td class="text-center">
                                            @if ($kader->is_active)
                                                <span class="badge bg-gradient-success text-white">Aktif</span>
                                            @else
                                                <span class="badge bg-gradient-warning text-dark">Tidak Aktif</span>
                                            @endif
                                        </td>
                                        <td class="text-center">
                                            <span class="text-xs text-muted">{{ $kader->created_at->format('d M Y') }}</span>
                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="6" class="text-center py-4 text-muted">Belum ada kader mitra.</td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                    @php
                        $hasPagination = method_exists($kaders, 'firstItem');
                        $from = $hasPagination ? $kaders->firstItem() : ($kaders->count() ? 1 : 0);
                        $to = $hasPagination ? $kaders->lastItem() : $kaders->count();
                        $total = $hasPagination ? $kaders->total() : $kaders->count();
                    @endphp
                    <div class="d-flex flex-wrap justify-content-between align-items-center gap-2 mt-3">
                        <p class="text-sm text-muted mb-0">
                            Menampilkan <span class="fw-semibold">{{ $from }}</span> - <span class="fw-semibold">{{ $to }}</span> dari <span class="fw-semibold">{{ $total }}</span> kader
                        </p>
                        @if ($hasPagination)
                            <div class="mb-0">
                                {{ $kaders->withQueryString()->onEachSide(1)->links('pagination::bootstrap-5') }}
                            </div>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
