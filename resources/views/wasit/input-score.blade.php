@php $withSidebar = true; @endphp
@extends('layouts.app')
@section('title', 'Input Skor Pertandingan')

@section('sidebar')
<div class="px-2">
    <div class="text-white-50 small fw-semibold text-uppercase px-2 mb-2 mt-1">Menu</div>
    <nav class="nav flex-column">
        <a class="nav-link" href="{{ route('wasit.dashboard') }}">
            <i class="bi bi-speedometer2"></i> Dashboard
        </a>
        <a class="nav-link active" href="{{ route('wasit.matches.index') }}">
            <i class="bi bi-calendar3"></i> Pertandingan
        </a>
    </nav>
    <hr class="border-secondary my-3">
    <form action="{{ route('logout') }}" method="POST">
        @csrf
        <button class="btn btn-sm btn-outline-danger w-100">
            <i class="bi bi-box-arrow-right me-1"></i> Logout
        </button>
    </form>
</div>
@endsection

@section('content')
<div class="d-flex align-items-center gap-3 mb-4">
    <a href="{{ route('wasit.dashboard') }}" class="btn btn-sm btn-outline-secondary">
        <i class="bi bi-arrow-left"></i>
    </a>
    <div>
        <h4 class="fw-bold mb-0">Input Skor Pertandingan</h4>
        <small class="text-muted">{{ $match->match_date->format('d M Y, H:i') }} WIB · {{ $match->venue ?? '' }}</small>
    </div>
</div>

<div class="card" style="max-width:550px;">
    <div class="card-body p-4">

        {{-- Match Preview --}}
        <div class="rounded-3 p-4 mb-4 text-center" style="background:linear-gradient(135deg,#0a1a38,#1e3a8a); color:#fff;">
            <div class="row align-items-center">
                <div class="col-5 text-center">
                    <div class="rounded-circle d-inline-flex align-items-center justify-content-center text-white fw-bold mb-2"
                         style="width:60px;height:60px;background:rgba(255,255,255,.15);font-size:1.1rem;">
                        {{ strtoupper(substr($match->homeTeam->name, 0, 2)) }}
                    </div>
                    <div class="fw-bold">{{ $match->homeTeam->name }}</div>
                    <small class="opacity-75">Home</small>
                </div>
                <div class="col-2 text-center">
                    <span class="fw-bold fs-4 opacity-75">VS</span>
                </div>
                <div class="col-5 text-center">
                    <div class="rounded-circle d-inline-flex align-items-center justify-content-center text-white fw-bold mb-2"
                         style="width:60px;height:60px;background:rgba(255,255,255,.15);font-size:1.1rem;">
                        {{ strtoupper(substr($match->awayTeam->name, 0, 2)) }}
                    </div>
                    <div class="fw-bold">{{ $match->awayTeam->name }}</div>
                    <small class="opacity-75">Away</small>
                </div>
            </div>
        </div>

        {{-- Score form --}}
        <form action="{{ route('wasit.matches.score', $match) }}" method="POST">
            @csrf

            <div class="row g-4 mb-4">
                <div class="col-5">
                    <label class="form-label fw-semibold text-center d-block">
                        Skor {{ $match->homeTeam->name }}
                    </label>
                    <input type="number" name="home_score" id="homeScore"
                           class="form-control form-control-lg text-center fw-bold @error('home_score') is-invalid @enderror"
                           value="{{ old('home_score', 0) }}" min="0" max="99" required
                           oninput="updatePreview()">
                    @error('home_score') <div class="invalid-feedback">{{ $message }}</div> @enderror
                </div>
                <div class="col-2 d-flex align-items-end justify-content-center pb-2">
                    <span class="fw-bold fs-4 text-muted">–</span>
                </div>
                <div class="col-5">
                    <label class="form-label fw-semibold text-center d-block">
                        Skor {{ $match->awayTeam->name }}
                    </label>
                    <input type="number" name="away_score" id="awayScore"
                           class="form-control form-control-lg text-center fw-bold @error('away_score') is-invalid @enderror"
                           value="{{ old('away_score', 0) }}" min="0" max="99" required
                           oninput="updatePreview()">
                    @error('away_score') <div class="invalid-feedback">{{ $message }}</div> @enderror
                </div>
            </div>

            {{-- Hasil preview --}}
            <div id="resultPreview" class="alert py-2 text-center mb-4"></div>

            <div class="d-flex gap-2">
                <button type="submit" class="btn btn-success px-4 fw-semibold flex-fill"
                        onclick="return confirm('Konfirmasi input skor? Data tidak bisa diubah setelah disimpan.')">
                    <i class="bi bi-check-circle-fill me-1"></i> Konfirmasi Skor
                </button>
                <a href="{{ route('wasit.dashboard') }}" class="btn btn-outline-secondary px-4">Batal</a>
            </div>
        </form>
    </div>
</div>
@endsection

@push('scripts')
<script>
const homeName = '{{ $match->homeTeam->name }}';
const awayName = '{{ $match->awayTeam->name }}';

function updatePreview() {
    const h   = parseInt(document.getElementById('homeScore').value) || 0;
    const a   = parseInt(document.getElementById('awayScore').value) || 0;
    const box = document.getElementById('resultPreview');

    if (h > a) {
        box.className = 'alert alert-success py-2 text-center mb-4';
        box.innerHTML = `🏆 <strong>${homeName}</strong> menang (${h} – ${a})`;
    } else if (a > h) {
        box.className = 'alert alert-success py-2 text-center mb-4';
        box.innerHTML = `🏆 <strong>${awayName}</strong> menang (${h} – ${a})`;
    } else {
        box.className = 'alert alert-warning py-2 text-center mb-4';
        box.innerHTML = `⚖️ Seri (${h} – ${a})`;
    }
}
updatePreview();
</script>
@endpush
