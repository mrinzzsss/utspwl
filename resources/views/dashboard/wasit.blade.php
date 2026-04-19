@php $withSidebar = true; @endphp
@extends('layouts.app')

@section('title', 'Dashboard Wasit')

@section('sidebar')
<div class="px-2">
    <div class="text-white-50 small fw-semibold text-uppercase px-2 mb-2 mt-1">Menu</div>
    <nav class="nav flex-column">
        <a class="nav-link active" href="{{ route('wasit.dashboard') }}">
            <i class="bi bi-speedometer2"></i> Dashboard
        </a>
        <a class="nav-link" href="{{ route('wasit.matches.index') }}">
            <i class="bi bi-calendar3"></i> Pertandingan
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
<h4 class="fw-bold mb-1">Dashboard Wasit</h4>
<p class="text-muted mb-4">Selamat datang, {{ auth()->user()->name }}!</p>

<h6 class="fw-bold mb-3 text-uppercase text-muted small">Pertandingan Menunggu Input Skor</h6>

@if($pendingMatches->isEmpty())
    <div class="alert alert-info">
        <i class="bi bi-info-circle me-2"></i>Tidak ada pertandingan yang menunggu input skor.
    </div>
@else
    <div class="row g-3 mb-4">
        @foreach($pendingMatches as $match)
        <div class="col-md-6">
            <div class="card border-0 shadow-sm h-100">
                <div class="card-body">
                    <div class="d-flex justify-content-between align-items-start mb-3">
                        <span class="badge
                            {{ $match->status === 'ongoing' ? 'bg-warning text-dark' : 'bg-secondary' }}">
                            {{ ucfirst($match->status) }}
                        </span>
                        <small class="text-muted">{{ $match->match_date->format('d M Y, H:i') }}</small>
                    </div>
                    <div class="d-flex align-items-center justify-content-between my-3">
                        <div class="text-center">
                            <div class="fw-bold fs-6">{{ $match->homeTeam->name }}</div>
                            <small class="text-muted">Home</small>
                        </div>
                        <div class="fw-bold text-muted px-3">VS</div>
                        <div class="text-center">
                            <div class="fw-bold fs-6">{{ $match->awayTeam->name }}</div>
                            <small class="text-muted">Away</small>
                        </div>
                    </div>
                    @if($match->venue)
                        <div class="text-muted small mb-3"><i class="bi bi-geo-alt me-1"></i>{{ $match->venue }}</div>
                    @endif
                    <a href="{{ route('wasit.matches.score.form', $match) }}"
                       class="btn btn-sm w-100" style="background:#0f2b5b; color:#fff;">
                        <i class="bi bi-pencil-square me-1"></i>Input Skor
                    </a>
                </div>
            </div>
        </div>
        @endforeach
    </div>
@endif

<h6 class="fw-bold mb-3 text-uppercase text-muted small">Skor Terakhir Diinput</h6>
@if($recentScored->isEmpty())
    <p class="text-muted">Belum ada skor yang diinput.</p>
@else
    <div class="card">
        <div class="table-responsive">
            <table class="table table-hover mb-0">
                <thead>
                    <tr>
                        <th>Home</th>
                        <th class="text-center">Skor</th>
                        <th>Away</th>
                        <th>Tanggal</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($recentScored as $match)
                    <tr>
                        <td class="fw-semibold {{ $match->home_score > $match->away_score ? 'text-success' : '' }}">
                            {{ $match->homeTeam->name }}
                        </td>
                        <td class="text-center fw-bold">{{ $match->home_score }} – {{ $match->away_score }}</td>
                        <td class="fw-semibold {{ $match->away_score > $match->home_score ? 'text-success' : '' }}">
                            {{ $match->awayTeam->name }}
                        </td>
                        <td class="text-muted small">{{ $match->match_date->format('d M Y') }}</td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
@endif
@endsection
