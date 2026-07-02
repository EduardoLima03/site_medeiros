<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>Medeiros RH - Painel</title>
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
            border-left-color: #e5a000;
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
                    <img src="/images/logo.png" alt="Medeiros" height="45" onerror="this.style.display='none'">
                </div>
                <ul class="nav flex-column">
                    <li class="nav-item">
                        <a class="nav-link {{ request()->routeIs('rh.home') ? 'active' : '' }}" href="{{ route('rh.home') }}">
                            <i class="bi bi-speedometer2"></i> Dashboard
                        </a>
                    </li>

                    @if(auth()->user()->role === 'client')
                    <li class="nav-item">
                        <a class="nav-link {{ request()->routeIs('site.curriculo') ? 'active' : '' }}" href="{{ route('site.curriculo') }}">
                            <i class="bi bi-file-earmark-person"></i> Cadastrar Currículo
                        </a>
                    </li>
                    @endif

                    @if(in_array(auth()->user()->role, ['admin', 'rh']))
                    <li class="nav-item"><div class="nav-section">Recursos Humanos</div></li>
                    <li class="nav-item">
                        <a class="nav-link {{ request()->routeIs('rh.vagas*') ? 'active' : '' }}" href="{{ route('rh.vagas') }}">
                            <i class="bi bi-briefcase"></i> Vagas
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link {{ request()->routeIs('rh.curriculos*') ? 'active' : '' }}" href="{{ route('rh.curriculos') }}">
                            <i class="bi bi-file-earmark-person"></i> Currículos
                        </a>
                    </li>
                    @endif
                </ul>
                <hr class="text-light">
                <div class="text-center px-3">
                    <span class="badge-role badge bg-{{ auth()->user()->role === 'admin' ? 'danger' : (auth()->user()->role === 'rh' ? 'primary' : 'secondary') }} text-white text-uppercase">{{ auth()->user()->role }}</span>
                    <div class="mt-2">
                        <a href="{{ url('/') }}" class="text-light small" target="_blank"><i class="bi bi-box-arrow-up-right"></i> Ver Site</a>
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
