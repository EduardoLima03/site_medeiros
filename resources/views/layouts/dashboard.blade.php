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
            min-height: 100vh; background: #2c3e50;
            padding-top: 1rem;
        }
        .sidebar .nav-link {
            color: #bdc3c7; padding: 0.8rem 1.5rem;
            border-radius: 0; font-weight: 500;
        }
        .sidebar .nav-link:hover, .sidebar .nav-link.active {
            background: #34495e; color: #fff;
        }
        .sidebar .nav-link i { margin-right: 0.5rem; }
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
    </style>
    @stack('styles')
</head>
<body>
    <div class="container-fluid">
        <div class="row">
            <div class="col-md-2 sidebar p-0">
                <div class="text-center py-3">
                    <img src="/images/logo.png" alt="Medeiros" height="50">
                </div>
                <hr class="text-light">
                <ul class="nav flex-column">
                    <li class="nav-item">
                        <a class="nav-link {{ request()->routeIs('dashboard') ? 'active' : '' }}" href="{{ route('dashboard') }}">
                            <i class="bi bi-speedometer2"></i> Dashboard
                        </a>
                    </li>
                    @if(auth()->user()->role === 'client')
                    <li class="nav-item">
                        <a class="nav-link {{ request()->routeIs('dashboard') ? 'active' : '' }}" href="{{ route('dashboard') }}">
                            <i class="bi bi-house"></i> Minhas Candidaturas
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link {{ request()->routeIs('site.curriculo') ? 'active' : '' }}" href="{{ route('site.curriculo') }}">
                            <i class="bi bi-file-earmark-person"></i> Cadastrar Currículo
                        </a>
                    </li>
                    @endif
                    @if(auth()->user()->role === 'admin' || auth()->user()->role === 'rh')
                    <li class="nav-item">
                        <a class="nav-link {{ request()->routeIs('rh.*') ? 'active' : '' }}" href="{{ route('rh.vagas') }}">
                            <i class="bi bi-briefcase"></i> Vagas
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link {{ request()->routeIs('rh.curriculos*') ? 'active' : '' }}" href="{{ route('rh.curriculos') }}">
                            <i class="bi bi-file-earmark-person"></i> Currículos
                        </a>
                    </li>
                    @endif
                    @if(auth()->user()->role === 'admin' || auth()->user()->role === 'marketing')
                    <li class="nav-item">
                        <a class="nav-link {{ request()->routeIs('marketing.*') ? 'active' : '' }}" href="{{ route('marketing.ofertas') }}">
                            <i class="bi bi-tag"></i> Ofertas
                        </a>
                    </li>
                    @endif
                    @if(auth()->user()->role === 'admin')
                    <li class="nav-item">
                        <a class="nav-link {{ request()->routeIs('admin.*') ? 'active' : '' }}" href="{{ route('admin.index') }}">
                            <i class="bi bi-gear"></i> Configurações
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
                <div class="text-center">
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
