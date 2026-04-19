@php $withSidebar = true; @endphp
@extends('layouts.app')
@section('title', 'Tambah Jadwal Pertandingan')

@section('sidebar')
@include('components.sidebar-manajemen', ['active' => 'matches'])
@endsection

@section('content')
<div class="d-flex align-items-center gap-3 mb-4">
    <a href="{{ route('manajemen.matches.index') }}" class="btn btn-sm btn-outline-secondary">
        <i class="bi bi-arrow-left"></i>
    </a>
    <div>
        <h4 class="fw-bold mb-0">Tambah Jadwal Pertandingan</h4>
        <small class="text-muted">Atur pertandingan baru</small>
    </div>
</div>

<div class="card" style="max-width:600px;">
    <div class="card-body p-4">
        <form action="{{ route('manajemen.matches.store') }}" method="POST">
            @csrf

            <div class="mb-3">
                <label class="form-label fw-semibold">Tim Home <span class="text-danger">*</span></label>
                <select name="home_team_id" class="form-select @error('home_team_id') is-invalid @enderror" required>
                    <option value="">— Pilih Tim Home —</option>
                    @foreach($teams as $team)
                        <option value="{{ $team->id }}" {{ old('home_team_id') == $team->id ? 'selected' : '' }}>
                            {{ $team->name }}
                        </option>
                    @endforeach
                </select>
                @error('home_team_id') <div class="invalid-feedback">{{ $message }}</div> @enderror
            </div>

            <div class="mb-3">
                <label class="form-label fw-semibold">Tim Away <span class="text-danger">*</span></label>
                <select name="away_team_id" class="form-select @error('away_team_id') is-invalid @enderror" required>
                    <option value="">— Pilih Tim Away —</option>
                    @foreach($teams as $team)
                        <option value="{{ $team->id }}" {{ old('away_team_id') == $team->id ? 'selected' : '' }}>
                            {{ $team->name }}
                        </option>
                    @endforeach
                </select>
                @error('away_team_id') <div class="invalid-feedback">{{ $message }}</div> @enderror
            </div>

            <div class="mb-3">
                <label class="form-label fw-semibold">Tanggal & Waktu <span class="text-danger">*</span></label>
                <input type="datetime-local" name="match_date"
                       class="form-control @error('match_date') is-invalid @enderror"
                       value="{{ old('match_date') }}" required>
                @error('match_date') <div class="invalid-feedback">{{ $message }}</div> @enderror
            </div>

            <div class="mb-4">
                <label class="form-label fw-semibold">Venue</label>
                <input type="text" name="venue" class="form-control"
                       value="{{ old('venue') }}" placeholder="contoh: Jakarta Studio">
            </div>

            <div class="d-flex gap-2">
                <button type="submit" class="btn btn-primary px-4">
                    <i class="bi bi-check-lg me-1"></i> Simpan
                </button>
                <a href="{{ route('manajemen.matches.index') }}" class="btn btn-outline-secondary px-4">Batal</a>
            </div>
        </form>
    </div>
</div>
@endsection
