@extends('layouts.app')
@section('title', 'Jadwalkan Match')

@section('content')
<div class="max-w-2xl mx-auto px-4 py-12">
    <a href="{{ route('tournaments.show', $tournament) }}" class="text-xs text-slate-500 hover:text-purple-400 mb-4 inline-flex items-center gap-1">
        <i class="fa-solid fa-arrow-left text-[10px]"></i> Kembali ke {{ $tournament->nama }}
    </a>
    <div class="card-glass rounded-2xl p-8 mt-3">
        <h1 class="text-2xl font-black text-white mb-2">Jadwalkan Match</h1>
        <p class="text-slate-400 text-sm mb-8">{{ $tournament->nama }}</p>

        <form method="POST" action="{{ route('tournaments.matches.store', $tournament) }}">
            @csrf
            <div class="grid grid-cols-2 gap-4 mb-4">
                <div>
                    <label class="block text-xs font-bold text-slate-400 mb-2 uppercase tracking-wide">Tim A</label>
                    <input type="text" name="tim_a" value="{{ old('tim_a') }}" required
                           class="w-full bg-white/5 border border-white/10 rounded-xl px-4 py-3 text-white text-sm focus:outline-none focus:border-purple-500 transition"
                           placeholder="Nama Tim A">
                    @error('tim_a')<p class="text-red-400 text-xs mt-1">{{ $message }}</p>@enderror
                </div>
                <div>
                    <label class="block text-xs font-bold text-slate-400 mb-2 uppercase tracking-wide">Tim B</label>
                    <input type="text" name="tim_b" value="{{ old('tim_b') }}" required
                           class="w-full bg-white/5 border border-white/10 rounded-xl px-4 py-3 text-white text-sm focus:outline-none focus:border-purple-500 transition"
                           placeholder="Nama Tim B">
                    @error('tim_b')<p class="text-red-400 text-xs mt-1">{{ $message }}</p>@enderror
                </div>
            </div>
            <div class="mb-6">
                <label class="block text-xs font-bold text-slate-400 mb-2 uppercase tracking-wide">Jadwal Tanding</label>
                <input type="datetime-local" name="jadwal_tanding" value="{{ old('jadwal_tanding') }}" required
                       class="w-full bg-white/5 border border-white/10 rounded-xl px-4 py-3 text-white text-sm focus:outline-none focus:border-purple-500 transition">
                @error('jadwal_tanding')<p class="text-red-400 text-xs mt-1">{{ $message }}</p>@enderror
            </div>
            <button type="submit" class="w-full bg-purple-600 hover:bg-purple-700 text-white font-bold py-3 rounded-xl transition">
                Jadwalkan Match
            </button>
        </form>
    </div>
</div>
@endsection
