<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>Medeiros RH - Trabalhe Conosco</title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Roboto:wght@300;400;500;600;700;900&display=swap" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        :root {
            --dark-green: #387543;
            --gold: #e5a000;
            --text-green: #228b22;
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
        .card-vaga {
            background-color: #5c7961; border-radius: 15px;
            width: 300px; padding: 1rem; transition: all 0.3s ease;
            display: flex; flex-direction: column; min-height: 220px;
        }
        .card-vaga h4 { font-weight: 700; margin: 1rem 0 0.5rem; text-align: center; color: #fff; }
        footer a { line-height: 1.8; text-decoration: none; color: #fff; }
        footer a:hover { color: var(--gold); }
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
    @stack('scripts')
</body>
</html>
