@extends('layouts.app')

@section('title', 'MPL Lite — Beranda')

@section('content')
{{-- Hero --}}
<div class="row mb-4" style="margin: -2rem -2rem 0 -2rem; padding: 3rem 2rem; background: linear-gradient(135deg, #0a1a38 0%, #1e3a8a 100%); color: #fff;">
    <div class="col-md-8">
        <h1 class="fw-bold display-5 mb-2">
            <i class="bi bi-trophy-fill text-warning me-2"></i>MPL <span class="text-warning">LITE</span>
        </h1>
        <p class="fs-5 text-white-50 mb-3">Platform manajemen turnamen Mobile Legends Professional League</p>
        @guest
            <a href="{{ route('login') }}" class="btn btn-warning btn-lg px-4 fw-semibold">
                <i class="bi bi-box-arrow-in-right me-2"></i>Masuk ke Dashboard
            </a>
        @endguest
        @auth
            @if(auth()->user()->role === 'manajemen')
                <a href="{{ route('manajemen.dashboard') }}" class="btn btn-warning btn-lg px-4 fw-semibold">
                    <i class="bi bi-speedometer2 me-2"></i>Buka Dashboard
                </a>
            @elseif(auth()->user()->role === 'wasit')
                <a href="{{ route('wasit.dashboard') }}" class="btn btn-warning btn-lg px-4 fw-semibold">
                    <i class="bi bi-speedometer2 me-2"></i>Buka Dashboard
                </a>
            @endif
        @endauth
    </div>
    <div class="col-md-4 d-none d-md-flex align-items-center justify-content-end">
        <i class="bi bi-joystick" style="font-size: 7rem; opacity:.15;"></i>
    </div>
</div>

<div class="row g-4 mt-2">

    {{-- Klasemen --}}
    <div class="col-md-5">
        <div class="card h-100">
            <div class="card-header d-flex justify-content-between align-items-center py-3"
                 style="background:#0f2b5b; color:#fff;">
                <span class="fw-semibold"><i class="bi bi-bar-chart-line-fill me-2"></i>Klasemen {{ date('Y') }}</span>
            </div>
            <div class="card-body p-0">
                @if($standings->isEmpty())
                    <div class="p-4 text-center text-muted">Belum ada data klasemen</div>
                @else
                    <div class="table-responsive">
                        <table class="table table-hover mb-0">
                            <thead>
                                <tr>
                                    <th class="ps-3">#</th>
                                    <th>Tim</th>
                                    <th class="text-center">M</th>
                                    <th class="text-center">W</th>
                                    <th class="text-center">L</th>
                                    <th class="text-center">Pts</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($standings as $i => $s)
                                <tr>
                                    <td class="ps-3 fw-bold">
                                        @if($i === 0) <span class="text-warning">🥇</span>
                                        @elseif($i === 1) <span>🥈</span>
                                        @elseif($i === 2) <span>🥉</span>
                                        @else {{ $i + 1 }}
                                        @endif
                                    </td>
                                    <td class="fw-semibold">{{ $s->team->name }}</td>
                                    <td class="text-center">{{ $s->played }}</td>
                                    <td class="text-center text-success fw-semibold">{{ $s->wins }}</td>
                                    <td class="text-center text-danger">{{ $s->losses }}</td>
                                    <td class="text-center">
                                        <span class="badge rounded-pill" style="background:#0f2b5b;">{{ $s->points }}</span>
                                    </td>
                                </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                @endif
            </div>
        </div>
    </div>

    <div class="col-md-7">
        {{-- Pertandingan Mendatang --}}
        <div class="card mb-4">
            <div class="card-header d-flex justify-content-between align-items-center py-3"
                 style="background:#0f2b5b; color:#fff;">
                <span class="fw-semibold"><i class="bi bi-calendar3-event me-2"></i>Jadwal Mendatang</span>
            </div>
            <div class="card-body p-0">
                @if($upcomingMatches->isEmpty())
                    <div class="p-4 text-center text-muted">Tidak ada jadwal mendatang</div>
                @else
                    @foreach($upcomingMatches as $match)
                    <div class="d-flex align-items-center justify-content-between px-4 py-3 border-bottom">
                        <div class="text-end" style="width:38%;">
                            <div class="fw-semibold">{{ $match->homeTeam->name }}</div>
                            <small class="text-muted">Home</small>
                        </div>
                        <div class="text-center px-3">
                            <span class="badge bg-warning text-dark fw-bold px-3 py-2">VS</span>
                            <div class="text-muted small mt-1">{{ $match->match_date->format('d M, H:i') }}</div>
                        </div>
                        <div class="text-start" style="width:38%;">
                            <div class="fw-semibold">{{ $match->awayTeam->name }}</div>
                            <small class="text-muted">Away</small>
                        </div>
                    </div>
                    @endforeach
                @endif
            </div>
        </div>

        {{-- Hasil Terbaru --}}
        <div class="card">
            <div class="card-header d-flex justify-content-between align-items-center py-3"
                 style="background:#0f2b5b; color:#fff;">
                <span class="fw-semibold"><i class="bi bi-flag-fill me-2"></i>Hasil Terbaru</span>
            </div>
            <div class="card-body p-0">
                @if($recentMatches->isEmpty())
                    <div class="p-4 text-center text-muted">Belum ada hasil pertandingan</div>
                @else
                    @foreach($recentMatches as $match)
                    <div class="d-flex align-items-center justify-content-between px-4 py-3 border-bottom">
                        <div class="text-end" style="width:36%;">
                            <div class="fw-semibold {{ $match->home_score > $match->away_score ? 'text-success' : '' }}">
                                {{ $match->homeTeam->name }}
                            </div>
                        </div>
                        <div class="text-center px-3">
                            <span class="fw-bold fs-5">{{ $match->home_score }} – {{ $match->away_score }}</span>
                            <div class="text-muted small">{{ $match->match_date->format('d M') }}</div>
                        </div>
                        <div class="text-start" style="width:36%;">
                            <div class="fw-semibold {{ $match->away_score > $match->home_score ? 'text-success' : '' }}">
                                {{ $match->awayTeam->name }}
                            </div>
                        </div>
                    </div>
                    @endforeach
                @endif
            </div>
        </div>
    </div>
</div>
@endsection
