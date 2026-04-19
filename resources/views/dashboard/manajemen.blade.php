@php $withSidebar = true; @endphp
@extends('layouts.app')

@section('title', 'Dashboard Manajemen')

@section('sidebar')
<div class="px-2">
    <div class="text-white-50 small fw-semibold text-uppercase px-2 mb-2 mt-1">Menu</div>
    <nav class="nav flex-column">
        <a class="nav-link active" href="{{ route('manajemen.dashboard') }}">
            <i class="bi bi-speedometer2"></i> Dashboard
        </a>
        <a class="nav-link" href="{{ route('manajemen.teams.index') }}">
            <i class="bi bi-shield-fill"></i> Tim
        </a>
        <a class="nav-link" href="{{ route('manajemen.players.index') }}">
            <i class="bi bi-people-fill"></i> Pemain
        </a>
        <a class="nav-link" href="{{ route('manajemen.matches.index') }}">
            <i class="bi bi-calendar3"></i> Pertandingan
        </a>
        <a class="nav-link" href="{{ route('manajemen.standings.index') }}">
            <i class="bi bi-bar-chart-line-fill"></i> Klasemen
        </a>
        <a class="nav-link" href="{{ route('manajemen.users.index') }}">
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
@endsection

@section('content')
<h4 class="fw-bold mb-1">Dashboard Manajemen</h4>
<p class="text-muted mb-4">Selamat datang, {{ auth()->user()->name }}!</p>

<div class="row g-3 mb-4">
    <div class="col-sm-6 col-lg-3">
        <div class="card text-white" style="background:#0f2b5b;">
            <div class="card-body d-flex align-items-center gap-3">
                <i class="bi bi-shield-fill fs-2 opacity-75"></i>
                <div>
                    <div class="fs-1 fw-bold lh-1">{{ $totalTeams }}</div>
                    <div class="small opacity-75">Total Tim</div>
                </div>
            </div>
        </div>
    </div>
    <div class="col-sm-6 col-lg-3">
        <div class="card text-white" style="background:#1e40af;">
            <div class="card-body d-flex align-items-center gap-3">
                <i class="bi bi-calendar3 fs-2 opacity-75"></i>
                <div>
                    <div class="fs-1 fw-bold lh-1">{{ $totalMatches }}</div>
                    <div class="small opacity-75">Total Pertandingan</div>
                </div>
            </div>
        </div>
    </div>
    <div class="col-sm-6 col-lg-3">
        <div class="card text-white" style="background:#065f46;">
            <div class="card-body d-flex align-items-center gap-3">
                <i class="bi bi-clock-fill fs-2 opacity-75"></i>
                <div>
                    <div class="fs-1 fw-bold lh-1">{{ $upcoming }}</div>
                    <div class="small opacity-75">Terjadwal</div>
                </div>
            </div>
        </div>
    </div>
    <div class="col-sm-6 col-lg-3">
        <div class="card text-white" style="background:#92400e;">
            <div class="card-body d-flex align-items-center gap-3">
                <i class="bi bi-flag-fill fs-2 opacity-75"></i>
                <div>
                    <div class="fs-1 fw-bold lh-1">{{ $finished }}</div>
                    <div class="small opacity-75">Selesai</div>
                </div>
            </div>
        </div>
    </div>
</div>

<div class="row g-3">
    <div class="col-md-4">
        <div class="card h-100">
            <div class="card-body text-center py-4">
                <i class="bi bi-shield-plus fs-1 text-primary mb-2"></i>
                <h6 class="fw-bold">Kelola Tim</h6>
                <p class="text-muted small">Tambah, edit, dan hapus tim peserta</p>
                <a href="{{ route('manajemen.teams.index') }}" class="btn btn-primary btn-sm px-4">Buka</a>
            </div>
        </div>
    </div>
    <div class="col-md-4">
        <div class="card h-100">
            <div class="card-body text-center py-4">
                <i class="bi bi-calendar3-plus fs-1 text-success mb-2"></i>
                <h6 class="fw-bold">Jadwal Pertandingan</h6>
                <p class="text-muted small">Atur jadwal dan status pertandingan</p>
                <a href="{{ route('manajemen.matches.index') }}" class="btn btn-success btn-sm px-4">Buka</a>
            </div>
        </div>
    </div>
    <div class="col-md-4">
        <div class="card h-100">
            <div class="card-body text-center py-4">
                <i class="bi bi-person-badge-fill fs-1 text-warning mb-2"></i>
                <h6 class="fw-bold">Manajemen User</h6>
                <p class="text-muted small">Kelola akun wasit dan manajemen</p>
                <a href="{{ route('manajemen.users.index') }}" class="btn btn-warning btn-sm px-4">Buka</a>
            </div>
        </div>
    </div>
</div>
@endsection
