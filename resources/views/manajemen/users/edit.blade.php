@php $withSidebar = true; @endphp
@extends('layouts.app')
@section('title', 'Edit Pengguna')

@section('sidebar')
@include('components.sidebar-manajemen', ['active' => 'users'])
@endsection

@section('content')
<div class="d-flex align-items-center gap-3 mb-4">
    <a href="{{ route('manajemen.users.index') }}" class="btn btn-sm btn-outline-secondary">
        <i class="bi bi-arrow-left"></i>
    </a>
    <div>
        <h4 class="fw-bold mb-0">Edit Pengguna</h4>
        <small class="text-muted">{{ $user->name }}</small>
    </div>
</div>

<div class="card" style="max-width:580px;">
    <div class="card-body p-4">
        <form action="{{ route('manajemen.users.update', $user) }}" method="POST">
            @csrf @method('PUT')

            <div class="mb-3">
                <label class="form-label fw-semibold">Nama Lengkap</label>
                <input type="text" name="name" class="form-control @error('name') is-invalid @enderror"
                       value="{{ old('name', $user->name) }}" required>
                @error('name') <div class="invalid-feedback">{{ $message }}</div> @enderror
            </div>

            <div class="mb-3">
                <label class="form-label fw-semibold">Email</label>
                <input type="email" name="email" class="form-control @error('email') is-invalid @enderror"
                       value="{{ old('email', $user->email) }}" required>
                @error('email') <div class="invalid-feedback">{{ $message }}</div> @enderror
            </div>

            <div class="row g-3 mb-3">
                <div class="col-md-6">
                    <label class="form-label fw-semibold">Password Baru</label>
                    <input type="password" name="password"
                           class="form-control @error('password') is-invalid @enderror"
                           placeholder="Kosongkan jika tidak diubah">
                    @error('password') <div class="invalid-feedback">{{ $message }}</div> @enderror
                </div>
                <div class="col-md-6">
                    <label class="form-label fw-semibold">Konfirmasi Password</label>
                    <input type="password" name="password_confirmation" class="form-control"
                           placeholder="Ulangi password baru">
                </div>
            </div>

            <div class="mb-3">
                <label class="form-label fw-semibold">Role</label>
                <select name="role" id="roleSelect" class="form-select" onchange="togglePlayerField()">
                    <option value="manajemen" {{ old('role', $user->role) === 'manajemen' ? 'selected' : '' }}>Manajemen</option>
                    <option value="wasit"     {{ old('role', $user->role) === 'wasit'     ? 'selected' : '' }}>Wasit</option>
                    <option value="player"    {{ old('role', $user->role) === 'player'    ? 'selected' : '' }}>Player</option>
                </select>
            </div>

            <div class="mb-4" id="playerField">
                <label class="form-label fw-semibold">Tautkan ke Pemain</label>
                <select name="player_id" class="form-select">
                    <option value="">— Tidak dikaitkan —</option>
                    @foreach($players as $player)
                        <option value="{{ $player->id }}"
                            {{ old('player_id', $user->player_id) == $player->id ? 'selected' : '' }}>
                            {{ $player->name }} — {{ $player->team->name }}
                        </option>
                    @endforeach
                </select>
            </div>

            <div class="d-flex gap-2">
                <button type="submit" class="btn btn-primary px-4">
                    <i class="bi bi-check-lg me-1"></i> Perbarui
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
togglePlayerField();
</script>
@endpush
