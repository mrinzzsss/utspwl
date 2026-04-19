@php $withSidebar = true; @endphp
@extends('layouts.app')
@section('title', 'Tambah Pengguna')

@section('sidebar')
@include('components.sidebar-manajemen', ['active' => 'users'])
@endsection

@section('content')
<div class="d-flex align-items-center gap-3 mb-4">
    <a href="{{ route('manajemen.users.index') }}" class="btn btn-sm btn-outline-secondary">
        <i class="bi bi-arrow-left"></i>
    </a>
    <div>
        <h4 class="fw-bold mb-0">Tambah Pengguna Baru</h4>
        <small class="text-muted">Buat akun manajemen, wasit, atau player</small>
    </div>
</div>

<div class="card" style="max-width:580px;">
    <div class="card-body p-4">
        <form action="{{ route('manajemen.users.store') }}" method="POST">
            @csrf

            <div class="mb-3">
                <label class="form-label fw-semibold">Nama Lengkap <span class="text-danger">*</span></label>
                <input type="text" name="name" class="form-control @error('name') is-invalid @enderror"
                       value="{{ old('name') }}" required>
                @error('name') <div class="invalid-feedback">{{ $message }}</div> @enderror
            </div>

            <div class="mb-3">
                <label class="form-label fw-semibold">Email <span class="text-danger">*</span></label>
                <input type="email" name="email" class="form-control @error('email') is-invalid @enderror"
                       value="{{ old('email') }}" required>
                @error('email') <div class="invalid-feedback">{{ $message }}</div> @enderror
            </div>

            <div class="row g-3 mb-3">
                <div class="col-md-6">
                    <label class="form-label fw-semibold">Password <span class="text-danger">*</span></label>
                    <input type="password" name="password"
                           class="form-control @error('password') is-invalid @enderror"
                           placeholder="Min. 8 karakter" required>
                    @error('password') <div class="invalid-feedback">{{ $message }}</div> @enderror
                </div>
                <div class="col-md-6">
                    <label class="form-label fw-semibold">Konfirmasi Password <span class="text-danger">*</span></label>
                    <input type="password" name="password_confirmation" class="form-control"
                           placeholder="Ulangi password" required>
                </div>
            </div>

            <div class="mb-3">
                <label class="form-label fw-semibold">Role <span class="text-danger">*</span></label>
                <select name="role" id="roleSelect" class="form-select @error('role') is-invalid @enderror"
                        required onchange="togglePlayerField()">
                    <option value="">— Pilih Role —</option>
                    <option value="manajemen" {{ old('role') === 'manajemen' ? 'selected' : '' }}>Manajemen</option>
                    <option value="wasit"     {{ old('role') === 'wasit'     ? 'selected' : '' }}>Wasit</option>
                    <option value="player"    {{ old('role') === 'player'    ? 'selected' : '' }}>Player</option>
                </select>
                @error('role') <div class="invalid-feedback">{{ $message }}</div> @enderror
            </div>

            <div class="mb-4" id="playerField" style="display:none;">
                <label class="form-label fw-semibold">Tautkan ke Pemain</label>
                <select name="player_id" class="form-select">
                    <option value="">— Tidak dikaitkan —</option>
                    @foreach($players as $player)
                        <option value="{{ $player->id }}" {{ old('player_id') == $player->id ? 'selected' : '' }}>
                            {{ $player->name }} — {{ $player->team->name }}
                        </option>
                    @endforeach
                </select>
                <div class="form-text">Hanya muncul jika role = Player</div>
            </div>

            <div class="d-flex gap-2">
                <button type="submit" class="btn btn-primary px-4">
                    <i class="bi bi-check-lg me-1"></i> Simpan
                </button>
                <a href="{{ route('manajemen.users.index') }}" class="btn btn-outline-secondary px-4">Batal</a>
            </div>
        </form>
    </div>
</div>
@endsection

@push('scripts')
<script>
function togglePlayerField() {
    const role  = document.getElementById('roleSelect').value;
    const field = document.getElementById('playerField');
    field.style.display = role === 'player' ? 'block' : 'none';
}
// jalankan saat load jika old('role') = player
togglePlayerField();
</script>
@endpush
