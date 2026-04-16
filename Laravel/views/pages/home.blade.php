@extends('layouts.app')
@section('title', 'MPL PWL - Home')

@section('content')

{{-- ── HERO ──────────────────────────────────────────────── --}}
<section class="relative overflow-hidden py-24 px-4 text-center"
         style="background: radial-gradient(ellipse 80% 60% at 50% 0%, rgba(99,102,241,0.18) 0%, transparent 70%)">
    <div class="max-w-3xl mx-auto">
        <div class="inline-block text-xs font-semibold tracking-widest text-purple-400 border border-purple-500/30 px-3 py-1 rounded-full mb-6 uppercase">
            Mobile Legends Professional League
        </div>
        <h1 class="text-5xl md:text-7xl font-black mb-4 leading-tight gradient-text">MPL PWL</h1>
        <p class="text-slate-400 text-lg mb-8">Kompetisi Mobile Legends paling bergengsi. Ikuti jadwal, hasil, dan klasemen terkini.</p>

        @if($tournamentAktif)
            <div class="card-glass inline-flex items-center gap-3 px-6 py-3 rounded-2xl mb-8">
                <span class="w-2 h-2 bg-green-400 rounded-full animate-pulse"></span>
                <span class="text-sm font-semibold text-white">Live: {{ $tournamentAktif->nama }}</span>
            </div>
        @endif

        <div class="flex gap-4 justify-center flex-wrap">
            <a href="{{ route('tournaments.index') }}"
               class="bg-purple-600 hover:bg-purple-700 text-white font-semibold px-8 py-3 rounded-xl transition">
                Lihat Tournament
            </a>
            @if($jadwalTerdekat->isNotEmpty())
                <a href="#jadwal"
                   class="border border-white/20 hover:border-purple-500 text-white font-semibold px-8 py-3 rounded-xl transition">
                    Jadwal Match
                </a>
            @endif
        </div>
    </div>
</section>

{{-- ── STATS BANNER ─────────────────────────────────────── --}}
<section class="max-w-7xl mx-auto px-4 mb-16">
    <div class="grid grid-cols-2 md:grid-cols-4 gap-4">
        @foreach([
            ['label' => 'Tournaments', 'value' => $tournaments->count(), 'icon' => 'fa-trophy'],
            ['label' => 'Match Selesai', 'value' => $hasilTerakhir->count(), 'icon' => 'fa-flag-checkered'],
            ['label' => 'Jadwal Pending', 'value' => $jadwalTerdekat->count(), 'icon' => 'fa-calendar'],
            ['label' => 'Active Tournament', 'value' => $tournaments->where('status','ongoing')->count(), 'icon' => 'fa-fire'],
        ] as $stat)
        <div class="card-glass rounded-2xl p-5 text-center">
            <i class="fa-solid {{ $stat['icon'] }} text-purple-400 text-xl mb-2"></i>
            <div class="text-3xl font-black text-white">{{ $stat['value'] }}</div>
            <div class="text-xs text-slate-400 mt-1">{{ $stat['label'] }}</div>
        </div>
        @endforeach
    </div>
</section>

