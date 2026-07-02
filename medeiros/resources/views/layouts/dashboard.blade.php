<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>{{ setting('site_name') }} - Painel</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">
    <style>
        body { font-family: 'Roboto', sans-serif; background: #f5f6fa; }
        .sidebar {
            min-height: 100vh; background: #1a252f;
            padding-top: 0;
        }
        .sidebar .nav-section {
            color: #7f8c8d; font-size: 0.65rem;
            text-transform: uppercase; letter-spacing: 1px;
            padding: 1rem 1.5rem 0.3rem 1.5rem;
            font-weight: 700;
        }
        .sidebar .nav-link {
            color: #bdc3c7; padding: 0.6rem 1.5rem;
            border-radius: 0; font-weight: 500;
            font-size: 0.88rem;
            border-left: 3px solid transparent;
        }
        .sidebar .nav-link:hover, .sidebar .nav-link.active {
            background: #2c3e50; color: #fff;
            border-left-color: var(--gold, #e5a000);
        }
        .sidebar .nav-link i { margin-right: 0.6rem; width: 1.1rem; text-align: center; }
        .main-content { padding: 2rem; }
        .card-dashboard {
            border-radius: 10px; border: none;
            box-shadow: 0 2px 10px rgba(0,0,0,0.08);
        }
        .card-dashboard .card-body { padding: 1.5rem; }
        .badge-role {
            font-size: 0.7rem; padding: 0.2rem 0.6rem;
            border-radius: 20px;
        }
        .sidebar-logo {
            background: #141e28; padding: 1rem;
            text-align: center;
            border-bottom: 1px solid #2c3e50;
        }
    </style>
    @stack('styles')
</head>
<body>
    <div class="container-fluid">
        <div class="row">
            <div class="col-md-2 sidebar p-0">
                <div class="sidebar-logo">
                    <img src="/images/logo.png" alt="Medeiros" height="45">
                </div>
                <ul class="nav flex-column">
                    <li class="nav-item">
                        <a class="nav-link {{ request()->routeIs('dashboard') ? 'active' : '' }}" href="{{ route('dashboard') }}">
                            <i class="bi bi-speedometer2"></i> Dashboard
                        </a>
                    </li>

                    @if(in_array(auth()->user()->role, ['admin', 'rh']))
                    <li class="nav-item"><div class="nav-section">Recursos Humanos</div></li>
                    <li class="nav-item">
                        <a class="nav-link" href="{{ env('RH_SITE_URL', 'http://localhost:8001') }}/dashboard" target="_blank">
                            <i class="bi bi-box-arrow-up-right"></i> RH (Sistema Separado)
                        </a>
                    </li>
                    @endif

                    @if(auth()->user()->role === 'admin' || auth()->user()->role === 'marketing')
                    <li class="nav-item"><div class="nav-section">Marketing</div></li>
                    <li class="nav-item">
                        <a class="nav-link {{ request()->routeIs('marketing.*') ? 'active' : '' }}" href="{{ route('marketing.ofertas') }}">
                            <i class="bi bi-tag"></i> Ofertas
                        </a>
                    </li>
                    @endif

                    @if(auth()->user()->role === 'admin')
                    <li class="nav-item"><div class="nav-section">Administração</div></li>
                    <li class="nav-item">
                        <a class="nav-link {{ request()->routeIs('admin.index') ? 'active' : '' }}" href="{{ route('admin.index') }}">
                            <i class="bi bi-speedometer2"></i> Painel
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link {{ request()->routeIs('admin.pages*') ? 'active' : '' }}" href="{{ route('admin.pages') }}">
                            <i class="bi bi-file-earmark-text"></i> Páginas
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link {{ request()->routeIs('admin.appearance*') ? 'active' : '' }}" href="{{ route('admin.appearance') }}">
                            <i class="bi bi-palette"></i> Aparência
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link {{ request()->routeIs('admin.settings*') ? 'active' : '' }}" href="{{ route('admin.settings') }}">
                            <i class="bi bi-gear"></i> Configurações
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link {{ request()->routeIs('admin.media*') ? 'active' : '' }}" href="{{ route('admin.media') }}">
                            <i class="bi bi-images"></i> Mídia
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link {{ request()->routeIs('admin.menu*') ? 'active' : '' }}" href="{{ route('admin.menu') }}">
                            <i class="bi bi-list"></i> Menu
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link {{ request()->routeIs('admin.users*') ? 'active' : '' }}" href="{{ route('admin.users') }}">
                            <i class="bi bi-people"></i> Usuários
                        </a>
                    </li>
                    @endif
                </ul>
                <hr class="text-light">
                <div class="text-center px-3">
                    <span class="badge-role badge bg-{{ auth()->user()->role === 'admin' ? 'danger' : (auth()->user()->role === 'rh' ? 'primary' : (auth()->user()->role === 'marketing' ? 'success' : 'secondary')) }} text-white text-uppercase">{{ auth()->user()->role }}</span>
                    <div class="mt-2">
                        <a href="{{ route('site.home') }}" class="text-light small" target="_blank"><i class="bi bi-box-arrow-up-right"></i> Ver Site</a>
                        <br>
                        <a href="{{ route('logout') }}" class="text-light small" onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
                            <i class="bi bi-box-arrow-right"></i> Sair
                        </a>
                        <form id="logout-form" action="{{ route('logout') }}" method="POST" class="d-none">@csrf</form>
                    </div>
                </div>
            </div>
            <div class="col-md-10 main-content">
                @if(session('success'))
                    <div class="alert alert-success alert-dismissible fade show">{{ session('success') }}<button type="button" class="btn-close" data-bs-dismiss="alert"></button></div>
                @endif
                @yield('content')
            </div>
        </div>
    </div>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
    @stack('scripts')
</body>
</html>
