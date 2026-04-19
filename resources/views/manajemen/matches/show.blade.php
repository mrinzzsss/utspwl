@php $withSidebar = true; @endphp
@extends('layouts.app')
@section('title', 'Detail Pertandingan')

@section('sidebar')
@include('components.sidebar-manajemen', ['active' => 'matches'])
@endsection

@section('content')
<div class="d-flex align-items-center gap-3 mb-4">
    <a href="{{ route('manajemen.matches.index') }}" class="btn btn-sm btn-outline-secondary">
        <i class="bi bi-arrow-left"></i>
    </a>
    <div>
        <h4 class="fw-bold mb-0">Detail Pertandingan</h4>
        <small class="text-muted">{{ $match->match_date->format('d M Y, H:i') }} WIB</small>
    </div>
    <a href="{{ route('manajemen.matches.edit', $match) }}" class="btn btn-sm btn-outline-primary ms-auto">
        <i class="bi bi-pencil me-1"></i> Edit
    </a>
</div>

<div class="card" style="max-width:600px;">
    <div class="card-body p-0">
        <div class="rounded-3 p-4 text-center" style="background:linear-gradient(135deg,#0a1a38,#1e3a8a); color:#fff; border-radius:12px 12px 0 0 !important;">
            <div class="row align-items-center">
                <div class="col-5 text-center">
                    <div class="fw-bold fs-5">{{ $match->homeTeam->name }}</div>
                    <small class="opacity-75">Home</small>
                </div>
                <div class="col-2 text-center">
                    @if($match->status === 'finished')
                        <div class="fw-bold fs-2">{{ $match->home_score }} – {{ $match->away_score }}</div>
                    @else
                        <div class="fw-bold fs-3 opacity-75">VS</div>
                    @endif
                </div>
                <div class="col-5 text-center">
                    <div class="fw-bold fs-5">{{ $match->awayTeam->name }}</div>
                    <small class="opacity-75">Away</small>
                </div>
            </div>
        </div>
        <div class="p-4">
            <table class="table table-borderless mb-0">
                <tr><td class="text-muted" style="width:140px;">Status</td>
                    <td>
                        @php
                        $badge = match($match->status) {
                            'scheduled' => 'bg-secondary', 'ongoing' => 'bg-warning text-dark',
                            'finished'  => 'bg-success',   'cancelled' => 'bg-danger', default => 'bg-secondary',
                        };
                        @endphp
                        <span class="badge {{ $badge }}">{{ ucfirst($match->status) }}</span>
                    </td>
                </tr>
                <tr><td class="text-muted">Tanggal</td><td>{{ $match->match_date->format('d M Y, H:i') }} WIB</td></tr>
                <tr><td class="text-muted">Venue</td><td>{{ $match->venue ?? '—' }}</td></tr>
            </table>
        </div>
    </div>
</div>
@endsection
