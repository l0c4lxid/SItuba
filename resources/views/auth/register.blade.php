<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="description" content="Daftar di SITUBA - Sistem Informasi Tuberkulosis terintegrasi untuk pemantauan TBC oleh pasien, kader, puskesmas, kelurahan, dan pemda.">
    <meta name="robots" content="noindex, nofollow">
    <link rel="apple-touch-icon" sizes="76x76" href="{{ asset('assets/img/apple-icon.png') }}">
    <link rel="icon" type="image/png" href="{{ asset('assets/img/favicon.png') }}">
    <title>{{ config('app.name', 'SITUBA') }} &mdash; Registrasi</title>
    <link href="https://fonts.googleapis.com/css?family=Inter:300,400,500,600,700,800" rel="stylesheet" />
    <link rel="stylesheet" href="{{ asset('vendor/fontawesome-free/css/all.min.css') }}">
    <style>
        :root {
            --bg1: #f8fafc;
            --bg2: #eef2ff;
            --primary: #0ea5e9;
            --secondary: #6366f1;
            --accent: #22c55e;
            --text: #0f172a;
            --muted: #475569;
            --card: rgba(255, 255, 255, 0.95);
            --border: rgba(15, 23, 42, 0.08);
        }

        * {
            box-sizing: border-box;
        }

        body {
            margin: 0;
            font-family: "Inter", system-ui, -apple-system, "Segoe UI", sans-serif;
            color: var(--text);
            min-height: 100vh;
            background: radial-gradient(circle at 18% 20%, rgba(14, 165, 233, 0.16), transparent 32%),
                radial-gradient(circle at 80% 10%, rgba(99, 102, 241, 0.14), transparent 30%),
                linear-gradient(135deg, var(--bg1), var(--bg2));
        }

        a {
            color: var(--secondary);
            text-decoration: none;
        }

        a:hover {
            color: #4f46e5;
        }

        .nav {
            position: fixed;
            top: 18px;
            left: 24px;
            right: 24px;
            display: flex;
            justify-content: space-between;
            align-items: center;
            z-index: 10;
        }

        .brand {
            display: inline-flex;
            align-items: center;
            gap: 10px;
            font-weight: 800;
            letter-spacing: 0.2px;
            color: var(--text);
        }

        .brand span {
            padding: 8px 12px;
            border-radius: 12px;
            background: linear-gradient(135deg, rgba(14, 165, 233, 0.4), rgba(34, 197, 94, 0.3));
            color: #0b1729;
        }

        .pill-link {
            padding: 9px 14px;
            border-radius: 12px;
            border: 1px solid var(--border);
            background: rgba(255, 255, 255, 0.92);
            font-weight: 600;
            display: inline-flex;
            align-items: center;
            gap: 8px;
            color: var(--text);
            box-shadow: 0 12px 32px rgba(15, 23, 42, 0.08);
        }

        .shell {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(340px, 1fr));
            gap: 28px;
            min-height: 100vh;
            padding: 100px 24px 32px;
            max-width: 1120px;
            margin: 0 auto;
            align-items: center;
        }

        .card {
            background: var(--card);
            border: 1px solid var(--border);
            border-radius: 22px;
            box-shadow: 0 30px 90px rgba(15, 23, 42, 0.12);
            padding: clamp(18px, 3vw, 26px);
        }

        .card h1 {
            margin: 0 0 10px;
            font-size: clamp(24px, 3vw, 30px);
            letter-spacing: -0.02em;
        }

        .card p.lead {
            margin: 0 0 18px;
            color: var(--muted);
            line-height: 1.5;
        }

        .form-grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(260px, 1fr));
            gap: 14px 16px;
        }

        .full {
            grid-column: 1 / -1;
        }

        .d-none {
            display: none !important;
        }

        .field-block {
            background: rgba(255, 255, 255, 0.9);
            border: 1px solid var(--border);
            border-radius: 14px;
            padding: 10px 12px;
            box-shadow: 0 10px 26px rgba(15, 23, 42, 0.06);
        }

        .with-select select {
            padding-left: 44px;
        }

        label {
            display: block;
            font-weight: 600;
            margin-bottom: 6px;
            color: var(--text);
        }

        .input-wrap {
            position: relative;
        }

        .input,
        .select {
            width: 100%;
            border-radius: 12px;
            border: 1px solid var(--border);
            background: rgba(255, 255, 255, 0.9);
            padding: 13px 14px 13px 44px;
            font-size: 14px;
            color: var(--text);
            transition: border 0.2s ease, box-shadow 0.2s ease;
            outline: none;
        }

        .select {
            padding-left: 14px;
            padding-right: 46px;
            appearance: none;
            background-color: #fff;
            background-image: url("data:image/svg+xml,%3Csvg width='14' height='9' viewBox='0 0 14 9' xmlns='http://www.w3.org/2000/svg'%3E%3Cpath fill='%230ea5e9' d='M7 9 0 0h14L7 9Z'/%3E%3C/svg%3E");
            background-repeat: no-repeat;
            background-position: right 16px center;
            background-size: 14px 9px;
            box-shadow: inset 0 1px 0 rgba(255, 255, 255, 0.7);
        }

        .input:focus,
        .select:focus {
            border-color: rgba(14, 165, 233, 0.6);
            box-shadow: 0 12px 30px rgba(14, 165, 233, 0.18);
        }

        .input-icon {
            position: absolute;
            left: 14px;
            top: 12px;
            color: var(--primary);
            font-size: 15px;
            opacity: 0.9;
        }

        .label-row {
            display: flex;
            align-items: baseline;
            justify-content: space-between;
            gap: 8px;
            margin-bottom: 6px;
        }

        .helper {
            display: block;
            color: var(--muted);
            font-size: 12px;
            line-height: 1.4;
        }

        .role-chip {
            display: inline-flex;
            align-items: center;
            gap: 8px;
            padding: 10px 12px;
            border-radius: 12px;
            background: linear-gradient(135deg, rgba(14, 165, 233, 0.12), rgba(99, 102, 241, 0.12));
            color: var(--text);
            font-weight: 700;
            border: 1px solid var(--border);
        }

        .section {
            margin-top: 18px;
            padding: 12px 12px 6px;
            border-radius: 16px;
            background: rgba(14, 165, 233, 0.06);
            border: 1px dashed rgba(14, 165, 233, 0.25);
        }

        .btn-primary {
            width: 100%;
            border: none;
            border-radius: 14px;
            padding: 14px;
            font-weight: 800;
            color: #0b1729;
            background: linear-gradient(135deg, #22d3ee, #34d399, #6366f1);
            cursor: pointer;
            box-shadow: 0 16px 50px rgba(14, 165, 233, 0.28);
            transition: transform 0.15s ease, box-shadow 0.2s ease;
        }

        .btn-primary:hover {
            transform: translateY(-1px);
            box-shadow: 0 20px 60px rgba(14, 165, 233, 0.34);
        }

        .btn-primary:active {
            transform: translateY(0);
        }

        .note {
            text-align: center;
            color: var(--muted);
            font-size: 13px;
            line-height: 1.6;
        }

        .aside {
            background: linear-gradient(160deg, rgba(14, 165, 233, 0.16), rgba(99, 102, 241, 0.18));
            border: 1px solid rgba(15, 23, 42, 0.06);
            border-radius: 22px;
            padding: clamp(18px, 3vw, 26px);
            box-shadow: 0 24px 70px rgba(15, 23, 42, 0.12);
            display: grid;
            gap: 12px;
        }

        .aside h3 {
            margin: 0;
            font-size: clamp(20px, 2.4vw, 24px);
        }

        .aside p {
            margin: 0;
            color: var(--text);
        }

        .badge {
            display: inline-flex;
            align-items: center;
            gap: 6px;
            padding: 8px 12px;
            border-radius: 999px;
            background: rgba(255, 255, 255, 0.8);
            border: 1px solid rgba(15, 23, 42, 0.06);
            font-weight: 700;
            color: var(--text);
            width: fit-content;
        }

        .info-list {
            list-style: none;
            padding: 0;
            margin: 4px 0 0;
            display: grid;
            gap: 8px;
            color: var(--muted);
        }

        .info-list li {
            display: flex;
            gap: 10px;
            align-items: flex-start;
        }

        .info-list i {
            color: #0ea5e9;
            margin-top: 2px;
        }

        .link-row {
            text-align: center;
            margin-top: 10px;
            color: var(--muted);
        }

        @media (max-width: 768px) {
            .nav {
                position: static;
                padding: 16px;
            }

            .shell {
                padding-top: 24px;
            }
        }
    </style>
</head>

@php($roleOptions = $roleOptions ?? \App\Enums\UserRole::options([\App\Enums\UserRole::Pemda]))
@php($roleEmojis = [
    \App\Enums\UserRole::Kelurahan->value => '🏘️ ',
    \App\Enums\UserRole::Puskesmas->value => '🏥 ',
    \App\Enums\UserRole::Kader->value => '🧑‍⚕️ ',
    \App\Enums\UserRole::Pasien->value => '🫁 ',
])

<body>
    <div class="nav">
        <a href="{{ url('/') }}" class="brand">
            <span>{{ config('app.name', 'SITUBA') }}</span>
            <strong>Registrasi</strong>
        </a>
        <a href="{{ route('login') }}" class="pill-link"><i class="fa fa-arrow-left"></i>Punya akun?</a>
    </div>

    <div class="shell">
        <div class="card">
            <div class="role-chip"><i class="fa fa-user-plus"></i> Daftar Pengguna Baru</div>
            <h1>Bergabung ke SITUBA</h1>
            <p class="lead">Pilih peran yang sesuai dan lengkapi data. Akun akan aktif setelah diverifikasi Pemda.</p>

            <form method="POST" action="{{ route('register') }}" autocomplete="off">
                @csrf
                <div class="form-grid">
                    <div class="field-block">
                        <div class="label-row">
                            <label for="role">Daftar sebagai</label>
                            <span class="helper">Pilih peran agar relasi data benar</span>
                        </div>
                        <div class="input-wrap with-select">
                            <i class="fa fa-users input-icon"></i>
                            <select id="role" name="role" class="select" required>
                                <option value="">Pilih peran</option>
                                @foreach ($roleOptions as $role)
                                    <option value="{{ $role['value'] }}" @selected(old('role') === $role['value'])>
                                        {{ ($roleEmojis[$role['value']] ?? '🔖 ') . $role['label'] }}
                                    </option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                    <div class="field-block">
                        <div class="label-row">
                            <label for="name" id="name-label" data-default="Nama Penanggung Jawab / Pasien">Nama</label>
                            <span class="helper">Isi sesuai identitas</span>
                        </div>
                        <div class="input-wrap">
                            <i class="fa fa-id-badge input-icon"></i>
                            <input type="text" class="input" id="name" name="name" value="{{ old('name') }}" required>
                        </div>
                    </div>
                </div>

                <div class="section role-section d-none" data-role-section="kelurahan">
                    <h4 class="role-chip" style="background: rgba(14,165,233,0.12);">Kelurahan</h4>
                    <div class="form-grid">
                        <div class="field-block">
                            <div class="label-row">
                                <label for="kelurahan_name">Nama Kelurahan</label>
                                <span class="helper">Contoh: Kel. Manahan</span>
                            </div>
                            <div class="input-wrap">
                                <i class="fa fa-building input-icon"></i>
                                <input type="text" class="input" id="kelurahan_name" name="kelurahan_name"
                                    value="{{ old('kelurahan_name') }}">
                            </div>
                        </div>
                        <div class="field-block full">
                            <div class="label-row">
                                <label for="kelurahan_address">Alamat Kelurahan</label>
                                <span class="helper">Isi alamat kantor kelurahan</span>
                            </div>
                            <div class="input-wrap">
                                <i class="fa fa-location-dot input-icon"></i>
                                <input type="text" class="input" id="kelurahan_address" name="kelurahan_address"
                                    value="{{ old('kelurahan_address') }}">
                            </div>
                        </div>
                    </div>
                </div>

                <div class="section role-section d-none" data-role-section="puskesmas">
                    <h4 class="role-chip" style="background: rgba(99,102,241,0.12);">Puskesmas</h4>
                    <div class="form-grid">
                        <div class="field-block">
                            <div class="label-row">
                                <label for="puskesmas_name">Nama Puskesmas</label>
                                <span class="helper">Contoh: Puskesmas Gajahan</span>
                            </div>
                            <div class="input-wrap">
                                <i class="fa fa-clinic-medical input-icon"></i>
                                <input type="text" class="input" id="puskesmas_name" name="puskesmas_name"
                                    value="{{ old('puskesmas_name') }}">
                            </div>
                        </div>
                        <div class="field-block">
                            <div class="label-row">
                                <label for="puskesmas_kelurahan_id">Kelurahan Mitra</label>
                                <span class="helper">Pilih kelurahan pembina</span>
                            </div>
                            @if (($kelurahanOptions ?? collect())->isEmpty())
                                <div class="note" style="text-align:left;">Belum ada Kelurahan aktif. Hubungi admin.</div>
                            @else
                                <div class="input-wrap with-select">
                                    <i class="fa fa-map-pin input-icon"></i>
                                    <select id="puskesmas_kelurahan_id" name="puskesmas_kelurahan_id" class="select">
                                        <option value="">Pilih kelurahan</option>
                                        @foreach ($kelurahanOptions as $kelurahan)
                                            <option value="{{ $kelurahan->id }}"
                                                @selected(old('puskesmas_kelurahan_id') == $kelurahan->id)>🏘️ {{ $kelurahan->name }}
                                            </option>
                                        @endforeach
                                    </select>
                                </div>
                            @endif
                        </div>
                        <div class="field-block full">
                            <div class="label-row">
                                <label for="puskesmas_address">Alamat Puskesmas</label>
                                <span class="helper">Alamat lengkap fasilitas</span>
                            </div>
                            <div class="input-wrap">
                                <i class="fa fa-location-dot input-icon"></i>
                                <input type="text" class="input" id="puskesmas_address" name="puskesmas_address"
                                    value="{{ old('puskesmas_address') }}">
                            </div>
                        </div>
                    </div>
                </div>

                <div class="section role-section d-none" data-role-section="kader">
                    <h4 class="role-chip" style="background: rgba(34,197,94,0.12);">Kader</h4>
                    <div class="form-grid">
                        <div class="field-block full">
                            <div class="label-row">
                                <label for="kader_puskesmas_id">Puskesmas Induk</label>
                                <span class="helper">Hubungkan ke puskesmas pembina</span>
                            </div>
                            @if (($puskesmasOptions ?? collect())->isEmpty())
                                <div class="note" style="text-align:left;">Belum ada Puskesmas aktif. Hubungi admin.</div>
                            @else
                                <div class="input-wrap with-select">
                                    <i class="fa fa-hospital input-icon"></i>
                                    <select id="kader_puskesmas_id" name="kader_puskesmas_id" class="select">
                                        <option value="">Pilih puskesmas</option>
                                        @foreach ($puskesmasOptions as $puskesmas)
                                            <option value="{{ $puskesmas->id }}"
                                                @selected(old('kader_puskesmas_id') == $puskesmas->id)>🏥 {{ $puskesmas->name }}
                                            </option>
                                        @endforeach
                                    </select>
                                </div>
                            @endif
                        </div>
                    </div>
                </div>

                <div class="section role-section d-none" data-role-section="pasien">
                    <h4 class="role-chip" style="background: rgba(248,113,113,0.12);">Pasien</h4>
                    <div class="form-grid">
                        <div class="field-block">
                            <div class="label-row">
                                <label for="pasien_nik">NIK</label>
                                <span class="helper">Isi sesuai KTP</span>
                            </div>
                            <div class="input-wrap">
                                <i class="fa fa-id-card input-icon"></i>
                                <input type="text" class="input" id="pasien_nik" name="pasien_nik"
                                    value="{{ old('pasien_nik') }}">
                            </div>
                        </div>
                        <div class="field-block">
                            <div class="label-row">
                                <label for="pasien_kader_id">Kader Pendamping</label>
                                <span class="helper">Pilih kader terdekat</span>
                            </div>
                            @if (($kaderOptions ?? collect())->isEmpty())
                                <div class="note" style="text-align:left;">Belum ada Kader aktif. Hubungi admin.</div>
                            @else
                                <div class="input-wrap with-select">
                                    <i class="fa fa-user-nurse input-icon"></i>
                                    <select id="pasien_kader_id" name="pasien_kader_id" class="select">
                                        <option value="">Pilih kader</option>
                                        @foreach ($kaderOptions as $kader)
                                            <option value="{{ $kader->id }}" @selected(old('pasien_kader_id') == $kader->id)>
                                                🧑‍⚕️ {{ $kader->name }}
                                            </option>
                                        @endforeach
                                    </select>
                                </div>
                            @endif
                        </div>
                        <div class="field-block full">
                            <div class="label-row">
                                <label for="pasien_address">Alamat Pasien</label>
                                <span class="helper">Isi domisili pasien</span>
                            </div>
                            <div class="input-wrap">
                                <i class="fa fa-location-dot input-icon"></i>
                                <input type="text" class="input" id="pasien_address" name="pasien_address"
                                    value="{{ old('pasien_address') }}">
                            </div>
                        </div>
                    </div>
                </div>

                <div class="form-grid" style="margin-top: 16px;">
                    <div class="field-block">
                        <div class="label-row">
                            <label for="phone">Nomor HP (username)</label>
                            <span class="helper">Gunakan format 08xxxxxxxxxx</span>
                        </div>
                        <div class="input-wrap">
                            <i class="fa fa-phone input-icon"></i>
                            <input type="text" class="input" id="phone" name="phone" value="{{ old('phone') }}"
                                required>
                        </div>
                    </div>
                    <div class="field-block">
                        <div class="label-row">
                            <label for="password">Password</label>
                            <span class="helper">Minimal sesuai kebijakan keamanan</span>
                        </div>
                        <div class="input-wrap">
                            <i class="fa fa-lock input-icon"></i>
                            <input type="password" class="input" id="password" name="password" required
                                autocomplete="new-password">
                        </div>
                    </div>
                    <div class="field-block">
                        <div class="label-row">
                            <label for="password_confirmation">Konfirmasi Password</label>
                            <span class="helper">Ulangi password yang sama</span>
                        </div>
                        <div class="input-wrap">
                            <i class="fa fa-lock input-icon"></i>
                            <input type="password" class="input" id="password_confirmation" name="password_confirmation"
                                required autocomplete="new-password">
                        </div>
                    </div>
                </div>

                <div class="note" style="margin: 12px 0 0; text-align:left;">
                    <i class="fa fa-shield-halved"></i> Dengan mendaftar saya menyetujui kebijakan privasi SITUBA. Akun
                    dinonaktifkan hingga diverifikasi yang berwewenang.
                </div>

                <button type="submit" class="btn-primary" style="margin-top: 16px;">Daftar Sekarang</button>
                <p class="note" style="margin-top: 10px;">Sudah punya akun? <a href="{{ route('login') }}">Masuk di
                        sini</a></p>
            </form>
        </div>

    </div>

    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script>
        document.addEventListener('DOMContentLoaded', function () {
            const roleSelect = document.getElementById('role');
            const sections = document.querySelectorAll('[data-role-section]');
            const nameLabel = document.getElementById('name-label');
            const defaultLabel = nameLabel?.dataset.default ?? nameLabel?.textContent;
            const labelMap = {
                kelurahan: 'Nama Penanggung Jawab Kelurahan',
                puskesmas: 'Nama Penanggung Jawab Puskesmas',
                kader: 'Nama Penanggung Jawab Kader',
                pasien: 'Nama Pasien',
            };

            function toggleRoleSections() {
                const role = roleSelect.value;
                sections.forEach(section => {
                    section.classList.toggle('d-none', section.dataset.roleSection !== role);
                });
                if (nameLabel) {
                    nameLabel.textContent = labelMap[role] ?? defaultLabel;
                }
            }

            roleSelect.addEventListener('change', toggleRoleSections);
            toggleRoleSections();

            @if ($errors->any())
                const errors = @json($errors->all());
                if (errors.length) {
                    Swal.fire({
                        icon: 'error',
                        title: 'Registrasi gagal',
                        html: '<ul class="text-start mb-0">' + errors.map(msg => `<li>${msg}</li>`).join('') + '</ul>',
                    });
                }
            @endif
        });
    </script>
</body>

</html>
