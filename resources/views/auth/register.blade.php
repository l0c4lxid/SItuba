<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <link rel="apple-touch-icon" sizes="76x76" href="{{ asset('assets/img/apple-icon.png') }}">
    <link rel="icon" type="image/png" href="{{ asset('assets/img/favicon.png') }}">
    <title>{{ config('app.name', 'SIGAP TBC') }} &mdash; Registrasi</title>
    <link href="https://fonts.googleapis.com/css?family=Inter:300,400,500,600,700,800" rel="stylesheet" />
    <link href="{{ asset('assets/css/nucleo-icons.css') }}" rel="stylesheet" />
    <link href="{{ asset('assets/css/nucleo-svg.css') }}" rel="stylesheet" />
    <link id="pagestyle" href="{{ asset('assets/css/soft-ui-dashboard.css') }}" rel="stylesheet" />
</head>

<body class="">
    <nav class="navbar navbar-expand-lg position-absolute top-0 z-index-3 w-100 shadow-none my-3 navbar-transparent mt-4">
        <div class="container">
            <a class="navbar-brand font-weight-bolder ms-lg-0 ms-3 text-white" href="{{ url('/') }}">
                {{ config('app.name', 'SIGAP TBC') }}
            </a>
        </div>
    </nav>
    <main class="main-content mt-0">
        <section class="min-vh-100 mb-8">
            <div class="page-header align-items-start min-vh-50 pt-5 pb-11 m-3 border-radius-lg" style="background-image: url('{{ asset('assets/img/curved-images/curved14.jpg') }}');">
                <span class="mask bg-gradient-dark opacity-6"></span>
                <div class="container">
                    <div class="row justify-content-center">
                        <div class="col-lg-6 text-center mx-auto">
                            <h1 class="text-white mb-2 mt-5">Buat Akun SIGAP TBC</h1>
                            <p class="text-lead text-white">Daftar sebagai pasien, kader TBC, puskesmas, kelurahan, atau pemda untuk mulai melakukan skrining.</p>
                        </div>
                    </div>
                </div>
            </div>
            <div class="container">
                <div class="row mt-lg-n10 mt-md-n11 mt-n10 justify-content-center">
                    <div class="col-xl-8 col-lg-9 col-md-10 mx-auto">
                        <div class="card z-index-0">
                            <div class="card-header text-center pt-4">
                                <h5>Form Registrasi Pengguna</h5>
                                <p class="text-sm mb-0">Isi data dengan benar untuk proses verifikasi internal.</p>
                            </div>
                            <div class="card-body">
                                @if ($errors->any())
                                    <div class="alert alert-danger">
                                        <ul class="mb-0 ps-3">
                                            @foreach ($errors->all() as $error)
                                                <li>{{ $error }}</li>
                                            @endforeach
                                        </ul>
                                    </div>
                                @endif
                                <form method="POST" action="{{ route('register') }}">
                                    @csrf
                                    <div class="row g-3">
                                        <div class="col-md-12">
                                            <label for="name" class="form-label">Nama Lengkap</label>
                                            <input type="text" class="form-control" id="name" name="name" value="{{ old('name') }}" required autofocus>
                                        </div>
                                        <div class="col-md-6">
                                            <label for="email" class="form-label">Email</label>
                                            <input type="email" class="form-control" id="email" name="email" value="{{ old('email') }}" required>
                                        </div>
                                        <div class="col-md-6">
                                            <label for="role" class="form-label">Peran</label>
                                            @php($roleOptions = $roleOptions ?? \App\Enums\UserRole::options())
                                            <select id="role" name="role" class="form-select" required>
                                                <option value="">Pilih peran</option>
                                                @foreach ($roleOptions as $role)
                                                    <option value="{{ $role['value'] }}" @selected(old('role') === $role['value'])>{{ $role['label'] }}</option>
                                                @endforeach
                                            </select>
                                        </div>
                                        <div class="col-md-6">
                                            <label for="nik" class="form-label">NIK / Nomor Identitas</label>
                                            <input type="text" class="form-control" id="nik" name="nik" value="{{ old('nik') }}">
                                        </div>
                                        <div class="col-md-6">
                                            <label for="phone" class="form-label">Nomor Telepon</label>
                                            <input type="text" class="form-control" id="phone" name="phone" value="{{ old('phone') }}">
                                        </div>
                                        <div class="col-md-6">
                                            <label for="organization" class="form-label">Instansi / Faskes / Kelurahan</label>
                                            <input type="text" class="form-control" id="organization" name="organization" value="{{ old('organization') }}">
                                        </div>
                                        <div class="col-md-6">
                                            <label for="address" class="form-label">Alamat</label>
                                            <input type="text" class="form-control" id="address" name="address" value="{{ old('address') }}">
                                        </div>
                                        <div class="col-12">
                                            <label for="notes" class="form-label">Catatan Tambahan</label>
                                            <textarea class="form-control" id="notes" name="notes" rows="3">{{ old('notes') }}</textarea>
                                        </div>
                                        <div class="col-md-6">
                                            <label for="password" class="form-label">Password</label>
                                            <input type="password" class="form-control" id="password" name="password" required autocomplete="new-password">
                                        </div>
                                        <div class="col-md-6">
                                            <label for="password_confirmation" class="form-label">Konfirmasi Password</label>
                                            <input type="password" class="form-control" id="password_confirmation" name="password_confirmation" required autocomplete="new-password">
                                        </div>
                                    </div>
                                    <div class="form-check form-switch mt-4">
                                        <input class="form-check-input" type="checkbox" id="terms" checked disabled>
                                        <label class="form-check-label" for="terms">Dengan mendaftar saya menyetujui kebijakan privasi SIGAP TBC.</label>
                                    </div>
                                    <div class="text-center">
                                        <button type="submit" class="btn bg-gradient-dark w-100 my-4 mb-2">Daftar Sekarang</button>
                                    </div>
                                    <p class="text-sm mt-3 mb-0 text-center">Sudah punya akun? <a href="{{ route('login') }}" class="text-dark font-weight-bolder">Masuk di sini</a></p>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section>
    </main>
    <footer class="footer py-5">
        <div class="container">
            <div class="row">
                <div class="col-8 mx-auto text-center mt-1">
                    <p class="mb-0 text-secondary">
                        &copy; {{ now()->year }} {{ config('app.name', 'SIGAP TBC') }}.
                    </p>
                </div>
            </div>
        </div>
    </footer>
    <script src="{{ asset('assets/js/core/popper.min.js') }}"></script>
    <script src="{{ asset('assets/js/core/bootstrap.min.js') }}"></script>
    <script src="{{ asset('assets/js/plugins/perfect-scrollbar.min.js') }}"></script>
    <script src="{{ asset('assets/js/plugins/smooth-scrollbar.min.js') }}"></script>
    <script src="{{ asset('assets/js/soft-ui-dashboard.min.js') }}"></script>
</body>

</html>
