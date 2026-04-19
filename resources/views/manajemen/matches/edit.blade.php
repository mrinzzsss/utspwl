@php $withSidebar = true; @endphp
@extends('layouts.app')
@section('title', 'Edit Pertandingan')

@section('sidebar')
@include('components.sidebar-manajemen', ['active' => 'matches'])
@endsection

@section('content')
<div class="d-flex align-items-center gap-3 mb-4">
    <a href="{{ route('manajemen.matches.index') }}" class="btn btn-sm btn-outline-secondary">
        <i class="bi bi-arrow-left"></i>
    </a>
    <div>
        <h4 class="fw-bold mb-0">Edit Pertandingan</h4>
        <small class="text-muted">{{ $match->homeTeam->name }} vs {{ $match->awayTeam->name }}</small>
    </div>
</div>

<div class="card" style="max-width:600px;">
    <div class="card-body p-4">
        <form action="{{ route('manajemen.matches.update', $match) }}" method="POST">
            @csrf @method('PUT')

            <div class="mb-3">
                <label class="form-label fw-semibold">Tim Home</label>
                <input type="text" class="form-control bg-light" value="{{ $match->homeTeam->name }}" disabled>
                <div class="form-text">Tim tidak bisa diubah. Hapus dan buat ulang jika perlu.</div>
            </div>

            <div class="mb-3">
                <label class="form-label fw-semibold">Tim Away</label>
                <input type="text" class="form-control bg-light" value="{{ $match->awayTeam->name }}" disabled>
            </div>

            <div class="mb-3">
                <label class="form-label fw-semibold">Tanggal & Waktu</label>
                <input type="datetime-local" name="match_date" class="form-control"
                       value="{{ old('match_date', $match->match_date->format('Y-m-d\TH:i')) }}">
            </div>

            <div class="mb-3">
                <label class="form-label fw-semibold">Venue</label>
                <input type="text" name="venue" class="form-control"
                       value="{{ old('venue', $match->venue) }}">
            </div>

            <div class="mb-4">
                <label class="form-label fw-semibold">Status</label>
                <select name="status" class="form-select">
                    @foreach(['scheduled','ongoing','finished','cancelled'] as $s)
                        <option value="{{ $s }}" {{ old('status', $match->status) === $s ? 'selected' : '' }}>
                            {{ ucfirst($s) }}
                        </option>
                    @endforeach
                </select>
                <div class="form-text">Untuk input skor, gunakan fitur Input Skor oleh Wasit.</div>
            </div>

            <div class="d-flex gap-2">
                <button type="submit" class="btn btn-primary px-4">
                    <i class="bi bi-check-lg me-1"></i> Perbarui
                </button>
                <a href="{{ route('manajemen.matches.index') }}" class="btn btn-outline-secondary px-4">Batal</a>
            </div>
        </form>
    </div>
</div>
@endsection