{{-- ── JADWAL & HASIL ───────────────────────────────────── --}}
<section class="max-w-7xl mx-auto px-4 mb-16" id="jadwal">
    <div class="grid md:grid-cols-2 gap-8">

        {{-- Jadwal Terdekat --}}
        <div>
            <h2 class="text-xl font-bold text-white mb-4 flex items-center gap-2">
                <i class="fa-solid fa-calendar-days text-purple-400"></i> Jadwal Match
            </h2>
            @forelse($jadwalTerdekat as $match)
            <div class="card-glass rounded-xl p-4 mb-3 flex items-center justify-between gap-4">
                <div class="text-xs text-slate-400">
                    {{ $match->jadwal_tanding->format('d M · H:i') }}<br>
                    <span class="text-purple-300 text-[11px]">{{ $match->tournament->nama }}</span>
                </div>
                <div class="flex items-center gap-3 font-bold text-sm">
                    <span class="text-white">{{ $match->tim_a }}</span>
                    <span class="text-slate-500 text-xs">VS</span>
                    <span class="text-white">{{ $match->tim_b }}</span>
                </div>
                <span class="text-xs bg-yellow-500/10 text-yellow-400 border border-yellow-500/20 px-2 py-1 rounded-full">Pending</span>
            </div>
            @empty
            <div class="card-glass rounded-xl p-6 text-center text-slate-500 text-sm">Belum ada jadwal</div>
            @endforelse
        </div>

        {{-- Hasil Terakhir --}}
        <div>
            <h2 class="text-xl font-bold text-white mb-4 flex items-center gap-2">
                <i class="fa-solid fa-flag-checkered text-purple-400"></i> Hasil Terakhir
            </h2>
            @forelse($hasilTerakhir as $match)
            <div class="card-glass rounded-xl p-4 mb-3">
                <div class="flex items-center justify-between gap-4">
                    <span class="font-bold text-sm {{ $match->skor_a > $match->skor_b ? 'text-green-400' : 'text-slate-400' }}">
                        {{ $match->tim_a }}
                    </span>
                    <div class="text-center">
                        <span class="text-white font-black text-lg">{{ $match->skor_a }} — {{ $match->skor_b }}</span>
                        <div class="text-[10px] text-slate-500 mt-0.5">{{ $match->tournament->nama }}</div>
                    </div>
                    <span class="font-bold text-sm text-right {{ $match->skor_b > $match->skor_a ? 'text-green-400' : 'text-slate-400' }}">
                        {{ $match->tim_b }}
                    </span>
                </div>
                @if($match->mvp)
                <div class="mt-2 text-center text-xs text-yellow-400">
                    <i class="fa-solid fa-star text-[10px]"></i> MVP: {{ $match->mvp->ign }}
                </div>
                @endif
            </div>
            @empty
            <div class="card-glass rounded-xl p-6 text-center text-slate-500 text-sm">Belum ada hasil</div>
            @endforelse
        </div>
    </div>
</section>

{{-- ── TOURNAMENTS LIST ─────────────────────────────────── --}}
<section class="max-w-7xl mx-auto px-4 mb-16">
    <div class="flex items-center justify-between mb-6">
        <h2 class="text-xl font-bold text-white">
            <i class="fa-solid fa-trophy text-purple-400 mr-2"></i>Semua Tournament
        </h2>
        @auth
        @if(auth()->user()->isAdmin())
        <a href="{{ route('tournaments.create') }}"
           class="text-xs bg-purple-600 hover:bg-purple-700 text-white px-4 py-2 rounded-lg transition">
            + Tambah
        </a>
        @endif
        @endauth
    </div>

    <div class="grid sm:grid-cols-2 lg:grid-cols-3 gap-5">
        @forelse($tournaments as $t)
        <a href="{{ route('tournaments.show', $t) }}"
           class="card-glass rounded-2xl p-5 hover:border-purple-500/40 transition group block">
            <div class="flex items-start justify-between mb-3">
                <div>
                    <h3 class="font-bold text-white group-hover:text-purple-300 transition">{{ $t->nama }}</h3>
                    <p class="text-xs text-slate-400 mt-1">{{ ucfirst(str_replace('_', ' ', $t->format)) }}</p>
                </div>
                @php
                    $color = ['upcoming'=>'blue','ongoing'=>'green','finished'=>'slate'][$t->status];
                @endphp
                <span class="text-xs bg-{{ $color }}-500/10 text-{{ $color }}-400 border border-{{ $color }}-500/20 px-2 py-1 rounded-full whitespace-nowrap">
                    {{ ucfirst($t->status) }}
                </span>
            </div>
            <div class="text-xs text-slate-500 flex gap-3">
                <span><i class="fa-regular fa-calendar mr-1"></i>{{ $t->mulai->format('d M Y') }}</span>
                <span>→ {{ $t->selesai->format('d M Y') }}</span>
            </div>
        </a>
        @empty
        <div class="col-span-3 card-glass rounded-2xl p-8 text-center text-slate-500">
            Belum ada tournament.
        </div>
        @endforelse
    </div>
</section>

@endsection
