@php $withSidebar = true; @endphp
@extends('layouts.app')
@section('title', isset($player) ? 'Edit Pemain' : 'Tambah Pemain')

@section('sidebar')
@include('components.sidebar-manajemen', ['active' => 'players'])
@endsection

@section('content')
@php
    $isEdit  = isset($player);
    $action  = $isEdit ? route('manajemen.players.update', $player) : route('manajemen.players.store');
    $title   = $isEdit ? 'Edit Pemain' : 'Tambah Pemain Baru';
    $subtitle= $isEdit ? $player->name : 'Isi data pemain baru';
@endphp

<div class="d-flex align-items-center gap-3 mb-4">
    <a href="{{ route('manajemen.players.index') }}" class="btn btn-sm btn-outline-secondary">
        <i class="bi bi-arrow-left"></i>
    </a>
    <div>
        <h4 class="fw-bold mb-0">{{ $title }}</h4>
        <small class="text-muted">{{ $subtitle }}</small>
    </div>
</div>

<div class="card" style="max-width:620px;">
    <div class="card-body p-4">
        <form action="{{ $action }}" method="POST">
            @csrf
            @if($isEdit) @method('PUT') @endif

            <div class="row g-3">
                <div class="col-md-6">
                    <label class="form-label fw-semibold">Nama <span class="text-danger">*</span></label>
                    <input type="text" name="name" class="form-control @error('name') is-invalid @enderror"
                        value="{{ old('name', $isEdit ? $player->name : '') }}" required>
                    @error('name') <div class="invalid-feedback">{{ $message }}</div> @enderror
                </div>

                <div class="col-md-6">
                    <label class="form-label fw-semibold">Tim <span class="text-danger">*</span></label>
                    <select name="team_id" class="form-select @error('team_id') is-invalid @enderror" required>
                        <option value="">— Pilih Tim —</option>
                        @foreach($teams as $team)
                            <option value="{{ $team->id }}"
                                {{ old('team_id', $isEdit ? $player->team_id : '') == $team->id ? 'selected' : '' }}>
                                {{ $team->name }}
                            </option>
                        @endforeach
                    </select>
                    @error('team_id') <div class="invalid-feedback">{{ $message }}</div> @enderror
                </div>

                <div class="col-md-6">
                    <label class="form-label fw-semibold">Game ID</label>
                    <input type="text" name="game_id" class="form-control"
                        value="{{ old('game_id', $isEdit ? $player->game_id : '') }}"
                        placeholder="Username in-game">
                </div>

                <div class="col-md-6">
                    <label class="form-label fw-semibold">Role</label>
                    <select name="role" class="form-select">
                        <option value="">— Pilih Role —</option>
                        @foreach(['EXP','MID','GOLD','ROAM','JUNGLE'] as $r)
                            <option value="{{ $r }}"
                                {{ old('role', $isEdit ? $player->role : '') === $r ? 'selected' : '' }}>
                                {{ $r }}
                            </option>
                        @endforeach
                    </select>
                </div>

                <div class="col-md-6">
                    <label class="form-label fw-semibold">Nationality</label>
                    <input type="text" name="nationality" class="form-control"
                        value="{{ old('nationality', $isEdit ? $player->nationality : '') }}"
                        maxlength="2" placeholder="ID / PH / MY">
                    <div class="form-text">Kode negara 2 huruf (ISO 3166)</div>
                </div>

                <div class="col-md-6">
                    <label class="form-label fw-semibold">Tanggal Lahir</label>
                    <input type="date" name="birth_date" class="form-control"
                        value="{{ old('birth_date', $isEdit && $player->birth_date ? $player->birth_date->format('Y-m-d') : '') }}">
                </div>
            </div>

            <div class="d-flex gap-2 mt-4">
                <button type="submit" class="btn btn-primary px-4">
                    <i class="bi bi-check-lg me-1"></i> {{ $isEdit ? 'Perbarui' : 'Simpan' }}
                </button>
                <a href="{{ route('manajemen.players.index') }}" class="btn btn-outline-secondary px-4">Batal</a>
            </div>
        </form>
    </div>
</div>
@endsection
