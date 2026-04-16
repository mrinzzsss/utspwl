@extends('layouts.app')
@section('title', 'MPL PWL — Home')

@section('content')

{{-- ── HERO ─────────────────────────────────────────────────────── --}}
<section class="relative overflow-hidden py-24 px-4 text-center"
         style="background: radial-gradient(ellipse 80% 60% at 50% 0%, rgba(99,102,241,0.2) 0%, transparent 70%)">
    <div class="max-w-3xl mx-auto">
        <div class="inline-block text-xs font-semibold tracking-widest text-purple-400 border border-purple-500/30 px-3 py-1 rounded-full mb-6 uppercase">
            Mobile Legends Professional League
        </div>
        <h1 class="text-5xl md:text-7xl font-black mb-4 leading-tight gradient-text">MPL PWL</h1>
        <p class="text-slate-400 text-lg mb-8">
            Kompetisi Mobile Legends paling bergengsi.<br>
            Ikuti jadwal, hasil, dan klasemen terkini.
        </p>
        @if($tournamentAktif)
        <div class="card-glass inline-flex items-center gap-3 px-6 py-3 rounded-2xl mb-8">
            <span class="w-2 h-2 bg-green-400 rounded-full animate-pulse"></span>
            <span class="text-sm font-semibold text-white">🔴 Live: {{ $tournamentAktif->nama }}</span>
        </div>
        @endif
        <div class="flex gap-4 justify-center flex-wrap">
            <a href="{{ route('tournaments.index') }}" class="bg-purple-600 hover:bg-purple-700 text-white font-semibold px-8 py-3 rounded-xl transition">
                Lihat Tournament
            </a>
            <a href="#jadwal" class="border border-white/20 hover:border-purple-500 text-white font-semibold px-8 py-3 rounded-xl transition">
                Jadwal Match
            </a>
        </div>
    </div>
</section>

{{-- ── STATS ────────────────────────────────────────────────────── --}}
<section class="max-w-7xl mx-auto px-4 mb-16">
    <div class="grid grid-cols-2 md:grid-cols-4 gap-4">
        @foreach([
            ['label'=>'Total Tournament','value'=>$tournaments->count(),'icon'=>'fa-trophy','color'=>'purple'],
            ['label'=>'Match Selesai','value'=>$hasilTerakhir->count(),'icon'=>'fa-flag-checkered','color'=>'green'],
            ['label'=>'Match Pending','value'=>$jadwalTerdekat->count(),'icon'=>'fa-calendar','color'=>'yellow'],
            ['label'=>'Sedang Berlangsung','value'=>$tournaments->where('status','ongoing')->count(),'icon'=>'fa-fire','color'=>'red'],
        ] as $s)
        <div class="card-glass rounded-2xl p-5 text-center">
            <i class="fa-solid {{ $s['icon'] }} text-{{ $s['color'] }}-400 text-xl mb-2"></i>
            <div class="text-3xl font-black text-white">{{ $s['value'] }}</div>
            <div class="text-xs text-slate-400 mt-1">{{ $s['label'] }}</div>
        </div>
        @endforeach
    </div>
</section>

