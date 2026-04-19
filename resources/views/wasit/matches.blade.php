@php $withSidebar = true; @endphp
@extends('layouts.app')
@section('title', 'Daftar Pertandingan')

@section('sidebar')
<div class="px-2">
    <div class="text-white-50 small fw-semibold text-uppercase px-2 mb-2 mt-1">Menu</div>
    <nav class="nav flex-column">
        <a class="nav-link" href="{{ route('wasit.dashboard') }}">
            <i class="bi bi-speedometer2"></i> Dashboard
        </a>
        <a class="nav-link active" href="{{ route('wasit.matches.index') }}">
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
<h4 class="fw-bold mb-1">Daftar Pertandingan</h4>
<p class="text-muted mb-4">Lihat jadwal dan klik "Input Skor" untuk pertandingan yang belum selesai</p>

{{-- Filter --}}
<form method="GET" class="mb-3">
    <div class="d-flex gap-2 flex-wrap">
        @foreach(['' => 'Semua', 'scheduled' => 'Terjadwal', 'ongoing' => 'Berlangsung', 'finished' => 'Selesai'] as $val => $label)
        <a href="{{ route('wasit.matches.index', $val ? ['status' => $val] : []) }}"
           class="btn btn-sm {{ request('status', '') === $val ? 'btn-primary' : 'btn-outline-secondary' }}">
            {{ $label }}
        </a>
        @endforeach
    </div>
</form>

<div class="card">
    <div class="card-body p-0">
        @if($matches->isEmpty())
            <div class="text-center py-5 text-muted">Tidak ada pertandingan.</div>
        @else
        <div class="table-responsive">
            <table class="table table-hover align-middle mb-0">
                <thead>
                    <tr>
                        <th class="ps-4">Tanggal</th>
                        <th>Home</th>
                        <th class="text-center">Skor</th>
                        <th>Away</th>
                        <th>Venue</th>
                        <th class="text-center">Status</th>
                        <th class="text-center">Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($matches as $match)
                    <tr>
                        <td class="ps-4 text-muted small">{{ $match->match_date->format('d M Y, H:i') }}</td>
                        <td class="fw-semibold">{{ $match->homeTeam->name }}</td>
                        <td class="text-center fw-bold">
                            @if($match->status === 'finished')
                                {{ $match->home_score }} – {{ $match->away_score }}
                            @else
                                <span class="text-muted">vs</span>
                            @endif
                        </td>
                        <td class="fw-semibold">{{ $match->awayTeam->name }}</td>
                        <td class="text-muted small">{{ $match->venue ?? '—' }}</td>
                        <td class="text-center">
                            @php
                                $badge = match($match->status) {
                                    'scheduled' => 'bg-secondary',
                                    'ongoing'   => 'bg-warning text-dark',
                                    'finished'  => 'bg-success',
                                    'cancelled' => 'bg-danger',
                                    default     => 'bg-secondary',
                                };
                            @endphp
                            <span class="badge {{ $badge }}">{{ ucfirst($match->status) }}</span>
                        </td>
                        <td class="text-center">
                            @if($match->status !== 'finished' && $match->status !== 'cancelled')
                                <a href="{{ route('wasit.matches.score.form', $match) }}"
                                   class="btn btn-sm btn-primary">
                                    <i class="bi bi-pencil-square me-1"></i>Input Skor
                                </a>
                            @else
                                <span class="text-muted small">—</span>
                            @endif
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
        @endif
    </div>
</div>
@endsection
