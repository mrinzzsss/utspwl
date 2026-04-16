@extends('layouts.app')
@section('title', 'Input Hasil Match')

@section('content')
<div class="max-w-2xl mx-auto px-4 py-12">
    <a href="{{ route('tournaments.show', $match->tournament_id) }}" class="text-xs text-slate-500 hover:text-purple-400 mb-4 inline-flex items-center gap-1">
        <i class="fa-solid fa-arrow-left text-[10px]"></i> Kembali
    </a>
    <div class="card-glass rounded-2xl p-8 mt-3">
        <h1 class="text-2xl font-black text-white mb-1">Input Hasil Match</h1>
        <p class="text-slate-400 text-sm mb-8">{{ $match->tournament->nama }} · {{ $match->jadwal_tanding->format('d M Y H:i') }}</p>

        {{-- Preview match --}}
        <div class="flex items-center justify-center gap-6 mb-8 py-4 bg-white/3 rounded-xl">
            <span class="font-black text-xl text-white">{{ $match->tim_a }}</span>
            <span class="text-slate-500 font-bold">VS</span>
            <span class="font-black text-xl text-white">{{ $match->tim_b }}</span>
        </div>

        <form method="POST" action="{{ route('matches.updateHasil', $match) }}">
            @csrf @method('PUT')

            <div class="grid grid-cols-2 gap-4 mb-4">
                <div>
                    <label class="block text-xs font-bold text-slate-400 mb-2 uppercase tracking-wide">Skor {{ $match->tim_a }}</label>
                    <input type="number" name="skor_a" min="0" max="10" value="{{ old('skor_a', $match->skor_a) }}" required
                           class="w-full bg-white/5 border border-white/10 rounded-xl px-4 py-3 text-white text-2xl font-black text-center focus:outline-none focus:border-purple-500 transition">
                </div>
                <div>
                    <label class="block text-xs font-bold text-slate-400 mb-2 uppercase tracking-wide">Skor {{ $match->tim_b }}</label>
                    <input type="number" name="skor_b" min="0" max="10" value="{{ old('skor_b', $match->skor_b) }}" required
                           class="w-full bg-white/5 border border-white/10 rounded-xl px-4 py-3 text-white text-2xl font-black text-center focus:outline-none focus:border-purple-500 transition">
                </div>
            </div>

            <div class="mb-6">
                <label class="block text-xs font-bold text-slate-400 mb-2 uppercase tracking-wide">MVP (Opsional)</label>
                <select name="mvp_id" class="w-full bg-white/5 border border-white/10 rounded-xl px-4 py-3 text-white text-sm focus:outline-none focus:border-purple-500 transition">
                    <option value="">-- Pilih MVP --</option>
                    @foreach($players as $player)
                    <option value="{{ $player->id }}" {{ old('mvp_id', $match->mvp_id) == $player->id ? 'selected' : '' }}>
                        [{{ $player->nama_tim }}] {{ $player->ign }} ({{ $player->nama_asli }}) · {{ ucfirst($player->role_game) }}
                    </option>
                    @endforeach
                </select>
            </div>

            <button type="submit" class="w-full bg-green-600 hover:bg-green-700 text-white font-bold py-3 rounded-xl transition">
                <i class="fa-solid fa-flag-checkered mr-2"></i>Simpan Hasil
            </button>
        </form>
    </div>
</div>
@endsection
