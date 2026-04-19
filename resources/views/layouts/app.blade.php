<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>@yield('title', 'MPL Lite')</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css" rel="stylesheet">
    <style>
        :root {
            --mpl-blue: #0f2b5b;
            --mpl-gold: #f5a623;
            --mpl-dark: #0a1a38;
        }
        body { background-color: #f4f6fb; font-family: 'Segoe UI', sans-serif; }
        .navbar-brand span { color: var(--mpl-gold); }
        .navbar { background: var(--mpl-dark) !important; }
        .sidebar {
            min-height: calc(100vh - 56px);
            background: var(--mpl-blue);
            color: #fff;
        }
        .sidebar .nav-link {
            color: rgba(255,255,255,0.75);
            padding: .5rem 1rem;
            border-radius: 6px;
            margin-bottom: 2px;
        }
        .sidebar .nav-link:hover, .sidebar .nav-link.active {
            background: var(--mpl-gold);
            color: #0a1a38;
            font-weight: 600;
        }
        .sidebar .nav-link i { margin-right: 8px; }
        .main-content { padding: 2rem; }
        .card { border: none; border-radius: 12px; box-shadow: 0 2px 12px rgba(0,0,0,.06); }
        .card-header { border-radius: 12px 12px 0 0 !important; }
        .table thead th { background: var(--mpl-blue); color: #fff; border: none; }
        .btn-primary { background: var(--mpl-blue); border-color: var(--mpl-blue); }
        .btn-primary:hover { background: var(--mpl-dark); }
        .badge-manajemen { background: #1e3a8a; }
        .badge-wasit { background: #065f46; }
        .badge-player { background: #92400e; }
    </style>
    @stack('styles')
</head>
<body>

{{-- Navbar --}}
<nav class="navbar navbar-expand-lg navbar-dark">
    <div class="container-fluid px-4">
        <a class="navbar-brand fw-bold" href="{{ route('home') }}">
            <i class="bi bi-trophy-fill text-warning me-2"></i>MPL <span>LITE</span>
        </a>
        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarMain">
            <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse" id="navbarMain">
            <ul class="navbar-nav ms-auto align-items-center gap-2">
                <li class="nav-item">
                    <a class="nav-link text-white" href="{{ route('home') }}">
                        <i class="bi bi-house-fill"></i> Home
                    </a>
                </li>
                @auth
                    <li class="nav-item dropdown">
                        <a class="nav-link dropdown-toggle text-white d-flex align-items-center gap-2" href="#" data-bs-toggle="dropdown">
                            <i class="bi bi-person-circle fs-5"></i>
                            <span>{{ auth()->user()->name }}</span>
                            <span class="badge bg-warning text-dark text-uppercase small">{{ auth()->user()->role }}</span>
                        </a>
                        <ul class="dropdown-menu dropdown-menu-end">
                            @if(auth()->user()->role === 'manajemen')
                                <li><a class="dropdown-item" href="{{ route('manajemen.dashboard') }}"><i class="bi bi-speedometer2 me-2"></i>Dashboard</a></li>
                            @elseif(auth()->user()->role === 'wasit')
                                <li><a class="dropdown-item" href="{{ route('wasit.dashboard') }}"><i class="bi bi-speedometer2 me-2"></i>Dashboard</a></li>
                            @endif
                            <li><hr class="dropdown-divider"></li>
                            <li>
                                <form action="{{ route('logout') }}" method="POST">
                                    @csrf
                                    <button class="dropdown-item text-danger">
                                        <i class="bi bi-box-arrow-right me-2"></i>Logout
                                    </button>
                                </form>
                            </li>
                        </ul>
                    </li>
                @else
                    <li class="nav-item">
                        <a class="btn btn-warning btn-sm px-3" href="{{ route('login') }}">
                            <i class="bi bi-box-arrow-in-right me-1"></i>Login
                        </a>
                    </li>
                @endauth
            </ul>
        </div>
    </div>
</nav>

{{-- Content area --}}
@if(isset($withSidebar) && $withSidebar)
<div class="container-fluid p-0">
    <div class="row g-0">
        <div class="col-md-2 sidebar py-3 px-2">
            @yield('sidebar')
        </div>
        <div class="col-md-10 main-content">
            @include('components.alerts')
            @yield('content')
        </div>
    </div>
</div>
@else
<div class="container-fluid">
    <div class="main-content">
        @include('components.alerts')
        @yield('content')
    </div>
</div>
@endif

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
@stack('scripts')
</body>
</html>
