@extends('layouts.soft')

@section('content')
    <div class="row">
        <div class="col-12">
            <div class="card shadow-sm border-0">
                <div class="card-header pb-2 d-flex align-items-center gap-3">
                    <div class="icon icon-shape bg-gradient-primary shadow text-center border-radius-md">
                        <i class="fa-solid fa-user-plus text-white"></i>
                    </div>
                    <div>
                        <h5 class="mb-0">Tambah Pasien Binaan</h5>
                        <p class="text-sm text-muted mb-0">Isi data pasien yang diurus oleh {{ $kader->name }}.</p>
                    </div>
                </div>
                <div class="card-body">
                    <form method="POST" action="{{ route('kader.patients.store') }}">
                        @csrf
                        <div class="mb-3">
                            <label class="form-label">Nama Lengkap</label>
                            <input type="text" name="name" class="form-control" value="{{ old('name') }}" required>
                        </div>
                        <div class="mb-3">
                            <label class="form-label">Nomor HP</label>
                            <input type="text" name="phone" class="form-control" value="{{ old('phone') }}" required>
                        </div>
                        <div class="mb-3">
                            <label class="form-label">NIK</label>
                            <input type="text" name="nik" class="form-control" value="{{ old('nik') }}" required>
                        </div>
                        <div class="mb-4">
                            <label class="form-label">Alamat Lengkap</label>
                            <textarea name="address" rows="3" class="form-control" required>{{ old('address') }}</textarea>
                        </div>
                        <p class="text-xs text-muted mb-3">
                            Pasien akan mendapatkan password sementara yang bisa diganti setelah login.
                        </p>
                        <div class="text-end">
                            <button type="submit" class="btn btn-primary px-4">Simpan Pasien</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection
