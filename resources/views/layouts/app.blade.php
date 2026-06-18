<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>{{ setting('site_name', 'Mercantil Medeiros LTDA') }}</title>
    <link rel="icon" type="image/x-icon" href="/images/favicon.ico">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Roboto:wght@300;400;500;600;700;900&family=Roboto+Slab:wght@400;700&display=swap" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        :root {
            --primary: {{ setting('primary_color', '#6ec1e4') }};
            --secondary: {{ setting('secondary_color', '#8db04a') }};
            --text-green: {{ setting('text_color', '#228b22') }};
            --dark-green: {{ setting('dark_green', '#387543') }};
            --gold: {{ setting('gold', '#e5a000') }};
        }
        * { margin: 0; padding: 0; box-sizing: border-box; }
        body { font-family: 'Roboto', sans-serif; }
        .nav-link:hover, .nav-link.active {
            background-color: var(--gold) !important;
            border-radius: 0.6rem !important;
            color: #fff !important;
        }
        .btn-encarte {
            display: inline-flex; justify-content: center; align-items: center;
            padding: 0.75rem 2rem; background-color: var(--gold);
            border-radius: 1rem; color: #fff !important; font-size: 1.2rem;
            font-weight: 500; text-decoration: none;
            box-shadow: 0.2rem 0.8rem 0.4rem #00000026; border: none;
        }
        .btn-encarte:hover { background-color: #b27c00; color: #fff !important; }
        .section-title {
            font-size: 1.8rem; color: #fff;
            border-left: solid 0.4rem var(--gold);
            padding: 0.52rem 0 0.52rem 2rem; font-weight: 600;
        }
        .section-title span { font-weight: 300; }
        .card-loja {
            background-color: var(--dark-green); display: flex;
            align-items: center; flex-flow: column; gap: 1rem;
            padding: 2rem; border-radius: 1.6rem;
            box-shadow: 0 0.8rem 0.4rem #00000026;
        }
        .btn-card-store {
            background-color: var(--gold); text-decoration: none;
            display: flex; justify-content: center; align-items: center;
            width: 10rem; height: 2.4rem; border-radius: 2rem;
            box-shadow: 0.2rem 0.8rem 0.4rem #00000026;
            font-weight: 600; color: #fff; border: none;
        }
        .btn-card-store:hover { background-color: #b27c00; color: #fff; }
        .oferta-card {
            background: #fff; border-radius: 1rem; overflow: hidden;
            box-shadow: 0 0.4rem 0.8rem #0000001a; transition: transform 0.3s;
        }
        .oferta-card:hover { transform: translateY(-5px); }
        .oferta-card img { width: 100%; height: 200px; object-fit: cover; }
        .card-vaga {
            background-color: #5c7961; border-radius: 15px;
            width: 300px; padding: 1rem; transition: all 0.3s ease;
            display: flex; flex-direction: column; min-height: 220px;
        }
        .card-vaga h4 { font-weight: 700; margin: 1rem 0 0.5rem; text-align: center; color: #fff; }
        footer a { line-height: 1.8; text-decoration: none; color: #fff; }
        footer a:hover { color: var(--gold); }
        .titulos-footer { font-size: 1.2rem; font-weight: 600; }
        .logo-bandeira { width: 30px; height: auto; object-fit: contain; }
        .secao-baixe-app { background-color: var(--dark-green); padding: 1.5rem 0; }
        .paragrafo-app { max-width: 22rem; font-size: 16px; color: #fff; font-weight: 600; }
        .titulo-encarte { font-size: 26px; color: #0a1ed8; font-weight: 600; }
        .subtitulo-encartes { font-size: 32px; color: var(--text-green); max-width: 25rem; font-weight: 600; }
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
