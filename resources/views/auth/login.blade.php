<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="description" content="SITUBA - Sistem Informasi Tuberkulosis terintegrasi. Masuk untuk mengelola pemantauan TBC: pasien, kader, puskesmas, kelurahan, hingga pemda.">
    <meta name="robots" content="noindex, nofollow">
    <link rel="apple-touch-icon" sizes="76x76" href="{{ asset('assets/img/apple-icon.png') }}">
    <link rel="icon" type="image/png" href="{{ asset('assets/img/favicon.png') }}">
    <title>{{ config('app.name', 'SITUBA') }} &mdash; Masuk</title>
    <link href="https://fonts.googleapis.com/css?family=Inter:300,400,500,600,700,800" rel="stylesheet" />
    <link rel="stylesheet" href="{{ asset('vendor/fontawesome-free/css/all.min.css') }}">
    <style>
        :root {
            --bg1: #f8fafc;
            --bg2: #eef2ff;
            --accent1: #0ea5e9;
            --accent2: #22c55e;
            --accent3: #6366f1;
            --card: rgba(255, 255, 255, 0.9);
            --border: rgba(15, 23, 42, 0.08);
            --text: #0f172a;
            --muted: #475569;
        }

        * {
            box-sizing: border-box;
        }

        body {
            margin: 0;
            font-family: "Inter", system-ui, -apple-system, "Segoe UI", sans-serif;
            color: var(--text);
            min-height: 100vh;
            background: radial-gradient(circle at 15% 20%, rgba(99, 102, 241, 0.16), transparent 28%),
                radial-gradient(circle at 80% 0%, rgba(34, 197, 94, 0.14), transparent 32%),
                linear-gradient(135deg, var(--bg1), var(--bg2));
            overflow: hidden;
        }

        .shell {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(320px, 1fr));
            min-height: 100vh;
            align-items: center;
            padding: clamp(18px, 4vw, 36px);
            gap: 28px;
            position: relative;
        }

        .shell::before,
        .shell::after {
            content: "";
            position: absolute;
            inset: 0;
            pointer-events: none;
            background: radial-gradient(circle at 70% 80%, rgba(14, 165, 233, 0.2), transparent 38%);
            mix-blend-mode: screen;
        }

        .nav {
            position: absolute;
            top: clamp(12px, 4vw, 20px);
            left: clamp(16px, 4vw, 28px);
            right: clamp(16px, 4vw, 28px);
            display: flex;
            align-items: center;
            justify-content: space-between;
            z-index: 4;
        }

        .brand {
            display: inline-flex;
            align-items: center;
            gap: 10px;
            color: var(--text);
            text-decoration: none;
            font-weight: 700;
            letter-spacing: 0.3px;
        }

        .brand span {
            padding: 8px 12px;
            border-radius: 12px;
            background: linear-gradient(135deg, rgba(14, 165, 233, 0.35), rgba(34, 197, 94, 0.28));
            color: #0b1729;
        }

        .ghost-btn {
            border: 1px solid var(--border);
            color: var(--text);
            padding: 10px 16px;
            border-radius: 12px;
            background: rgba(255, 255, 255, 0.88);
            text-decoration: none;
            display: inline-flex;
            align-items: center;
            gap: 8px;
            font-weight: 600;
            transition: all 0.2s ease;
        }

        .ghost-btn:hover {
            border-color: rgba(14, 165, 233, 0.4);
            color: #0f172a;
            box-shadow: 0 12px 30px rgba(14, 165, 233, 0.25);
        }

        .ghost-btn--blog {
            border: none;
            background: linear-gradient(135deg, #0ea5e9, #22c55e, #6366f1);
            background-size: 200% 200%;
            color: #ffffff;
            box-shadow: 0 14px 40px rgba(14, 165, 233, 0.28);
        }

        .ghost-btn--blog i {
            color: #ffffff;
        }

        .ghost-btn--blog:hover {
            box-shadow: 0 18px 50px rgba(99, 102, 241, 0.28);
            transform: translateY(-1px);
            background-position: right center;
        }

        .card {
            background: var(--card);
            border: 1px solid var(--border);
            border-radius: 22px;
            backdrop-filter: blur(12px);
            box-shadow: 0 30px 120px rgba(15, 23, 42, 0.14);
            padding: clamp(20px, 3vw, 28px);
            position: relative;
            z-index: 2;
        }

        .card h1 {
            margin: 0 0 8px;
            font-size: clamp(26px, 3vw, 32px);
            letter-spacing: -0.02em;
        }

        .card p {
            margin: 0 0 20px;
            color: var(--muted);
        }

        .input {
            width: 100%;
            border-radius: 14px;
            border: 1px solid var(--border);
            background: rgba(255, 255, 255, 0.92);
            padding: 14px 14px 14px 48px;
            color: var(--text);
            font-size: 14px;
            outline: none;
            transition: all 0.2s ease;
        }

        .input:focus {
            border-color: rgba(34, 211, 238, 0.65);
            box-shadow: 0 14px 40px rgba(14, 165, 233, 0.22);
        }

        .field {
            position: relative;
            margin-bottom: 14px;
        }

        .field label {
            display: block;
            margin-bottom: 8px;
            color: var(--muted);
            font-size: 13px;
        }

        .field .field-icon {
            position: absolute;
            left: 14px;
            top: 41px;
            font-size: 14px;
            color: #0ea5e9;
        }

        .toggle-pass {
            position: absolute;
            right: 12px;
            top: 38px;
            border: none;
            background: transparent;
            color: #0ea5e9;
            cursor: pointer;
            padding: 6px;
            border-radius: 10px;
            transition: background 0.2s ease, color 0.2s ease;
        }

        .toggle-pass:hover {
            background: rgba(14, 165, 233, 0.08);
            color: #0b1729;
        }

        .remember {
            display: flex;
            align-items: center;
            gap: 10px;
            color: var(--muted);
            font-size: 13px;
            margin: 6px 0 14px;
        }

        .btn-primary {
            width: 100%;
            border: none;
            border-radius: 14px;
            padding: 14px 16px;
            color: #0b1729;
            font-weight: 700;
            letter-spacing: 0.01em;
            background: linear-gradient(135deg, #22d3ee, #34d399, #6366f1);
            cursor: pointer;
            box-shadow: 0 16px 60px rgba(14, 165, 233, 0.3);
            transition: transform 0.15s ease, box-shadow 0.2s ease;
        }

        .btn-primary:hover {
            transform: translateY(-2px);
            box-shadow: 0 20px 70px rgba(14, 165, 233, 0.34);
        }

        .muted {
            color: var(--muted);
            font-size: 13px;
            text-align: center;
            line-height: 1.6;
        }

        .link {
            color: #38bdf8;
            font-weight: 700;
            text-decoration: none;
        }

        .link:hover {
            color: #7dd3fc;
        }

        .hero {
            position: relative;
            min-height: 420px;
            display: grid;
            place-items: center;
            gap: 12px;
        }

        .scene {
            width: min(420px, 90vw);
            height: min(420px, 90vw);
            perspective: 1000px;
            border-radius: 50%;
            background: radial-gradient(circle at 30% 30%, rgba(14, 165, 233, 0.18), transparent 55%),
                radial-gradient(circle at 70% 65%, rgba(99, 102, 241, 0.18), transparent 55%),
                linear-gradient(145deg, rgba(255, 255, 255, 0.92), rgba(255, 255, 255, 0.8));
            border: 1px solid rgba(15, 23, 42, 0.06);
            box-shadow: 0 24px 70px rgba(14, 165, 233, 0.2);
            padding: 16px;
            display: grid;
            place-items: center;
        }

        .lungs-3d {
            position: relative;
            width: 100%;
            height: 100%;
            transform-style: preserve-3d;
            transform: rotateX(18deg) rotateY(-20deg);
            animation: rotateScene 10s linear infinite alternate;
        }

        @keyframes rotateScene {
            0% {
                transform: rotateX(18deg) rotateY(-20deg);
            }

            100% {
                transform: rotateX(18deg) rotateY(20deg);
            }
        }

        .grid {
            position: absolute;
            inset: 10%;
            border-radius: 50%;
            background-image:
                radial-gradient(circle, rgba(148, 163, 184, 0.12) 1px, transparent 1px),
                radial-gradient(circle, rgba(148, 163, 184, 0.12) 1px, transparent 1px);
            background-size: 24px 24px, 16px 16px;
            background-position: 0 0, 6px 6px;
            transform: translateZ(-60px);
            opacity: 0.6;
            animation: gridSpin 16s linear infinite;
        }

        @keyframes gridSpin {
            from {
                transform: translateZ(-60px) rotateZ(0deg);
            }

            to {
                transform: translateZ(-60px) rotateZ(360deg);
            }
        }

        .lungs {
            position: absolute;
            inset: 10% 12%;
            transform-style: preserve-3d;
            transform-origin: center center;
            animation: breathe 6s ease-in-out infinite;
        }

        @keyframes breathe {

            0%,
            100% {
                transform: translateZ(0px) scale(0.95);
                filter: drop-shadow(0 0 15px rgba(248, 113, 113, 0.35));
            }

            50% {
                transform: translateZ(40px) scale(1.05);
                filter: drop-shadow(0 0 30px rgba(248, 113, 113, 0.65));
            }
        }

        .trachea {
            position: absolute;
            top: 0;
            left: 50%;
            width: 26px;
            height: 95px;
            transform: translateX(-50%) translateZ(10px);
            border-radius: 30px;
            background: linear-gradient(to bottom, #f1f5f9, #cbd5e1 40%, #94a3b8 80%);
            box-shadow: 0 0 8px rgba(148, 163, 184, 0.7), inset 0 0 6px rgba(15, 23, 42, 0.6);
        }

        .trachea::before {
            content: "";
            position: absolute;
            inset: 8px 4px;
            border-radius: 40px;
            border-top: 3px solid rgba(15, 23, 42, 0.4);
            border-bottom: 3px solid rgba(15, 23, 42, 0.4);
            opacity: 0.35;
        }

        .carina {
            position: absolute;
            bottom: -6px;
            left: 50%;
            width: 40px;
            height: 40px;
            transform: translateX(-50%) translateZ(12px) rotateZ(45deg);
            border-radius: 0 50px 50px 50px;
            background: radial-gradient(circle at center, #fecaca, #f97373);
            box-shadow: 0 0 10px rgba(248, 113, 113, 0.7);
        }

        .lung {
            position: absolute;
            bottom: 0;
            width: 45%;
            height: 78%;
            border-radius: 55% 45% 40% 60%;
            background: radial-gradient(circle at 30% 20%, #fee2e2, #f97373);
            box-shadow: inset -15px -10px 30px rgba(248, 113, 113, 0.7), 0 12px 30px rgba(15, 23, 42, 0.18);
            overflow: hidden;
            transform-style: preserve-3d;
        }

        .lung.left {
            left: 1%;
            border-radius: 60% 40% 50% 30%;
            transform: rotateZ(6deg) translateZ(20px);
        }

        .lung.right {
            right: 1%;
            border-radius: 40% 60% 30% 50%;
            transform: rotateZ(-6deg) translateZ(15px);
        }

        .bronchus {
            position: absolute;
            top: 10%;
            left: 40%;
            width: 20%;
            height: 18%;
            border-radius: 50%;
            background: radial-gradient(circle at 30% 20%, #fecaca, #f97373);
            box-shadow: 0 0 8px rgba(254, 202, 202, 0.7);
            opacity: 0.9;
        }

        .lung.right .bronchus {
            left: 42%;
        }

        .branch {
            position: absolute;
            width: 2px;
            height: 40%;
            background: linear-gradient(to bottom, #fee2e2, #b91c1c);
            opacity: 0.7;
            transform-origin: top;
        }

        .branch:nth-child(2) {
            left: 60%;
            top: 27%;
            transform: rotateZ(8deg);
            height: 45%;
        }

        .branch:nth-child(3) {
            left: 45%;
            top: 32%;
            transform: rotateZ(-22deg);
            height: 38%;
        }

        .branch:nth-child(1) {
            left: 52%;
            top: 22%;
            transform: rotateZ(-12deg);
        }

        .alveoli {
            position: absolute;
            inset: 40% 20% 8% 18%;
            opacity: 0.45;
            background-image:
                radial-gradient(circle, rgba(254, 242, 242, 0.9) 1px, transparent 0),
                radial-gradient(circle, rgba(254, 202, 202, 0.8) 1px, transparent 0);
            background-size: 14px 14px, 20px 20px;
            background-position: 0 0, 6px 6px;
            mix-blend-mode: screen;
            transform: translateZ(8px);
        }

        .halo {
            position: absolute;
            inset: 6%;
            border-radius: 50%;
            border: 1px solid rgba(14, 165, 233, 0.3);
            box-shadow: 0 0 40px rgba(99, 102, 241, 0.18);
            animation: haloPulse 8s ease-in-out infinite;
        }

        .halo.secondary {
            inset: 2%;
            animation-duration: 10s;
            opacity: 0.6;
        }

        @keyframes haloPulse {

            0%,
            100% {
                transform: scale(0.94);
                opacity: 0.7;
            }

            50% {
                transform: scale(1.02);
                opacity: 1;
            }
        }

        .spark {
            position: absolute;
            width: 10px;
            height: 10px;
            border-radius: 50%;
            background: radial-gradient(circle, #22c55e, #0ea5e9);
            box-shadow: 0 0 16px rgba(14, 165, 233, 0.35);
            animation: sparkFloat 9s ease-in-out infinite;
        }

        .spark:nth-child(1) {
            top: 14%;
            left: 22%;
            animation-delay: 0.4s;
        }

        .spark:nth-child(2) {
            top: 18%;
            right: 18%;
            animation-delay: 1.1s;
        }

        .spark:nth-child(3) {
            bottom: 14%;
            left: 16%;
            animation-delay: 2s;
        }

        .spark:nth-child(4) {
            bottom: 12%;
            right: 22%;
            animation-delay: 2.6s;
        }

        @keyframes sparkFloat {

            0%,
            100% {
                transform: translate3d(0, 0, 12px);
                opacity: 0.8;
            }

            50% {
                transform: translate3d(12px, -10px, 24px) scale(1.15);
                opacity: 1;
            }
        }

        .hero-copy {
            text-align: center;
            width: 100%;
            max-width: 480px;
            color: var(--muted);
            font-size: 14px;
        }

        @media (max-width: 768px) {
            .shell {
                grid-template-columns: 1fr;
                padding-top: 90px;
            }

            .nav {
                position: fixed;
            }

            .hero {
                display: none;
            }
        }
    </style>
</head>

<body>
    <div class="nav">
        <a href="{{ url('/') }}" class="brand">
            <span>{{ config('app.name', 'SITUBA') }}</span>
            <strong>Masuk</strong>
        </a>
        <div class="d-flex align-items-center gap-2">
            <a href="{{ route('blog.index') }}" class="ghost-btn ghost-btn--blog">
                <i class="fa fa-newspaper"></i> Blog
            </a>
        </div>
    </div>

    <div class="shell">
        <div class="card">
            <h1>Silahkan Masuk</h1>
            <p>Masuk dengan nomor HP dan password untuk mengelola layanan SITUBA.</p>

            <form method="POST" action="{{ route('login') }}" autocomplete="off">
                @csrf
                <div class="field">
                    <label for="phone">Nomor HP</label>
                    <i class="fa fa-phone field-icon"></i>
                    <input type="text" id="phone" name="phone" class="input" placeholder="08xxxxxxxxxx"
                        value="{{ old('phone') }}" required autofocus>
                </div>
                <div class="field">
                    <label for="password">Password</label>
                    <i class="fa fa-lock field-icon"></i>
                    <input type="password" id="password" name="password" class="input" placeholder="••••••••" required
                        autocomplete="current-password">
                    <button type="button" class="toggle-pass" aria-label="Tampilkan password">
                        <i class="fa fa-eye"></i>
                    </button>
                </div>
                <label class="remember">
                    <input type="checkbox" name="remember" {{ old('remember') ? 'checked' : '' }}>
                    Ingat saya
                </label>
                <button type="submit" class="btn-primary">Masuk</button>
            </form>

            <p class="muted" style="margin-top: 14px;">
                Lupa password? Hubungi pihak terkait untuk reset akun.<br>
                Belum punya akun? <a href="{{ route('register') }}" class="link">Daftar sekarang</a>
            </p>
        </div>

        <div class="hero">
            <div class="scene">
                <div class="lungs-3d">
                    <div class="halo"></div>
                    <div class="halo secondary"></div>
                    <div class="spark"></div>
                    <div class="spark"></div>
                    <div class="spark"></div>
                    <div class="spark"></div>
                    <div class="grid"></div>
                    <div class="lungs" id="lungs">
                        <div class="trachea">
                            <div class="carina"></div>
                        </div>

                        <div class="lung left">
                            <div class="bronchus"></div>
                            <div class="branch"></div>
                            <div class="branch"></div>
                            <div class="branch"></div>
                            <div class="alveoli"></div>
                        </div>

                        <div class="lung right">
                            <div class="bronchus"></div>
                            <div class="branch"></div>
                            <div class="branch"></div>
                            <div class="branch"></div>
                            <div class="alveoli"></div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="hero-copy">
                Pemantauan kesehatan TBC dengan aplikasi SITUBA.
            </div>
        </div>
    </div>

    <script src="{{ asset('assets/js/core/popper.min.js') }}"></script>
    <script src="{{ asset('assets/js/core/bootstrap.min.js') }}"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script>
        document.addEventListener('DOMContentLoaded', () => {
            const togglePass = document.querySelector('.toggle-pass');
            const passInput = document.querySelector('#password');
            if (togglePass && passInput) {
                togglePass.addEventListener('click', () => {
                    const isText = passInput.type === 'text';
                    passInput.type = isText ? 'password' : 'text';
                    togglePass.innerHTML = isText ? '<i class="fa fa-eye"></i>' : '<i class="fa fa-eye-slash"></i>';
                });
            }

            @if (session('status'))
                Swal.fire({
                    icon: 'success',
                    title: 'Informasi',
                    text: @json(session('status')),
                });
            @endif

                @if ($errors->any())
                const errors = @json($errors->all());
                const lastPhone = @json(old('phone'));
                if (errors.length) {
                    Swal.fire({
                        icon: 'error',
                        title: 'Login gagal',
                        html: `
                                                <div class="text-start">
                                                    <p class="mb-2">Login gagal, coba masukkan username atau password yang benar.</p>
                                                    ${errors.length ? `<p class="mb-2 text-sm text-danger">${errors.join('<br>')}</p>` : ''}
                                                    ${lastPhone ? `<p class="mb-0"><strong>Nomor terakhir:</strong> ${lastPhone}</p>` : ''}
                                                </div>
                                            `,
                        confirmButtonText: 'Coba lagi',
                        showCloseButton: true,
                        confirmButtonColor: '#0ea5e9',
                    });
                }
                @endif
        });
    </script>
</body>

</html>
