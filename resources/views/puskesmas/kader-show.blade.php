@extends('layouts.soft')

@section('content')
    <div class="row">
        <div class="col-12 mb-3">
            <a href="{{ route('puskesmas.kaders') }}" class="btn btn-sm btn-outline-secondary">
                <i class="fa fa-arrow-left"></i> Kembali ke daftar kader
            </a>
        </div>
        <div class="col-lg-8">
            <div class="card shadow-sm border-0">
                <div class="card-header d-flex justify-content-between align-items-center">
                    <div>
                        <h5 class="mb-0">{{ $kader->name }}</h5>
                        <p class="text-sm text-muted mb-0">Detail kader mitra puskesmas Anda.</p>
                    </div>
                    <span class="badge {{ $kader->is_active ? 'bg-gradient-success text-white' : 'bg-gradient-warning text-dark' }}">
                        {{ $kader->is_active ? 'Aktif' : 'Tidak Aktif' }}
                    </span>
                </div>
                <div class="card-body">
                    <div class="row gy-3">
                        <div class="col-md-6">
                            <p class="text-xs text-muted mb-1">Nomor HP</p>
                            <p class="mb-0 fw-semibold">{{ $kader->phone }}</p>
                        </div>
                        <div class="col-md-6">
                            <p class="text-xs text-muted mb-1">Organisasi/Instansi</p>
                            <p class="mb-0 fw-semibold">{{ $kader->detail->organization ?? 'Kader' }}</p>
                        </div>
                        <div class="col-md-6">
                            <p class="text-xs text-muted mb-1">Catatan</p>
                            <p class="mb-0">{{ $kader->detail->notes ?? '-' }}</p>
                        </div>
                        <div class="col-md-6">
                            <p class="text-xs text-muted mb-1">Terdaftar sejak</p>
                            <p class="mb-0">{{ $kader->created_at->format('d M Y H:i') }}</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-lg-4">
            <div class="card shadow-sm border-0">
                <div class="card-header">
                    <h6 class="mb-0">Kelola Status</h6>
                </div>
                <div class="card-body">
                    <p class="text-sm text-muted">Aktif/nonaktifkan akses kader ini ke aplikasi.</p>
                    <form method="POST" action="{{ route('puskesmas.kaders.status', $kader) }}">
                        @csrf
                        <input type="hidden" name="status" value="{{ $kader->is_active ? 'inactive' : 'active' }}">
                        <button type="submit" class="btn w-100 {{ $kader->is_active ? 'btn-outline-danger' : 'btn-outline-success' }}">
                            {{ $kader->is_active ? 'Nonaktifkan Kader' : 'Aktifkan Kader' }}
                        </button>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection

@push('scripts')
    @if (session('status'))
        <script>
            document.addEventListener('DOMContentLoaded', () => {
                Swal.fire({
                    icon: 'success',
                    title: 'Berhasil',
                    text: @json(session('status')),
                });
            });
        </script>
    @endif
@endpush
