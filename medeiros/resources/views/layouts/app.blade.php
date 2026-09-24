<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <meta name="description" content="{{ setting('meta_description', 'Mercantil Medeiros - Supermercados em Fortaleza e Pacatuba') }}">
    <title>{{ setting('site_name', 'Mercantil Medeiros LTDA') }}</title>
    <link rel="icon" type="image/x-icon" href="/images/favicon.ico">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Roboto:wght@300;400;500;600;700;900&family=Roboto+Slab:wght@400;700&display=swap" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">
    <style>
        :root {
            --primary: {{ setting('primary_color', '#4c9f38') }};
            --secondary: {{ setting('secondary_color', '#8db04a') }};
            --text-green: {{ setting('text_color', '#2d5016') }};
            --dark-green: {{ setting('dark_green', '#2d5016') }};
            --gold: {{ setting('gold', '#e5a000') }};
            --light-green: #f2f8f0;
            --gray-bg: #f7f8f6;
            --radius: 1rem;
            --shadow: 0 10px 30px rgba(45, 80, 22, 0.08);
        }
        * { margin: 0; padding: 0; box-sizing: border-box; }
        body { font-family: 'Roboto', sans-serif; background: #fff; color: #2b2b2b; }

        /* ===== Top bar ===== */
        .topbar {
            background: var(--dark-green); color: #fff; font-size: 0.82rem;
            padding: 0.4rem 0;
        }
        .topbar a { color: rgba(255,255,255,0.9); text-decoration: none; }
        .topbar a:hover { color: var(--gold); }
        .topbar .icon { color: var(--gold); margin-right: 0.35rem; }

        /* ===== Navbar ===== */
        .main-nav { background: #fff; box-shadow: 0 2px 18px rgba(45,80,22,0.06); }
        .main-nav .navbar-brand img { height: 52px; }
        .main-nav .nav-link {
            font-weight: 600; color: #333; padding: 0.6rem 1rem;
            border-radius: 2rem; font-size: 0.92rem; white-space: nowrap;
        }
        .main-nav .nav-link:hover { color: var(--primary); background: var(--light-green); }
        .nav-cta {
            background: var(--gold); color: #fff !important; font-weight: 700;
            padding: 0.55rem 1.4rem; border-radius: 2rem; box-shadow: 0 4px 14px rgba(229,160,0,0.35);
        }
        .nav-cta:hover { background: #b27c00 !important; color: #fff !important; }

        /* ===== Botões ===== */
        .btn-encarte {
            display: inline-flex; justify-content: center; align-items: center;
            padding: 0.8rem 2.2rem; background-color: var(--gold);
            border-radius: 2rem; color: #fff !important; font-size: 1rem;
            font-weight: 700; text-decoration: none; border: none;
            box-shadow: 0 6px 18px rgba(229,160,0,0.35);
        }
        .btn-encarte:hover { background-color: #b27c00; transform: translateY(-2px); }
        .btn-green {
            display: inline-flex; justify-content: center; align-items: center;
            padding: 0.8rem 2rem; background-color: var(--dark-green);
            border-radius: 2rem; color: #fff !important; font-size: 1rem;
            font-weight: 700; text-decoration: none; border: none;
            box-shadow: 0 6px 18px rgba(45,80,22,0.25);
        }
        .btn-green:hover { background-color: #1f3d0f; color: #fff; transform: translateY(-2px); }
        .btn-outline-green {
            display: inline-flex; justify-content: center; align-items: center;
            padding: 0.75rem 1.8rem; border: 2px solid var(--dark-green);
            border-radius: 2rem; color: var(--dark-green) !important; font-weight: 700;
            background: transparent; text-decoration: none;
        }
        .btn-outline-green:hover { background: var(--dark-green); color: #fff !important; }

        /* ===== Seções ===== */
        section.block-section { padding: 4rem 0; }
        .section-title-wrap { margin-bottom: 2.5rem; }
        .section-title {
            font-size: 2rem; font-weight: 900; color: var(--text-green);
            position: relative; padding-left: 1.1rem; margin-bottom: 0.2rem;
        }
        .section-title::before {
            content: ''; position: absolute; left: 0; top: 0.15rem; bottom: 0.15rem;
            width: 0.45rem; background: var(--gold); border-radius: 1rem;
        }
        .section-subtitle { color: #6b7c63; font-size: 1rem; font-weight: 500; }

        /* ===== Cards ===== */
        .card-moderno {
            background: #fff; border-radius: var(--radius); border: none;
            box-shadow: var(--shadow); overflow: hidden; transition: transform 0.25s ease, box-shadow 0.25s ease;
            height: 100%;
        }
        .card-moderno:hover { transform: translateY(-6px); box-shadow: 0 18px 40px rgba(45,80,22,0.14); }
        .card-moderno img { width: 100%; height: 200px; object-fit: cover; }
        .card-moderno .card-body { padding: 1.4rem; }
        .badge-oferta {
            position: absolute; top: 1rem; right: 1rem; background: var(--gold);
            color: #fff; font-weight: 800; font-size: 0.8rem; padding: 0.4rem 0.8rem;
            border-radius: 1rem; box-shadow: 0 4px 10px rgba(0,0,0,0.2);
        }

        /* ===== Carrossel ===== */
        .carrossel-block { position: relative; }
        .carrossel-img {
            width: 100%; height: 560px; object-fit: cover;
        }
        .carrossel-block .carousel-caption {
            background: linear-gradient(0deg, rgba(21,42,10,0.75) 0%, transparent 100%);
            left: 0; right: 0; bottom: 0; padding: 2rem 1rem 1.2rem;
        }

        /* ===== Hero banner ===== */
        .hero-block { position: relative; min-height: 460px; display: flex; align-items: center;
            background-size: cover; background-position: center; color: #fff;
        }
        .hero-block::before {
            content: ''; position: absolute; inset: 0;
            background: linear-gradient(90deg, rgba(21,42,10,0.92) 0%, rgba(21,42,10,0.55) 55%, rgba(21,42,10,0.15) 100%);
        }
        .hero-block .hero-content { position: relative; z-index: 2; max-width: 34rem; }
        .hero-block .hero-tag {
            display: inline-block; background: var(--gold); color: #fff; font-weight: 800;
            font-size: 0.78rem; letter-spacing: 1.5px; text-transform: uppercase;
            padding: 0.4rem 1rem; border-radius: 1rem; margin-bottom: 1.2rem;
        }
        .hero-block h1 { font-size: clamp(2rem, 4vw, 3.3rem); font-weight: 900; line-height: 1.15; }
        .hero-block p { font-size: 1.1rem; opacity: 0.95; }

        /* ===== Texto ===== */
        .texto-block .texto-conteudo { font-size: 1.05rem; line-height: 1.85; color: #4a4a4a; }
        .texto-block .texto-conteudo p { margin-bottom: 1rem; }

        /* ===== Lojas ===== */
        .card-loja {
            background: var(--dark-green); color: #fff; border-radius: var(--radius);
            padding: 1.6rem; height: 100%; display: flex; flex-direction: column;
            box-shadow: 0 10px 24px rgba(45,80,22,0.2);
        }
        .card-loja .loja-icon { font-size: 2rem; color: var(--gold); }
        .card-loja h5 { font-weight: 800; }
        .card-loja p { font-size: 0.9rem; opacity: 0.95; margin-bottom: 0.4rem; }
        .btn-card-store {
            background: var(--gold); color: #fff; font-weight: 700; text-decoration: none;
            padding: 0.55rem 1rem; border-radius: 2rem; display: inline-flex; align-items: center; gap: 0.4rem;
            margin-top: auto; align-self: flex-start;
        }
        .btn-card-store:hover { background: #b27c00; color: #fff; }

        /* ===== Vagas ===== */
        .card-vaga {
            background: var(--dark-green); color: #fff; border-radius: var(--radius);
            padding: 1.6rem; height: 100%; display: flex; flex-direction: column;
            box-shadow: 0 10px 24px rgba(45,80,22,0.2); transition: transform 0.2s;
        }
        .card-vaga:hover { transform: translateY(-4px); }
        .card-vaga h4 { font-weight: 800; }
        .card-vaga p { opacity: 0.92; font-size: 0.92rem; }
        .card-vaga .vaga-badge {
            background: var(--gold); color: #fff; font-weight: 700; font-size: 0.72rem;
            padding: 0.3rem 0.8rem; border-radius: 1rem; align-self: flex-start; text-transform: uppercase;
        }

        /* ===== CTA app ===== */
        .cta-app {
            background: var(--dark-green); color: #fff; border-radius: 2rem;
            padding: 3rem; position: relative; overflow: hidden;
        }
        .cta-app h3 { font-weight: 900; }
        .cta-app .app-links a {
            display: inline-flex; align-items: center; gap: 0.5rem; background: #fff;
            color: var(--dark-green); font-weight: 700; text-decoration: none;
            padding: 0.75rem 1.4rem; border-radius: 1rem; margin-right: 0.6rem;
        }

        /* ===== Footer ===== */
        footer { background: #1a2b12; color: rgba(255,255,255,0.85); }
        footer .footer-col h5 { color: #fff; font-weight: 800; margin-bottom: 1rem; font-size: 1rem; }
        footer a { color: rgba(255,255,255,0.75); text-decoration: none; line-height: 2.1; }
        footer a:hover { color: var(--gold); }
        footer .social a {
            display: inline-flex; width: 2.4rem; height: 2.4rem; align-items: center;
            justify-content: center; border-radius: 50%; background: rgba(255,255,255,0.1);
            margin-right: 0.5rem; font-size: 1.1rem;
        }
        footer .social a:hover { background: var(--gold); color: #fff; }
        footer .footer-bottom { border-top: 1px solid rgba(255,255,255,0.12); padding: 1rem 0; font-size: 0.82rem; }

        .light-bg { background: var(--gray-bg); }
        .green-bg { background: var(--light-green); }

        @media (max-width: 768px) {
            .hero-block { min-height: 380px; }
            .carrossel-img { height: 260px; }
            section.block-section { padding: 2.5rem 0; }
        }
    </style>
    @stack('styles')
</head>
<body>
    @include('components.navbar')

    <main>
        @yield('content')
    </main>

    @include('components.footer')

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
    <script type="module" src="https://unpkg.com/ionicons@7.1.0/dist/ionicons/ionicons.esm.js"></script>
    <script nomodule src="https://unpkg.com/ionicons@7.1.0/dist/ionicons/ionicons.js"></script>
    @stack('scripts')
</body>
</html>