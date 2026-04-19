@php $withSidebar = true; @endphp
@extends('layouts.app')
@section('title', 'Edit Tim')

@section('sidebar')
@include('components.sidebar-manajemen', ['active' => 'teams'])
@endsection

@section('content')
<div class="d-flex align-items-center gap-3 mb-4">
    <a href="{{ route('manajemen.teams.index') }}" class="btn btn-sm btn-outline-secondary">
        <i class="bi bi-arrow-left"></i>
    </a>
    <div>
        <h4 class="fw-bold mb-0">Edit Tim</h4>
        <small class="text-muted">{{ $team->name }}</small>
    </div>
</div>

<div class="card" style="max-width:600px;">
    <div class="card-body p-4">
        <form action="{{ route('manajemen.teams.update', $team) }}" method="POST">
            @csrf @method('PUT')

            <div class="mb-3">
                <label class="form-label fw-semibold">Nama Tim <span class="text-danger">*</span></label>
                <input type="text" name="name" class="form-control @error('name') is-invalid @enderror"
                    value="{{ old('name', $team->name) }}" required>
                @error('name') <div class="invalid-feedback">{{ $message }}</div> @enderror
            </div>

            <div class="mb-3">
                <label class="form-label fw-semibold">Kota</label>
                <input type="text" name="city" class="form-control"
                    value="{{ old('city', $team->city) }}">
            </div>

            <div class="mb-3">
                <label class="form-label fw-semibold">Tahun Berdiri</label>
                <input type="number" name="founded_year" class="form-control"
                    value="{{ old('founded_year', $team->founded_year) }}"
                    min="1900" max="{{ date('Y') }}">
            </div>

            <div class="mb-4">
                <label class="form-label fw-semibold">Logo URL</label>
                <input type="text" name="logo" class="form-control"
                    value="{{ old('logo', $team->logo) }}">
            </div>

            <div class="d-flex gap-2">
                <button type="submit" class="btn btn-primary px-4">
                    <i class="bi bi-check-lg me-1"></i> Perbarui
                </button>
                <a href="{{ route('manajemen.teams.index') }}" class="btn btn-outline-secondary px-4">Batal</a>
            </div>
        </form>
    </div>
</div>
@endsection
