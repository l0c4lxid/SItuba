<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>SITUBA Surakarta | Tuberculosis Assistant</title>

    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Space+Grotesk:wght@400;500;600;700&display=swap"
        rel="stylesheet">

    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css"
        integrity="sha512-DTOQO9RWCH3ppGqcWaEA1BIZOC6xxalwEsw9c2QQeAIftl+Vegovlnee1c9QX4TctnWMn13TZye+giMm8e2LwA=="
        crossorigin="anonymous" referrerpolicy="no-referrer" />
    <link rel="icon" type="image/x-icon" href="{{ asset('favicon.ico') }}">
    <link rel="apple-touch-icon" sizes="180x180" href="{{ asset('favicon.ico') }}">

    <style>
        :root {
            --bg: #f8fafc;
            --bg-soft: #e0fbe2;
            --bg-card: #ffffff;
            --bg-chip: #ecfdf3;
            --primary: #16a34a;
            --primary-soft: #dcfce7;
            --accent: #22c55e;
            --accent-soft: #bbf7d0;
            --text: #0f172a;
            --muted: #6b7280;
            --border: #e2e8f0;
            --ring: rgba(34, 197, 94, 0.18);
            --radius-lg: 22px;
            --radius-md: 16px;
            --radius-pill: 999px;
            --shadow-soft: 0 18px 40px rgba(15, 23, 42, 0.08);
            --shadow-card: 0 20px 45px rgba(15, 23, 42, 0.10);
            --mobile-menu-top: 90px;
        }

        * {
            box-sizing: border-box;
        }

        body {
            margin: 0;
            font-family: 'Space Grotesk', system-ui, -apple-system, BlinkMacSystemFont, sans-serif;
            color: var(--text);
            background:
                radial-gradient(circle at 20% 0%, rgba(34, 197, 94, 0.14), transparent 50%),
                radial-gradient(circle at 90% 0%, rgba(52, 211, 153, 0.12), transparent 55%),
                linear-gradient(180deg, #f9fafb 0%, #ecfdf3 60%, #e9fbe8 100%);
            min-height: 100vh;
        }

        .page {
            max-width: 1120px;
            margin: 0 auto;
            padding: 20px 16px 40px;
        }

        header {
            display: flex;
            align-items: center;
            justify-content: space-between;
            gap: 16px;
            padding: 10px 16px;
            border-radius: 999px;
            background-color: rgba(255, 255, 255, 0.9);
            border: 1px solid rgba(226, 232, 240, 0.9);
            box-shadow: 0 12px 30px rgba(148, 163, 184, 0.18);
            backdrop-filter: blur(16px);
            position: sticky;
            top: 14px;
            z-index: 20;
        }

        .brand {
            display: flex;
            align-items: center;
            gap: 12px;
        }

        .brand-logo {
            width: 44px;
            height: 44px;
            border-radius: 18px;
            background: radial-gradient(circle at 10% 0%, #bbf7d0 0%, #16a34a 42%, #22c55e 100%);
            display: grid;
            place-items: center;
            color: #ffffff;
            box-shadow: 0 14px 30px rgba(22, 163, 74, 0.45);
        }

        .brand-logo i {
            font-size: 20px;
        }

        .brand-text strong {
            display: block;
            font-size: 16px;
            letter-spacing: 0.03em;
        }

        .brand-text span {
            display: block;
            font-size: 13px;
            color: var(--muted);
        }

        .header-actions {
            display: flex;
            align-items: center;
            gap: 10px;
            flex-wrap: wrap;
        }

        .btn {
            display: inline-flex;
            align-items: center;
            justify-content: center;
            gap: 8px;
            padding: 9px 16px;
            border-radius: 999px;
            font-size: 14px;
            font-weight: 600;
            text-decoration: none;
            cursor: pointer;
            border: 1px solid transparent;
            transition: background-color 0.18s ease, color 0.18s ease, box-shadow 0.18s ease, transform 0.18s ease, border-color 0.18s ease;
            white-space: nowrap;
        }

        .btn-large {
            padding: 12px 20px;
            font-size: 15px;
        }

        .btn-primary {
            background-image: linear-gradient(135deg, #16a34a, #22c55e);
            color: #ffffff;
            box-shadow: 0 14px 32px rgba(22, 163, 74, 0.45);
        }

        .btn-primary:hover {
            transform: translateY(-1px);
            box-shadow: 0 18px 40px rgba(22, 163, 74, 0.55);
        }

        .btn-ghost {
            background-color: #ffffff;
            color: var(--text);
            border-color: var(--border);
        }

        .btn-ghost:hover {
            background-color: #f9fafb;
            transform: translateY(-1px);
            border-color: #cbd5f5;
        }

        main {
            margin-top: 32px;
            display: grid;
            grid-template-columns: minmax(0, 1.1fr) minmax(0, 1fr);
            gap: 28px;
            align-items: center;
        }

        @media (max-width: 900px) {
            main {
                grid-template-columns: minmax(0, 1fr);
            }

            header {
                flex-direction: column;
                align-items: flex-start;
                border-radius: 18px;
            }

            .header-actions {
                width: 100%;
                justify-content: flex-start;
            }
        }

        @media (max-width: 640px) {
            .page {
                padding-inline: 14px;
            }

            header {
                padding-inline: 12px;
            }
        }

        .eyebrow-badge {
            display: inline-flex;
            align-items: center;
            gap: 8px;
            padding: 6px 10px;
            border-radius: var(--radius-pill);
            font-size: 11px;
            color: #1e293b;
            background: linear-gradient(135deg, #dcfce7, #bbf7d0);
            border: 1px solid #a7f3d0;
            margin-bottom: 12px;
        }

        .eyebrow-badge i {
            padding: 4px;
            border-radius: 999px;
            background: rgba(34, 197, 94, 0.16);
            font-size: 10px;
        }

        .hero-title {
            font-size: clamp(32px, 4vw, 40px);
            line-height: 1.15;
            letter-spacing: -0.03em;
            margin: 0 0 12px;
        }

        .hero-title span.highlight {
            background-image: linear-gradient(120deg, #16a34a, #22c55e);
            -webkit-background-clip: text;
            background-clip: text;
            color: transparent;
        }

        .hero-subtitle {
            margin: 0 0 20px;
            font-size: 15px;
            line-height: 1.7;
            color: var(--muted);
            max-width: 36rem;
        }

        .hero-actions {
            display: flex;
            flex-wrap: wrap;
            gap: 10px;
            margin-bottom: 16px;
        }

        .hero-meta {
            display: flex;
            flex-wrap: wrap;
            gap: 12px;
            font-size: 13px;
            color: var(--muted);
        }

        .hero-meta-item {
            display: inline-flex;
            align-items: center;
            gap: 8px;
            padding: 8px 12px;
            border-radius: var(--radius-pill);
            background-color: rgba(255, 255, 255, 0.9);
            border: 1px dashed #cbd5f5;
        }

        .hero-meta-item i {
            font-size: 13px;
            color: var(--primary);
        }

        @media (max-width: 640px) {
            .hero-meta {
                flex-wrap: nowrap;
                gap: 10px;
                justify-content: space-between;
            }

            .hero-meta-item {
                width: 50%;
            }

            .hero-meta-item span {
                white-space: nowrap;
                overflow: hidden;
                text-overflow: ellipsis;
            }
        }

        .hero-stats-row {
            margin-top: 22px;
            display: grid;
            grid-template-columns: repeat(3, minmax(0, 1fr));
            gap: 10px;
        }

        @media (max-width: 640px) {
            .hero-stats-row {
                grid-template-columns: repeat(2, minmax(0, 1fr));
            }
        }

        .pill-stat {
            padding: 10px 12px;
            border-radius: var(--radius-pill);
            font-size: 13px;
            background-color: rgba(255, 255, 255, 0.9);
            border: 1px solid #e0e7ff;
            display: flex;
            align-items: center;
            justify-content: space-between;
            gap: 8px;
            box-shadow: 0 8px 18px rgba(148, 163, 184, 0.25);
        }

        .pill-stat strong {
            font-size: 15px;
        }

        .pill-stat span {
            color: var(--muted);
            opacity: 0.9;
        }

        .hero-card {
            background-color: var(--bg-card);
            border-radius: var(--radius-lg);
            border: 1px solid rgba(226, 232, 240, 0.9);
            box-shadow: var(--shadow-card);
            padding: 18px 18px 20px;
            position: relative;
            overflow: hidden;
        }

        .hero-card::before {
            content: "";
            position: absolute;
            inset: -40%;
            background:
                radial-gradient(circle at 20% 0%, rgba(79, 70, 229, 0.14), transparent 40%),
                radial-gradient(circle at 80% 0%, rgba(56, 189, 248, 0.14), transparent 45%);
            opacity: 0.7;
            pointer-events: none;
        }

        .hero-card-inner {
            position: relative;
            z-index: 1;
        }

        .hero-card-header {
            display: flex;
            align-items: center;
            justify-content: space-between;
            gap: 12px;
            margin-bottom: 14px;
        }

        .chip {
            display: inline-flex;
            align-items: center;
            gap: 8px;
            font-size: 11px;
            padding: 6px 10px;
            border-radius: var(--radius-pill);
            border: 1px solid rgba(191, 219, 254, 0.9);
            background: rgba(248, 250, 252, 0.9);
            color: #1f2937;
        }

        .chip i {
            font-size: 10px;
            padding: 4px;
            border-radius: 999px;
            background-color: rgba(34, 197, 94, 0.15);
            color: #15803d;
        }

        .text-glow {
            background-image: linear-gradient(120deg, #16a34a, #22c55e, #16a34a);
            background-size: 200% auto;
            -webkit-background-clip: text;
            background-clip: text;
            color: transparent;
            animation: sheen 4s ease-in-out infinite;
            font-weight: 700;
        }

        @keyframes sheen {
            0% {
                background-position: 0% 50%;
            }

            50% {
                background-position: 100% 50%;
            }

            100% {
                background-position: 0% 50%;
            }
        }

        .timeline {
            margin-top: 10px;
            border-radius: var(--radius-md);
            background-color: rgba(248, 250, 252, 0.9);
            border: 1px dashed rgba(209, 213, 219, 0.9);
            padding: 12px 12px 10px;
            display: grid;
            gap: 10px;
        }

        .timeline-item {
            display: grid;
            grid-template-columns: auto 1fr;
            gap: 10px;
        }

        .timeline-step {
            width: 40px;
            height: 40px;
            border-radius: 16px;
            background: radial-gradient(circle at 20% 0%, #eef2ff, #e0f2fe);
            display: grid;
            place-items: center;
            font-size: 13px;
            font-weight: 700;
            color: #1e293b;
            border: 1px solid var(--primary-soft);
        }

        .timeline-content h4 {
            margin: 0 0 2px;
            font-size: 16px;
            display: inline-flex;
            align-items: center;
            gap: 6px;
        }

        .timeline-content h4 i {
            font-size: 14px;
            color: #15803d;
        }

        .timeline-content p {
            margin: 0;
            font-size: 14px;
            color: var(--muted);
            line-height: 1.6;
        }

        .hero-card-footer {
            display: grid;
            grid-template-columns: repeat(3, minmax(0, 1fr));
            gap: 10px;
            margin-top: 14px;
        }

        @media (max-width: 640px) {
            .hero-card-footer {
                grid-template-columns: minmax(0, 1fr);
            }
        }

        .mini-card {
            padding: 10px 10px 9px;
            border-radius: 14px;
            background-color: rgba(255, 255, 255, 0.95);
            border: 1px solid rgba(226, 232, 240, 0.9);
            box-shadow: 0 10px 26px rgba(148, 163, 184, 0.35);
        }

        .mini-card h5 {
            margin: 0 0 4px;
            font-size: 14px;
            display: inline-flex;
            align-items: center;
            gap: 6px;
        }

        .mini-card h5 i {
            font-size: 13px;
            color: #15803d;
        }

        .mini-card p {
            margin: 0;
            font-size: 13px;
            color: var(--muted);
            line-height: 1.55;
        }

        .roles-section {
            margin-top: 40px;
            overflow: hidden;
        }

        .roles-title {
            font-size: 16px;
            font-weight: 800;
            letter-spacing: 0.14em;
            text-transform: uppercase;
            color: #1f2937;
            margin-bottom: 16px;
        }

        .roles-strip {
            display: flex;
            gap: 12px;
            animation: scroll-roles 26s linear infinite;
            width: max-content;
        }

        .roles-track {
            display: flex;
            gap: 12px;
            width: max-content;
        }

        .role-pill {
            padding: 20px 22px;
            border-radius: 20px;
            background-color: #ffffff;
            border: 1px solid var(--border);
            display: flex;
            flex-direction: column;
            gap: 10px;
            font-size: 14px;
            min-width: 340px;
            box-shadow: 0 16px 40px rgba(148, 163, 184, 0.32);
            transition: transform 0.14s ease, box-shadow 0.14s ease, border-color 0.14s ease;
        }

        .role-pill-header {
            display: flex;
            align-items: center;
            gap: 8px;
        }

        .role-pill-icon {
            width: 38px;
            height: 38px;
            border-radius: 999px;
            display: grid;
            place-items: center;
            background-color: var(--bg-soft);
            color: #15803d;
            font-size: 16px;
        }

        .role-pill strong {
            font-size: 15px;
        }

        .role-pill span {
            color: var(--muted);
            display: -webkit-box;
            -webkit-line-clamp: 3;
            -webkit-box-orient: vertical;
            overflow: hidden;
        }

        .role-pill:hover {
            transform: translateY(-4px) scale(1.01);
            box-shadow: 0 14px 36px rgba(99, 102, 241, 0.14), 0 10px 26px rgba(148, 163, 184, 0.26);
            border-color: rgba(99, 102, 241, 0.16);
        }

        @media (prefers-reduced-motion: reduce) {

            .role-pill,
            .role-pill:hover {
                transition: none;
                transform: none;
                animation: none;
            }
        }

        .role-pill--wide {
            min-width: 380px;
            padding: 24px 26px;
            gap: 12px;
            font-size: 15px;
        }

        @keyframes scroll-roles {
            0% {
                transform: translateX(0);
            }

            100% {
                transform: translateX(-50%);
            }
        }

        @media (max-width: 900px) {
            .roles-strip {
                animation-duration: 22s;
            }
        }

        @media (max-width: 600px) {
            .roles-strip {
                animation-duration: 18s;
            }
        }

        footer {
            margin-top: 34px;
            padding-top: 16px;
            border-top: 1px dashed rgba(203, 213, 225, 0.9);
            font-size: 11px;
            color: var(--muted);
            display: flex;
            flex-wrap: wrap;
            gap: 8px;
            justify-content: space-between;
            align-items: center;
        }

        footer a {
            color: var(--primary);
            text-decoration: none;
            font-weight: 500;
        }

        footer a:hover {
            text-decoration: underline;
        }

        .footer-meta {
            display: inline-flex;
            align-items: center;
            gap: 8px;
            flex-wrap: wrap;
        }

        .dot {
            width: 4px;
            height: 4px;
            border-radius: 999px;
            background-color: #cbd5e1;
        }

        .burger {
            display: none;
            align-items: center;
            gap: 8px;
            padding: 8px 12px;
            border-radius: var(--radius-pill);
            border: 1px solid var(--border);
            background: #ffffff;
            cursor: pointer;
            position: static;
            margin-left: auto;
        }

        .burger i {
            color: var(--text);
        }

        .mobile-menu {
            display: none;
            flex-direction: column;
            gap: 8px;
            margin-top: 0;
            width: auto;
            position: fixed;
            left: 12px;
            right: 12px;
            top: var(--mobile-menu-top, 90px);
            padding: 12px 16px 16px;
            z-index: 19;
            background: rgba(255, 255, 255, 0.98);
            box-shadow: 0 12px 30px rgba(0, 0, 0, 0.08);
            border: 1px solid rgba(226, 232, 240, 0.95);
            border-radius: 18px;
            max-width: calc(100% - 24px);
            margin-inline: auto;
        }

        .mobile-menu.show {
            display: flex;
        }

        .mobile-menu a {
            display: inline-flex;
            align-items: center;
            gap: 8px;
            padding: 12px 14px;
            border-radius: 14px;
            text-decoration: none;
            font-weight: 600;
            font-size: 15px;
            color: var(--text);
            border: 1px solid rgba(203, 213, 225, 0.9);
            background: #fff;
        }

        .mobile-menu a:hover {
            background: #f8fafc;
        }

        .header-link {
            display: inline-flex;
        }

        @media (max-width: 600px) {
            .header-link {
                display: none;
            }

            .header-actions {
                justify-content: flex-end;
                width: 100%;
            }

            .burger {
                display: inline-flex;
                align-self: flex-end;
            }
        }
    </style>
</head>

<body>
    <div class="page">
        <header>
            <div class="brand">
                <div class="brand-logo">
                    {{-- <i class="fa-solid fa-lungs"></i> --}}
                    <img src="{{ asset('assets/img/situba-logo.png') }}" alt="SITUBA Logo" style="width:42px; height:auto;">
                </div>
                <div class="brand-text">
                    <strong>SITUBA Surakarta</strong>
                    <span>Tuberculosis Assistant</span>
                </div>
            </div>
            <div class="header-actions">
                <a href="{{ route('blog.index') }}" class="btn btn-ghost header-link">
                    <i class="fa-solid fa-newspaper"></i>
                    <span>Berita &amp; Edukasi</span>
                </a>
                <a href="{{ route('login') }}" class="btn btn-primary header-link">
                    <i class="fa-solid fa-arrow-right-to-bracket"></i>
                    <span>Masuk Dashboard</span>
                </a>
                <button class="burger" id="burgerToggle">
                    <i class="fa-solid fa-bars"></i>
                    <span>Menu</span>
                </button>
            </div>
        </header>

        <div class="mobile-menu" id="mobileMenu">
            <a href="{{ route('blog.index') }}"><i class="fa-solid fa-newspaper"></i> Berita &amp; Edukasi</a>
            <a href="{{ route('login') }}"><i class="fa-solid fa-arrow-right-to-bracket"></i> Masuk Dashboard</a>
        </div>

        <main>
            <section>
                <div class="eyebrow-badge">
                    <i class="fa-solid fa-bolt"></i>
                    <span>Transformasi layanan TBC Kota Surakarta</span>
                </div>

                <h1 class="hero-title">
                    Jejaring <span class="highlight">Pemda, Puskesmas, Kelurahan, Kader, hingga Pasien</span> dalam satu
                    layar.
                </h1>

                <p class="hero-subtitle">
                    SITUBA mempercepat deteksi, pemantauan, dan pendampingan TBC di Surakarta. Data dari lapangan
                    mengalir
                    ke pusat secara real-time: kader, kelurahan, puskesmas hingga Dinas Kesehatan terhubung tanpa sekat.
                </p>

                <div class="hero-actions">
                    <a href="{{ route('login') }}" class="btn btn-primary btn-large">
                        <i class="fa-solid fa-stethoscope"></i>
                        <span>Mulai Pantau Kasus</span>
                    </a>

                </div>

                <div class="hero-meta">
                    <div class="hero-meta-item">
                        <i class="fa-solid fa-shield-heart"></i>
                        <span>End-to-end</span>
                    </div>
                    <div class="hero-meta-item">
                        <i class="fa-solid fa-mobile-screen-button"></i>
                        <span>Skrining dari ponsel kader</span>
                    </div>
                </div>

                <div class="hero-stats-row">
                    <div class="pill-stat">
                        <div>
                            <span>Puskesmas</span><br>
                            <strong>{{ number_format($puskesmasCount ?? 0) }}</strong>
                        </div>
                        <i class="fa-solid fa-hospital"></i>
                    </div>
                    <div class="pill-stat">
                        <div>
                            <span>Kelurahan</span><br>
                            <strong>{{ number_format($kelurahanCount ?? 0) }}</strong>
                        </div>
                        <i class="fa-solid fa-location-dot"></i>
                    </div>
                    <div class="pill-stat">
                        <div>
                            <span>Rantai pelaporan</span><br>
                            <strong>Realtime</strong>
                        </div>
                        <i class="fa-solid fa-link"></i>
                    </div>
                </div>
            </section>

            <section class="hero-card">
                <div class="hero-card-inner">
                    <div class="hero-card-header">
                        <div class="chip">
                            <i class="fa-solid fa-route"></i>
                            <span>Alur singkat SITUBA</span>
                        </div>
                        <div class="text-glow">SITUBA</div>
                    </div>

                    <div class="timeline">
                        <div class="timeline-item">
                            <div class="timeline-step">01</div>
                            <div class="timeline-content">
                                <h4>
                                    <i class="fa-solid fa-user-check"></i>
                                    Deteksi lapangan oleh kader
                                </h4>
                                <p>
                                    Kader memetakan gejala dan riwayat kontak lalu mengisi skrining cepat melalui
                                    ponsel.
                                    Hasil langsung terekam di sistem.
                                </p>
                            </div>
                        </div>
                        <div class="timeline-item">
                            <div class="timeline-step">02</div>
                            <div class="timeline-content">
                                <h4>
                                    <i class="fa-solid fa-heart-pulse"></i>
                                    Tindak lanjut puskesmas
                                </h4>
                                <p>
                                    Petugas puskesmas memantau hasil skrining, menjadwalkan pemeriksaan dan memulai
                                    pengobatan serta pendampingan rutin.
                                </p>
                            </div>
                        </div>
                        <div class="timeline-item">
                            <div class="timeline-step">03</div>
                            <div class="timeline-content">
                                <h4>
                                    <i class="fa-solid fa-city"></i>
                                    Monitoring
                                </h4>
                                <p>
                                    Dinas Kesehatan memonitor progres kota, memvalidasi akun fasilitas, dan memastikan
                                    kepatuhan terapi di seluruh rantai layanan.
                                </p>
                            </div>
                        </div>
                    </div>

                    <div class="hero-card-footer">
                        <div class="mini-card">
                            <h5><i class="fa-solid fa-bell"></i> Notifikasi cepat</h5>
                            <p>Alert otomatis saat skrining positif, jadwal kontrol terlewat, atau obat tidak diambil.
                            </p>
                        </div>
                        <div class="mini-card">
                            <h5><i class="fa-solid fa-gauge-high"></i> Dashboard multi-peran</h5>
                            <p>Tampilan disesuaikan untuk pemda, puskesmas, kelurahan, kader, dan pasien.</p>
                        </div>
                        <div class="mini-card">
                            <h5><i class="fa-solid fa-shield-heart"></i> Data aman</h5>
                            <p>Hak akses berbasis peran, audit aktivitas, dan pengelolaan akun terpusat.</p>
                        </div>
                    </div>
                </div>
            </section>
        </main>

        <section class="roles-section">
            <div class="roles-title">Peran yang terhubung di SITUBA</div>
            <div class="roles-strip">
                <div class="roles-track">
                    <div class="role-pill">
                        <div class="role-pill-header">
                            <div class="role-pill-icon">
                                <i class="fa-solid fa-city"></i>
                            </div>
                            <strong>Pemerintah Daerah</strong>
                        </div>
                        <span>Melihat peta kasus kota, memantau capaian,<br> dan menetapkan kebijakan berbasis
                            data.</span>
                    </div>
                    <div class="role-pill">
                        <div class="role-pill-header">
                            <div class="role-pill-icon">
                                <i class="fa-solid fa-hospital"></i>
                            </div>
                            <strong>Puskesmas</strong>
                        </div>
                        <span>Mengelola kasus, jadwal kontrol,<br> dan hasil pemeriksaan laboratorium.</span>
                    </div>
                    <div class="role-pill role-pill--wide">
                        <div class="role-pill-header">
                            <div class="role-pill-icon">
                                <i class="fa-solid fa-people-roof"></i>
                            </div>
                            <strong>Kelurahan &amp; Kader</strong>
                        </div>
                        <span>Skrining aktif, pemetaan kontak erat,<br> dan pendampingan minum obat di lapangan.</span>
                    </div>
                    <div class="role-pill role-pill--wide">
                        <div class="role-pill-header">
                            <div class="role-pill-icon">
                                <i class="fa-solid fa-user"></i>
                            </div>
                            <strong>Pasien &amp; Keluarga</strong>
                        </div>
                        <span>Menerima pengingat obat, jadwal kontrol,<br> dan edukasi TBC yang terkurasi.</span>
                    </div>
                </div>
                <div class="roles-track">
                    <div class="role-pill">
                        <div class="role-pill-header">
                            <div class="role-pill-icon">
                                <i class="fa-solid fa-city"></i>
                            </div>
                            <strong>Pemerintah Daerah</strong>
                        </div>
                        <span>Melihat peta kasus kota, memantau capaian,<br> dan menetapkan kebijakan berbasis
                            data.</span>
                    </div>
                    <div class="role-pill">
                        <div class="role-pill-header">
                            <div class="role-pill-icon">
                                <i class="fa-solid fa-hospital"></i>
                            </div>
                            <strong>Puskesmas</strong>
                        </div>
                        <span>Mengelola kasus, jadwal kontrol,<br> dan hasil pemeriksaan laboratorium.</span>
                    </div>
                    <div class="role-pill role-pill--wide">
                        <div class="role-pill-header">
                            <div class="role-pill-icon">
                                <i class="fa-solid fa-people-roof"></i>
                            </div>
                            <strong>Kelurahan &amp; Kader</strong>
                        </div>
                        <span>Skrining aktif, pemetaan kontak erat, dan pendampingan minum obat di lapangan.</span>
                    </div>
                    <div class="role-pill role-pill--wide">
                        <div class="role-pill-header">
                            <div class="role-pill-icon">
                                <i class="fa-solid fa-user"></i>
                            </div>
                            <strong>Pasien &amp; Keluarga</strong>
                        </div>
                        <span>Menerima pengingat obat, jadwal kontrol,<br> dan edukasi TBC yang terkurasi.</span>
                    </div>
                </div>
            </div>
        </section>

        <footer>
            <div class="footer-meta">
                <span>© <span id="year"></span> SITUBA.</span>
                <span class="dot"></span>
            </div>

        </footer>
    </div>

    <script>
        document.getElementById('year').textContent = new Date().getFullYear();

        const burger = document.getElementById('burgerToggle');
        const mobileMenu = document.getElementById('mobileMenu');
        const headerEl = document.querySelector('header');

        const syncMenuTop = () => {
            if (headerEl) {
                const rect = headerEl.getBoundingClientRect();
                const offset = rect.top + rect.height + 8; // keep menu right under header
                document.documentElement.style.setProperty('--mobile-menu-top', `${offset}px`);
            }
        };

        syncMenuTop();
        window.addEventListener('resize', syncMenuTop);
        window.addEventListener('scroll', syncMenuTop, { passive: true });

        if (burger && mobileMenu) {
            burger.addEventListener('click', () => {
                syncMenuTop();
                mobileMenu.classList.toggle('show');
            });
            document.addEventListener('click', (e) => {
                if (!mobileMenu.contains(e.target) && !burger.contains(e.target)) {
                    mobileMenu.classList.remove('show');
                }
            });
        }
    </script>
</body>

</html>
