@php $withSidebar = true; @endphp
@extends('layouts.app')
@section('title', isset($standing) ? 'Edit Klasemen' : 'Tambah Klasemen')

@section('sidebar')
@include('components.sidebar-manajemen', ['active' => 'standings'])
@endsection

@section('content')
@php
    $isEdit  = isset($standing);
    $action  = $isEdit ? route('manajemen.standings.update', $standing) : route('manajemen.standings.store');
    $title   = $isEdit ? 'Edit Data Klasemen' : 'Tambah / Update Klasemen';
@endphp

<div class="d-flex align-items-center gap-3 mb-4">
    <a href="{{ route('manajemen.standings.index') }}" class="btn btn-sm btn-outline-secondary">
        <i class="bi bi-arrow-left"></i>
    </a>
    <div>
        <h4 class="fw-bold mb-0">{{ $title }}</h4>
        <small class="text-muted">Jika tim+season sudah ada, data akan diperbarui otomatis</small>
    </div>
</div>

<div class="card" style="max-width:560px;">
    <div class="card-body p-4">
        <form action="{{ $action }}" method="POST">
            @csrf
            @if($isEdit) @method('PUT') @endif

            @if(!$isEdit)
            <div class="row g-3 mb-3">
                <div class="col-md-8">
                    <label class="form-label fw-semibold">Tim <span class="text-danger">*</span></label>
                    <select name="team_id" class="form-select @error('team_id') is-invalid @enderror" required>
                        <option value="">— Pilih Tim —</option>
                        @foreach($teams as $team)
                            <option value="{{ $team->id }}" {{ old('team_id') == $team->id ? 'selected' : '' }}>
                                {{ $team->name }}
                            </option>
                        @endforeach
                    </select>
                    @error('team_id') <div class="invalid-feedback">{{ $message }}</div> @enderror
                </div>
                <div class="col-md-4">
                    <label class="form-label fw-semibold">Season <span class="text-danger">*</span></label>
                    <input type="number" name="season" class="form-control" required
                           value="{{ old('season', date('Y')) }}" min="2000" max="{{ date('Y') + 1 }}">
                </div>
            </div>
            @else
            <div class="alert alert-secondary py-2 mb-3">
                <strong>{{ $standing->team->name }}</strong> — Season {{ $standing->season }}
            </div>
            @endif

            <div class="row g-3">
                <div class="col-6 col-md-3">
                    <label class="form-label fw-semibold">Main</label>
                    <input type="number" name="played" class="form-control text-center"
                           value="{{ old('played', $isEdit ? $standing->played : 0) }}" min="0" required>
                </div>
                <div class="col-6 col-md-3">
                    <label class="form-label fw-semibold text-success">Menang</label>
                    <input type="number" name="wins" class="form-control text-center"
                           value="{{ old('wins', $isEdit ? $standing->wins : 0) }}" min="0" required>
                </div>
                <div class="col-6 col-md-3">
                    <label class="form-label fw-semibold text-danger">Kalah</label>
                    <input type="number" name="losses" class="form-control text-center"
                           value="{{ old('losses', $isEdit ? $standing->losses : 0) }}" min="0" required>
                </div>
                <div class="col-6 col-md-3">
                    <label class="form-label fw-semibold" style="color:#0f2b5b;">Poin</label>
                    <input type="number" name="points" class="form-control text-center"
                           value="{{ old('points', $isEdit ? $standing->points : 0) }}" min="0" required>
                </div>
            </div>

            <div class="d-flex gap-2 mt-4">
                <button type="submit" class="btn btn-primary px-4">
                    <i class="bi bi-check-lg me-1"></i> {{ $isEdit ? 'Perbarui' : 'Simpan' }}
                </button>
                <a href="{{ route('manajemen.standings.index') }}" class="btn btn-outline-secondary px-4">Batal</a>
            </div>
        </form>
    </div>
</div>
@endsection