{{-- ── JADWAL & HASIL ───────────────────────────────────────────── --}}
<section class="max-w-7xl mx-auto px-4 mb-16" id="jadwal">
    <div class="grid md:grid-cols-2 gap-8">

        {{-- Jadwal --}}
        <div>
            <h2 class="text-xl font-bold text-white mb-5 flex items-center gap-2">
                <span class="w-1 h-6 bg-purple-500 rounded-full"></span> Jadwal Match
            </h2>
            @forelse($jadwalTerdekat as $match)
            <a href="{{ route('tournaments.show', $match->tournament_id) }}"
               class="card-glass rounded-xl p-4 mb-3 flex items-center gap-4 hover:border-purple-500/40 transition block">
                <div class="text-center bg-purple-500/10 rounded-lg px-3 py-2 w-16 shrink-0">
                    <div class="text-[10px] text-slate-400 uppercase">{{ $match->jadwal_tanding->format('M') }}</div>
                    <div class="text-xl font-black text-white">{{ $match->jadwal_tanding->format('d') }}</div>
                    <div class="text-[10px] text-purple-300 font-mono">{{ $match->jadwal_tanding->format('H:i') }}</div>
                </div>
                <div class="flex-1 min-w-0">
                    <div class="flex items-center justify-between gap-2">
                        <span class="font-bold text-sm text-white truncate">{{ $match->tim_a }}</span>
                        <span class="text-slate-500 text-xs font-bold shrink-0">VS</span>
                        <span class="font-bold text-sm text-white truncate text-right">{{ $match->tim_b }}</span>
                    </div>
                    <div class="text-xs text-slate-500 mt-1 truncate">{{ $match->tournament->nama }}</div>
                </div>
                <span class="text-xs bg-yellow-500/10 text-yellow-400 border border-yellow-500/20 px-2 py-1 rounded-full shrink-0">Pending</span>
            </a>
            @empty
            <div class="card-glass rounded-xl p-8 text-center text-slate-500 text-sm">
                <i class="fa-regular fa-calendar-xmark text-2xl mb-2 block"></i>Belum ada jadwal
            </div>
            @endforelse
        </div>

        {{-- Hasil --}}
        <div>
            <h2 class="text-xl font-bold text-white mb-5 flex items-center gap-2">
                <span class="w-1 h-6 bg-green-500 rounded-full"></span> Hasil Terakhir
            </h2>
            @forelse($hasilTerakhir as $match)
            <a href="{{ route('tournaments.show', $match->tournament_id) }}"
               class="card-glass rounded-xl p-4 mb-3 hover:border-purple-500/40 transition block">
                <div class="flex items-center justify-between gap-3">
                    <span class="font-bold text-sm w-28 text-right {{ $match->skor_a > $match->skor_b ? 'text-green-400' : 'text-slate-400' }}">
                        {{ $match->tim_a }}
                    </span>
                    <div class="text-center shrink-0">
                        <div class="font-black text-2xl text-white">
                            {{ $match->skor_a }}<span class="text-slate-600 mx-1 text-base">—</span>{{ $match->skor_b }}
                        </div>
                        <div class="text-[10px] text-slate-500 mt-0.5">{{ $match->tournament->nama }}</div>
                    </div>
                    <span class="font-bold text-sm w-28 text-left {{ $match->skor_b > $match->skor_a ? 'text-green-400' : 'text-slate-400' }}">
                        {{ $match->tim_b }}
                    </span>
                </div>
                @if($match->mvp)
                <div class="mt-2 text-center text-xs text-yellow-400">
                    <i class="fa-solid fa-star text-[10px] mr-1"></i>MVP:
                    <span class="font-bold">{{ $match->mvp->ign }}</span>
                    <span class="text-slate-500">({{ $match->mvp->nama_asli }})</span>
                </div>
                @endif
            </a>
            @empty
            <div class="card-glass rounded-xl p-8 text-center text-slate-500 text-sm">
                <i class="fa-solid fa-flag-checkered text-2xl mb-2 block"></i>Belum ada hasil
            </div>
            @endforelse
        </div>
    </div>
</section>

{{-- ── TOURNAMENT LIST ──────────────────────────────────────────── --}}
<section class="max-w-7xl mx-auto px-4 mb-20">
    <div class="flex items-center justify-between mb-6">
        <h2 class="text-xl font-bold text-white flex items-center gap-2">
            <span class="w-1 h-6 bg-yellow-500 rounded-full"></span> Semua Tournament
        </h2>
        <a href="{{ route('tournaments.index') }}" class="text-xs text-purple-400 hover:text-purple-300">Lihat Semua →</a>
    </div>
    <div class="grid sm:grid-cols-2 lg:grid-cols-3 gap-5">
        @foreach($tournaments->take(6) as $t)
        <a href="{{ route('tournaments.show', $t) }}"
           class="card-glass rounded-2xl p-5 hover:border-purple-500/40 transition group block">
            <div class="flex items-start justify-between mb-3">
                <h3 class="font-bold text-white group-hover:text-purple-300 transition leading-tight">{{ $t->nama }}</h3>
                @php $badge = ['upcoming'=>['bg-blue-500/10 text-blue-400 border-blue-500/20'],
                               'ongoing' =>['bg-green-500/10 text-green-400 border-green-500/20'],
                               'finished'=>['bg-slate-500/10 text-slate-400 border-slate-500/20']][$t->status][0]; @endphp
                <span class="text-xs {{ $badge }} border px-2 py-1 rounded-full whitespace-nowrap ml-2">{{ ucfirst($t->status) }}</span>
            </div>
            <p class="text-xs text-slate-500 mb-3">{{ ucfirst(str_replace('_',' ',$t->format)) }}</p>
            <div class="flex items-center justify-between text-xs text-slate-500">
                <span><i class="fa-regular fa-calendar mr-1"></i>{{ $t->mulai->format('d M Y') }}</span>
                <span>{{ $t->selesai->format('d M Y') }}</span>
            </div>
        </a>
        @endforeach
    </div>
</section>

@endsection
