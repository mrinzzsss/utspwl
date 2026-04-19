@php $withSidebar = true; @endphp
@extends('layouts.app')
@section('title', 'Manajemen Pemain')

@section('sidebar')
@include('components.sidebar-manajemen', ['active' => 'players'])
@endsection

@section('content')
<div class="d-flex justify-content-between align-items-center mb-4">
    <div>
        <h4 class="fw-bold mb-0">Manajemen Pemain</h4>
        <small class="text-muted">Kelola roster pemain seluruh tim</small>
    </div>
    <a href="{{ route('manajemen.players.create') }}" class="btn btn-primary">
        <i class="bi bi-plus-lg me-1"></i> Tambah Pemain
    </a>
</div>

{{-- Filter by tim --}}
<form method="GET" class="mb-3">
    <div class="row g-2 align-items-center" style="max-width:400px;">
        <div class="col">
            <select name="team_id" class="form-select form-select-sm">
                <option value="">— Semua Tim —</option>
                @foreach($teams as $team)
                    <option value="{{ $team->id }}" {{ request('team_id') == $team->id ? 'selected' : '' }}>
                        {{ $team->name }}
                    </option>
                @endforeach
            </select>
        </div>
        <div class="col-auto">
            <button type="submit" class="btn btn-sm btn-outline-primary">Filter</button>
            <a href="{{ route('manajemen.players.index') }}" class="btn btn-sm btn-outline-secondary">Reset</a>
        </div>
    </div>
</form>

<div class="card">
    <div class="card-body p-0">
        @if($players->isEmpty())
            <div class="text-center py-5 text-muted">
                <i class="bi bi-person-x fs-1 d-block mb-2"></i>
                Belum ada data pemain.
            </div>
        @else
        <div class="table-responsive">
            <table class="table table-hover align-middle mb-0">
                <thead>
                    <tr>
                        <th class="ps-4">#</th>
                        <th>Nama</th>
                        <th>Tim</th>
                        <th>Role</th>
                        <th>Game ID</th>
                        <th>Nationality</th>
                        <th class="text-center">Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($players as $i => $player)
                    <tr>
                        <td class="ps-4 text-muted">{{ $i + 1 }}</td>
                        <td class="fw-semibold">{{ $player->name }}</td>
                        <td>
                            <span class="badge rounded-pill text-white" style="background:#0f2b5b;">
                                {{ $player->team->name }}
                            </span>
                        </td>
                        <td>
                            @php
                                $roleColor = match($player->role) {
                                    'EXP'    => '#7c3aed',
                                    'MID'    => '#0891b2',
                                    'GOLD'   => '#d97706',
                                    'ROAM'   => '#059669',
                                    'JUNGLE' => '#dc2626',
                                    default  => '#64748b',
                                };
                            @endphp
                            @if($player->role)
                            <span class="badge" style="background:{{ $roleColor }};">{{ $player->role }}</span>
                            @else
                            <span class="text-muted">—</span>
                            @endif
                        </td>
                        <td class="text-muted">{{ $player->game_id ?? '—' }}</td>
                        <td>{{ $player->nationality ?? '—' }}</td>
                        <td class="text-center">
                            <div class="d-flex gap-1 justify-content-center">
                                <a href="{{ route('manajemen.players.edit', $player) }}"
                                   class="btn btn-sm btn-outline-primary" title="Edit">
                                    <i class="bi bi-pencil"></i>
                                </a>
                                <form action="{{ route('manajemen.players.destroy', $player) }}" method="POST"
                                      onsubmit="return confirm('Hapus pemain {{ $player->name }}?')">
                                    @csrf @method('DELETE')
                                    <button class="btn btn-sm btn-outline-danger" title="Hapus">
                                        <i class="bi bi-trash"></i>
                                    </button>
                                </form>
                            </div>
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
