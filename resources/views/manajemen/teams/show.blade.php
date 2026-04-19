@php $withSidebar = true; @endphp
@extends('layouts.app')
@section('title', 'Detail Tim — ' . $team->name)

@section('sidebar')
@include('components.sidebar-manajemen', ['active' => 'teams'])
@endsection

@section('content')
<div class="d-flex align-items-center gap-3 mb-4">
    <a href="{{ route('manajemen.teams.index') }}" class="btn btn-sm btn-outline-secondary">
        <i class="bi bi-arrow-left"></i>
    </a>
    <div>
        <h4 class="fw-bold mb-0">{{ $team->name }}</h4>
        <small class="text-muted">{{ $team->city ?? '' }} {{ $team->founded_year ? '· Est. ' . $team->founded_year : '' }}</small>
    </div>
    <a href="{{ route('manajemen.teams.edit', $team) }}" class="btn btn-sm btn-outline-primary ms-auto">
        <i class="bi bi-pencil me-1"></i> Edit
    </a>
</div>

<div class="row g-4">
    {{-- Info Tim --}}
    <div class="col-md-4">
        <div class="card text-center p-4">
            <div class="mx-auto rounded-circle d-flex align-items-center justify-content-center text-white fw-bold mb-3"
                 style="width:80px;height:80px;background:#0f2b5b;font-size:1.8rem;">
                {{ strtoupper(substr($team->name, 0, 2)) }}
            </div>
            <h5 class="fw-bold">{{ $team->name }}</h5>
            <p class="text-muted small mb-3">{{ $team->city ?? 'Kota tidak diketahui' }}</p>
            @if($team->standing)
            <div class="row text-center g-2">
                <div class="col-4">
                    <div class="fw-bold fs-5 text-primary">{{ $team->standing->wins }}</div>
                    <div class="small text-muted">Win</div>
                </div>
                <div class="col-4">
                    <div class="fw-bold fs-5 text-danger">{{ $team->standing->losses }}</div>
                    <div class="small text-muted">Loss</div>
                </div>
                <div class="col-4">
                    <div class="fw-bold fs-5 text-warning">{{ $team->standing->points }}</div>
                    <div class="small text-muted">Pts</div>
                </div>
            </div>
            @endif
        </div>
    </div>

    {{-- Roster Pemain --}}
    <div class="col-md-8">
        <div class="card">
            <div class="card-header py-3 d-flex justify-content-between align-items-center"
                 style="background:#0f2b5b; color:#fff;">
                <span class="fw-semibold"><i class="bi bi-people-fill me-2"></i>Roster Pemain</span>
                <a href="{{ route('manajemen.players.create') }}" class="btn btn-sm btn-warning">
                    <i class="bi bi-plus-lg"></i> Tambah
                </a>
            </div>
            <div class="card-body p-0">
                @if($team->players->isEmpty())
                    <div class="text-center py-4 text-muted">Belum ada pemain terdaftar</div>
                @else
                <div class="table-responsive">
                    <table class="table table-hover mb-0 align-middle">
                        <thead>
                            <tr>
                                <th class="ps-3">Nama</th>
                                <th>Game ID</th>
                                <th>Role</th>
                                <th>Nationality</th>
                                <th></th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($team->players as $player)
                            <tr>
                                <td class="ps-3 fw-semibold">{{ $player->name }}</td>
                                <td class="text-muted">{{ $player->game_id ?? '—' }}</td>
                                <td>
                                    @if($player->role)
                                    <span class="badge rounded-pill" style="background:#0f2b5b;">{{ $player->role }}</span>
                                    @else —
                                    @endif
                                </td>
                                <td>{{ $player->nationality ?? '—' }}</td>
                                <td>
                                    <a href="{{ route('manajemen.players.edit', $player) }}"
                                       class="btn btn-sm btn-outline-primary">
                                        <i class="bi bi-pencil"></i>
                                    </a>
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
</div>
@endsection
