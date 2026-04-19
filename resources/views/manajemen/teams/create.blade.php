@php $withSidebar = true; @endphp
@extends('layouts.app')
@section('title', 'Tambah Tim')

@section('sidebar')
@include('components.sidebar-manajemen', ['active' => 'teams'])
@endsection

@section('content')
<div class="d-flex align-items-center gap-3 mb-4">
    <a href="{{ route('manajemen.teams.index') }}" class="btn btn-sm btn-outline-secondary">
        <i class="bi bi-arrow-left"></i>
    </a>
    <div>
        <h4 class="fw-bold mb-0">Tambah Tim Baru</h4>
        <small class="text-muted">Isi data tim peserta MPL</small>
    </div>
</div>

<div class="card" style="max-width:600px;">
    <div class="card-body p-4">
        <form action="{{ route('manajemen.teams.store') }}" method="POST">
            @csrf

            <div class="mb-3">
                <label class="form-label fw-semibold">Nama Tim <span class="text-danger">*</span></label>
                <input type="text" name="name" class="form-control @error('name') is-invalid @enderror"
                    value="{{ old('name') }}" placeholder="contoh: RRQ Hoshi" required>
                @error('name') <div class="invalid-feedback">{{ $message }}</div> @enderror
            </div>

            <div class="mb-3">
                <label class="form-label fw-semibold">Kota</label>
                <input type="text" name="city" class="form-control @error('city') is-invalid @enderror"
                    value="{{ old('city') }}" placeholder="contoh: Jakarta">
                @error('city') <div class="invalid-feedback">{{ $message }}</div> @enderror
            </div>

            <div class="mb-3">
                <label class="form-label fw-semibold">Tahun Berdiri</label>
                <input type="number" name="founded_year" class="form-control @error('founded_year') is-invalid @enderror"
                    value="{{ old('founded_year') }}" placeholder="contoh: 2018" min="1900" max="{{ date('Y') }}">
                @error('founded_year') <div class="invalid-feedback">{{ $message }}</div> @enderror
            </div>

            <div class="mb-4">
                <label class="form-label fw-semibold">Logo URL <span class="text-muted small">(opsional)</span></label>
                <input type="text" name="logo" class="form-control @error('logo') is-invalid @enderror"
                    value="{{ old('logo') }}" placeholder="https://...">
                @error('logo') <div class="invalid-feedback">{{ $message }}</div> @enderror
            </div>

            <div class="d-flex gap-2">
                <button type="submit" class="btn btn-primary px-4">
                    <i class="bi bi-check-lg me-1"></i> Simpan
                </button>
                <a href="{{ route('manajemen.teams.index') }}" class="btn btn-outline-secondary px-4">Batal</a>
            </div>
        </form>
    </div>
</div>
@endsection
