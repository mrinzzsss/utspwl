@extends('layouts.app')
@section('title', 'Edit Pemain')

@section('content')
<div class="max-w-2xl mx-auto px-4 py-12">
    <a href="{{ route('tournaments.show', $player->tournament_id) }}" class="text-xs text-slate-500 hover:text-purple-400 mb-4 inline-flex items-center gap-1">
        <i class="fa-solid fa-arrow-left text-[10px]"></i> Kembali
    </a>
    <div class="card-glass rounded-2xl p-8 mt-3">
        <h1 class="text-2xl font-black text-white mb-2">Edit Pemain</h1>
        <p class="text-slate-400 text-sm mb-8">{{ $player->ign }}</p>

        <form method="POST" action="{{ route('players.update', $player) }}" enctype="multipart/form-data">
            @csrf @method('PUT')
            <div class="grid grid-cols-2 gap-4 mb-4">
                <div>
                    <label class="block text-xs font-bold text-slate-400 mb-2 uppercase tracking-wide">Nama Tim</label>
                    <input type="text" name="nama_tim" value="{{ old('nama_tim', $player->nama_tim) }}" required
                           class="w-full bg-white/5 border border-white/10 rounded-xl px-4 py-3 text-white text-sm focus:outline-none focus:border-purple-500 transition">
                    @error('nama_tim')<p class="text-red-400 text-xs mt-1">{{ $message }}</p>@enderror
                </div>
                <div>
                    <label class="block text-xs font-bold text-slate-400 mb-2 uppercase tracking-wide">Logo Tim Baru</label>
                    <input type="file" name="logo_tim" accept="image/*"
                           class="w-full bg-white/5 border border-white/10 rounded-xl px-4 py-3 text-slate-400 text-sm focus:outline-none focus:border-purple-500 transition">
                </div>
            </div>
            <div class="grid grid-cols-2 gap-4 mb-4">
                <div>
                    <label class="block text-xs font-bold text-slate-400 mb-2 uppercase tracking-wide">IGN</label>
                    <input type="text" name="ign" value="{{ old('ign', $player->ign) }}" required
                           class="w-full bg-white/5 border border-white/10 rounded-xl px-4 py-3 text-white text-sm focus:outline-none focus:border-purple-500 transition">
                    @error('ign')<p class="text-red-400 text-xs mt-1">{{ $message }}</p>@enderror
                </div>
                <div>
                    <label class="block text-xs font-bold text-slate-400 mb-2 uppercase tracking-wide">Nama Asli</label>
                    <input type="text" name="nama_asli" value="{{ old('nama_asli', $player->nama_asli) }}" required
                           class="w-full bg-white/5 border border-white/10 rounded-xl px-4 py-3 text-white text-sm focus:outline-none focus:border-purple-500 transition">
                    @error('nama_asli')<p class="text-red-400 text-xs mt-1">{{ $message }}</p>@enderror
                </div>
            </div>
            <div class="mb-6">
                <label class="block text-xs font-bold text-slate-400 mb-2 uppercase tracking-wide">Role</label>
                <select name="role_game" required class="w-full bg-white/5 border border-white/10 rounded-xl px-4 py-3 text-white text-sm focus:outline-none focus:border-purple-500 transition">
                    @foreach(['jungler','roamer','midlaner','goldlaner','explaner'] as $role)
                    <option value="{{ $role }}" {{ old('role_game', $player->role_game) === $role ? 'selected' : '' }}>{{ ucfirst($role) }}</option>
                    @endforeach
                </select>
            </div>
            <button type="submit" class="w-full bg-purple-600 hover:bg-purple-700 text-white font-bold py-3 rounded-xl transition">
                Simpan Perubahan
            </button>
        </form>
    </div>
</div>
@endsection
