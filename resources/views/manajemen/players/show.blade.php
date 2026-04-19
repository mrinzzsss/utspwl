@php $withSidebar = true; @endphp
@extends('layouts.app')
@section('title', 'Detail Pemain — ' . $player->name)

@section('sidebar')
@include('components.sidebar-manajemen', ['active' => 'players'])
@endsection

@section('content')
<div class="d-flex align-items-center gap-3 mb-4">
    <a href="{{ route('manajemen.players.index') }}" class="btn btn-sm btn-outline-secondary">
        <i class="bi bi-arrow-left"></i>
    </a>
    <div>
        <h4 class="fw-bold mb-0">{{ $player->name }}</h4>
        <small class="text-muted">{{ $player->team->name }}</small>
    </div>
    <a href="{{ route('manajemen.players.edit', $player) }}" class="btn btn-sm btn-outline-primary ms-auto">
        <i class="bi bi-pencil me-1"></i> Edit
    </a>
</div>

<div class="card" style="max-width:500px;">
    <div class="card-body">
        <table class="table table-borderless mb-0">
            <tr><td class="text-muted" style="width:140px;">Nama</td><td class="fw-semibold">{{ $player->name }}</td></tr>
            <tr><td class="text-muted">Game ID</td><td>{{ $player->game_id ?? '—' }}</td></tr>
            <tr><td class="text-muted">Tim</td><td>{{ $player->team->name }}</td></tr>
            <tr><td class="text-muted">Role</td>
                <td>
                    @if($player->role)
                        <span class="badge" style="background:#0f2b5b;">{{ $player->role }}</span>
                    @else —
                    @endif
                </td>
            </tr>
            <tr><td class="text-muted">Nationality</td><td>{{ $player->nationality ?? '—' }}</td></tr>
            <tr><td class="text-muted">Tgl Lahir</td>
                <td>{{ $player->birth_date ? $player->birth_date->format('d M Y') : '—' }}</td>
            </tr>
        </table>
    </div>
</div>
@endsection
