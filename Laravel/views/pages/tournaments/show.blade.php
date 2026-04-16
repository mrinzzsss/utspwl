@extends('layouts.app')
@section('title', $tournament->nama)

@section('content')
<div class="max-w-7xl mx-auto px-4 py-10">

    {{-- Header --}}
    <div class="mb-10 flex items-start justify-between flex-wrap gap-4">
        <div>
            <a href="{{ route('home') }}" class="text-xs text-slate-500 hover:text-purple-400 mb-2 inline-block">← Kembali</a>
            <h1 class="text-4xl font-black text-white">{{ $tournament->nama }}</h1>
            <p class="text-slate-400 text-sm mt-1">
                {{ ucfirst(str_replace('_',' ',$tournament->format)) }} &middot;
                {{ $tournament->mulai->format('d M Y') }} – {{ $tournament->selesai->format('d M Y') }}
            </p>
        </div>
        @auth
        @if(auth()->user()->isAdmin() || auth()->user()->isManajemen())
        <div class="flex gap-2">
            <a href="{{ route('tournaments.players.create', $tournament) }}"
               class="text-xs bg-indigo-600 hover:bg-indigo-700 text-white px-4 py-2 rounded-lg transition">+ Pemain</a>
            <a href="{{ route('tournaments.matches.create', $tournament) }}"
               class="text-xs bg-purple-600 hover:bg-purple-700 text-white px-4 py-2 rounded-lg transition">+ Match</a>
        </div>
        @endif
        @endauth
    </div>

    <div class="grid lg:grid-cols-3 gap-8">

        {{-- Klasemen --}}
        <div class="lg:col-span-1">
            <h2 class="text-lg font-bold text-white mb-4"><i class="fa-solid fa-ranking-star text-purple-400 mr-2"></i>Klasemen</h2>
            <div class="card-glass rounded-2xl overflow-hidden">
                <table class="w-full text-sm">
                    <thead>
                        <tr class="border-b border-white/10 text-xs text-slate-400">
                            <th class="px-4 py-3 text-left">#</th>
                            <th class="px-4 py-3 text-left">Tim</th>
                            <th class="px-4 py-3 text-center">M</th>
                            <th class="px-4 py-3 text-center">K</th>
                            <th class="px-4 py-3 text-center font-bold text-purple-400">Poin</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($standings as $i => $s)
                        <tr class="border-b border-white/5 hover:bg-white/5">
                            <td class="px-4 py-3 text-slate-500 text-xs">{{ $i+1 }}</td>
                            <td class="px-4 py-3 font-semibold text-white">{{ $s->nama_tim }}</td>
                            <td class="px-4 py-3 text-center text-green-400">{{ $s->menang }}</td>
                            <td class="px-4 py-3 text-center text-red-400">{{ $s->kalah }}</td>
                            <td class="px-4 py-3 text-center font-black text-purple-300">{{ $s->poin }}</td>
                        </tr>
                        @empty
                        <tr><td colspan="5" class="px-4 py-6 text-center text-slate-500 text-xs">Belum ada data</td></tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>

        {{-- Match List --}}
        <div class="lg:col-span-2">
            <h2 class="text-lg font-bold text-white mb-4"><i class="fa-solid fa-gamepad text-purple-400 mr-2"></i>Semua Match</h2>
            @forelse($matches as $match)
            <div class="card-glass rounded-xl p-4 mb-3 flex items-center justify-between gap-4 flex-wrap">
                <div class="text-xs text-slate-400 w-24 shrink-0">
                    {{ $match->jadwal_tanding->format('d M') }}<br>
                    <span class="font-mono">{{ $match->jadwal_tanding->format('H:i') }}</span>
                </div>

                <div class="flex items-center gap-4 flex-1 justify-center">
                    <span class="font-bold text-sm text-right w-24
                        {{ $match->status === 'selesai' && $match->skor_a > $match->skor_b ? 'text-green-400' : 'text-white' }}">
                        {{ $match->tim_a }}
                    </span>

                    @if($match->status === 'selesai')
                        <span class="font-black text-xl text-white">{{ $match->skor_a }} — {{ $match->skor_b }}</span>
                    @else
                        <span class="text-slate-600 font-bold text-sm">VS</span>
                    @endif

                    <span class="font-bold text-sm text-left w-24
                        {{ $match->status === 'selesai' && $match->skor_b > $match->skor_a ? 'text-green-400' : 'text-white' }}">
                        {{ $match->tim_b }}
                    </span>
                </div>

                <div class="flex items-center gap-2 shrink-0">
                    @if($match->status === 'selesai')
                        <span class="text-xs bg-green-500/10 text-green-400 border border-green-500/20 px-2 py-1 rounded-full">Selesai</span>
                    @else
                        @auth
                        @if(auth()->user()->isWasit() || auth()->user()->isAdmin())
                        <a href="{{ route('matches.hasil', $match) }}"
                           class="text-xs bg-purple-600 hover:bg-purple-700 text-white px-3 py-1 rounded-lg transition">
                            Input Hasil
                        </a>
                        @endif
                        @endauth
                        <span class="text-xs bg-yellow-500/10 text-yellow-400 border border-yellow-500/20 px-2 py-1 rounded-full">Pending</span>
                    @endif
                </div>
            </div>
            @empty
            <div class="card-glass rounded-xl p-8 text-center text-slate-500 text-sm">Belum ada match dijadwalkan.</div>
            @endforelse

            {{-- Roster Pemain --}}
            <h2 class="text-lg font-bold text-white mt-8 mb-4"><i class="fa-solid fa-users text-purple-400 mr-2"></i>Roster Pemain</h2>
            @foreach($players as $tim => $roster)
            <div class="card-glass rounded-xl p-4 mb-4">
                <h3 class="font-bold text-purple-300 mb-3 text-sm uppercase tracking-wide">{{ $tim }}</h3>
                <div class="grid grid-cols-2 sm:grid-cols-3 gap-2">
                    @foreach($roster as $player)
                    <div class="bg-white/5 rounded-lg p-2.5 text-xs">
                        <div class="font-bold text-white">{{ $player->ign }}</div>
                        <div class="text-slate-400">{{ $player->nama_asli }}</div>
                        <div class="text-purple-400 mt-1 capitalize">{{ $player->role_game }}</div>
                    </div>
                    @endforeach
                </div>
            </div>
            @endforeach
        </div>
    </div>
</div>
@endsection
