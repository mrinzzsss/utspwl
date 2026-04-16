@extends('layouts.app')
@section('title', 'Tambah Pemain')

@section('content')
<div class="max-w-2xl mx-auto px-4 py-12">
    <a href="{{ route('tournaments.show', $tournament) }}" class="text-xs text-slate-500 hover:text-purple-400 mb-4 inline-flex items-center gap-1">
        <i class="fa-solid fa-arrow-left text-[10px]"></i> Kembali ke {{ $tournament->nama }}
    </a>
    <div class="card-glass rounded-2xl p-8 mt-3">
        <h1 class="text-2xl font-black text-white mb-2">Tambah Pemain</h1>
        <p class="text-slate-400 text-sm mb-8">{{ $tournament->nama }}</p>

        <form method="POST" action="{{ route('tournaments.players.store', $tournament) }}" enctype="multipart/form-data">
            @csrf
            <div class="grid grid-cols-2 gap-4 mb-4">
                <div>
                    <label class="block text-xs font-bold text-slate-400 mb-2 uppercase tracking-wide">Nama Tim</label>
                    <input type="text" name="nama_tim" value="{{ old('nama_tim') }}" required
                           class="w-full bg-white/5 border border-white/10 rounded-xl px-4 py-3 text-white text-sm focus:outline-none focus:border-purple-500 transition"
                           placeholder="Contoh: RRQ Hoshi">
                    @error('nama_tim')<p class="text-red-400 text-xs mt-1">{{ $message }}</p>@enderror
                </div>
                <div>
                    <label class="block text-xs font-bold text-slate-400 mb-2 uppercase tracking-wide">Logo Tim</label>
                    <input type="file" name="logo_tim" accept="image/*"
                           class="w-full bg-white/5 border border-white/10 rounded-xl px-4 py-3 text-slate-400 text-sm focus:outline-none focus:border-purple-500 transition">
                </div>
            </div>
            <div class="grid grid-cols-2 gap-4 mb-4">
                <div>
                    <label class="block text-xs font-bold text-slate-400 mb-2 uppercase tracking-wide">IGN (In-Game Name)</label>
                    <input type="text" name="ign" value="{{ old('ign') }}" required
                           class="w-full bg-white/5 border border-white/10 rounded-xl px-4 py-3 text-white text-sm focus:outline-none focus:border-purple-500 transition"
                           placeholder="Username in-game">
                    @error('ign')<p class="text-red-400 text-xs mt-1">{{ $message }}</p>@enderror
                </div>
                <div>
                    <label class="block text-xs font-bold text-slate-400 mb-2 uppercase tracking-wide">Nama Asli</label>
                    <input type="text" name="nama_asli" value="{{ old('nama_asli') }}" required
                           class="w-full bg-white/5 border border-white/10 rounded-xl px-4 py-3 text-white text-sm focus:outline-none focus:border-purple-500 transition"
                           placeholder="Nama lengkap">
                    @error('nama_asli')<p class="text-red-400 text-xs mt-1">{{ $message }}</p>@enderror
                </div>
            </div>
            <div class="mb-6">
                <label class="block text-xs font-bold text-slate-400 mb-2 uppercase tracking-wide">Role</label>
                <select name="role_game" required class="w-full bg-white/5 border border-white/10 rounded-xl px-4 py-3 text-white text-sm focus:outline-none focus:border-purple-500 transition">
                    <option value="">-- Pilih Role --</option>
                    @foreach(['jungler','roamer','midlaner','goldlaner','explaner'] as $role)
                    <option value="{{ $role }}" {{ old('role_game') === $role ? 'selected' : '' }}>{{ ucfirst($role) }}</option>
                    @endforeach
                </select>
                @error('role_game')<p class="text-red-400 text-xs mt-1">{{ $message }}</p>@enderror
            </div>
            <button type="submit" class="w-full bg-purple-600 hover:bg-purple-700 text-white font-bold py-3 rounded-xl transition">
                <i class="fa-solid fa-user-plus mr-2"></i>Tambah Pemain
            </button>
        </form>
    </div>
</div>
@endsection
