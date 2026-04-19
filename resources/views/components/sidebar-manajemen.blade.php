<div class="px-2">
    <div class="text-white-50 small fw-semibold text-uppercase px-2 mb-2 mt-1">Menu</div>
    <nav class="nav flex-column">
        <a class="nav-link {{ ($active ?? '') === 'dashboard' ? 'active' : '' }}" href="{{ route('manajemen.dashboard') }}">
            <i class="bi bi-speedometer2"></i> Dashboard
        </a>
        <a class="nav-link {{ ($active ?? '') === 'teams' ? 'active' : '' }}" href="{{ route('manajemen.teams.index') }}">
            <i class="bi bi-shield-fill"></i> Tim
        </a>
        <a class="nav-link {{ ($active ?? '') === 'players' ? 'active' : '' }}" href="{{ route('manajemen.players.index') }}">
            <i class="bi bi-people-fill"></i> Pemain
        </a>
        <a class="nav-link {{ ($active ?? '') === 'matches' ? 'active' : '' }}" href="{{ route('manajemen.matches.index') }}">
            <i class="bi bi-calendar3"></i> Pertandingan
        </a>
        <a class="nav-link {{ ($active ?? '') === 'standings' ? 'active' : '' }}" href="{{ route('manajemen.standings.index') }}">
            <i class="bi bi-bar-chart-line-fill"></i> Klasemen
        </a>
        <a class="nav-link {{ ($active ?? '') === 'users' ? 'active' : '' }}" href="{{ route('manajemen.users.index') }}">
            <i class="bi bi-person-badge-fill"></i> Pengguna
        </a>
    </nav>
    <hr class="border-secondary my-3">
    <form action="{{ route('logout') }}" method="POST">
        @csrf
        <button class="btn btn-sm btn-outline-danger w-100">
            <i class="bi bi-box-arrow-right me-1"></i> Logout
        </button>
    </form>
</div>
