@extends('layouts.soft')

@section('content')
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-header flex-wrap gap-3 d-flex justify-content-between align-items-center">
                    <div class="flex-grow-1">
                        <h5 class="mb-0">Verifikasi Pengguna SIGAP TBC</h5>
                        <p class="text-sm text-muted mb-0">Kelola status aktif pengguna sesuai kebutuhan wilayah.</p>
                    </div>
                    <form method="GET" action="{{ route('pemda.verification') }}" class="d-flex gap-2">
                        <div class="input-group">
                            <span class="input-group-text"><i class="fa fa-search"></i></span>
                            <input type="text" name="q" class="form-control" placeholder="Cari nama / nomor HP / instansi"
                                value="{{ $search ?? '' }}">
                        </div>
                        <button type="submit" class="btn btn-outline-primary">Cari</button>
                    </form>
                    @if (session('status'))
                        <span class="badge bg-gradient-success">{{ session('status') }}</span>
                    @endif
                </div>
                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table align-items-center mb-0">
                            <thead>
                                <tr>
                                    <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">Nama</th>
                                    <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7 ps-2">Peran</th>
                                    <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7 ps-2">Kontak</th>
                                    <th class="text-center text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">Dibuat</th>
                                    <th class="text-center text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">Status</th>
                                    <th></th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse ($records as $user)
                                    <tr>
                                        <td>
                                            <div class="d-flex px-2 py-1">
                                                <div><i class="fa-solid fa-user text-primary me-3"></i></div>
                                                <div class="d-flex flex-column justify-content-center">
                                                    <h6 class="mb-0 text-sm">{{ $user->name }}</h6>
                                                </div>
                                            </div>
                                        </td>
                                        <td>
                                            <p class="text-xs font-weight-bold mb-0">{{ $user->role->label() }}</p>
                                            <p class="text-xs text-secondary mb-0">{{ $user->detail->organization ?? '-' }}</p>
                                        </td>
                                        <td>
                                            <p class="text-xs mb-0">HP login: {{ $user->phone }}</p>
                                            @if ($user->detail?->phone)
                                                <p class="text-xs text-secondary mb-0">Kontak tambahan: {{ $user->detail->phone }}</p>
                                            @endif
                                            <p class="text-xs text-secondary mb-0">{{ $user->detail->address ?? 'Alamat belum diisi' }}</p>
                                            @if ($user->detail?->family_card_number)
                                                <p class="text-xs text-secondary mb-0">No KK: {{ $user->detail->family_card_number }}</p>
                                            @endif
                                        </td>
                                        <td class="align-middle text-center">
                                            <span class="text-secondary text-xs font-weight-bold">
                                                {{ $user->created_at->format('d M Y H:i') }}
                                            </span>
                                        </td>
                                        <td class="align-middle text-center">
                                            <span class="badge badge-sm {{ $user->is_active ? 'bg-gradient-success' : 'bg-gradient-warning' }}">
                                                {{ $user->is_active ? 'Aktif' : 'Tidak Aktif' }}
                                            </span>
                                        </td>
                                        <td class="align-middle text-end text-nowrap">
                                            <form method="POST" action="{{ route('pemda.verification.status', $user) }}" class="d-inline">
                                                @csrf
                                                <input type="hidden" name="status" value="active">
                                                <button class="btn btn-sm btn-success me-2" type="submit" {{ $user->is_active ? 'disabled' : '' }}>
                                                    Aktifkan
                                                </button>
                                            </form>
                                            <form method="POST" action="{{ route('pemda.verification.status', $user) }}" class="d-inline">
                                                @csrf
                                                <input type="hidden" name="status" value="inactive">
                                                <button class="btn btn-sm btn-outline-danger" type="submit" {{ ! $user->is_active ? 'disabled' : '' }}>
                                                    Nonaktifkan
                                                </button>
                                            </form>
                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="6" class="text-center py-4 text-muted">Belum ada data pengguna.</td>
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
