@extends('layouts.app')
@section('title', $tournament->nama . ' — MPL PWL')

@section('content')
<div class="max-w-7xl mx-auto px-4 py-10">

    {{-- ── HEADER ──────────────────────────────────────────────── --}}
    <div class="mb-8">
        <a href="{{ route('tournaments.index') }}" class="text-xs text-slate-500 hover:text-purple-400 mb-3 inline-flex items-center gap-1">
            <i class="fa-solid fa-arrow-left text-[10px]"></i> Kembali
        </a>
        <div class="flex items-start justify-between flex-wrap gap-4">
            <div class="flex items-center gap-4">
                <div class="w-16 h-16 rounded-2xl bg-purple-500/10 flex items-center justify-center text-3xl shrink-0">
                    @if($tournament->logo)
                        <img src="{{ asset('storage/'.$tournament->logo) }}" class="w-14 h-14 object-contain rounded-xl">
                    @else 🏆 @endif
                </div>
                <div>
                    <h1 class="text-3xl font-black text-white">{{ $tournament->nama }}</h1>
                    <p class="text-slate-400 text-sm mt-1">
                        {{ ucfirst(str_replace('_',' ',$tournament->format)) }} &middot;
                        {{ $tournament->mulai->format('d M') }} – {{ $tournament->selesai->format('d M Y') }}
                    </p>
                </div>
            </div>
            @php $badge = ['upcoming'=>'bg-blue-500/10 text-blue-400 border-blue-500/20',
                           'ongoing' =>'bg-green-500/10 text-green-400 border-green-500/20',
                           'finished'=>'bg-slate-500/10 text-slate-400 border-slate-500/20'][$tournament->status]; @endphp
            <span class="text-sm {{ $badge }} border px-4 py-2 rounded-full font-semibold">
                {{ ucfirst($tournament->status) }}
            </span>
        </div>
    </div>

    {{-- ── TABS ─────────────────────────────────────────────────── --}}
    <div class="flex gap-1 mb-8 border-b border-white/10" x-data="{ tab: 'jadwal' }">
        @foreach(['jadwal'=>'Jadwal & Skor','klasemen'=>'Klasemen','bracket'=>'Bracket','roster'=>'Roster Pemain'] as $key=>$label)
        <button @click="tab='{{ $key }}'"
                :class="tab==='{{ $key }}' ? 'border-b-2 border-purple-500 text-purple-400' : 'text-slate-500 hover:text-slate-300'"
                class="px-4 py-3 text-sm font-semibold transition -mb-px">
            {{ $label }}
        </button>
        @endforeach

        {{-- Admin buttons --}}
        @auth
        <div class="ml-auto flex items-center gap-2 pb-2">
            @if(auth()->user()->isAdmin() || auth()->user()->isManajemen())
            <a href="{{ route('tournaments.players.create', $tournament) }}"
               class="text-xs bg-indigo-600 hover:bg-indigo-700 text-white px-3 py-1.5 rounded-lg transition">
                <i class="fa-solid fa-plus mr-1"></i>Pemain
            </a>
            <a href="{{ route('tournaments.matches.create', $tournament) }}"
               class="text-xs bg-purple-600 hover:bg-purple-700 text-white px-3 py-1.5 rounded-lg transition">
                <i class="fa-solid fa-plus mr-1"></i>Match
            </a>
            @endif
        </div>
        @endauth
    </div>

    {{-- Note: Alpine.js dibutuhkan untuk tabs. Jika tidak ada, tampilkan semua section --}}
    <div x-data="{ tab: 'jadwal' }">

        {{-- ── TAB: JADWAL & SKOR ───────────────────────────────── --}}
        <div x-show="tab==='jadwal'" x-cloak>
            @if($matches->isEmpty())
            <div class="card-glass rounded-2xl p-12 text-center text-slate-500">
                <i class="fa-regular fa-calendar-xmark text-4xl mb-3 block opacity-30"></i>
                Belum ada match dijadwalkan.
            </div>
            @else

            {{-- Match Pending --}}
            @php $pending = $matches->where('status','pending'); @endphp
            @if($pending->isNotEmpty())
            <h3 class="text-sm font-bold text-slate-400 uppercase tracking-widest mb-3">
                <i class="fa-solid fa-calendar-days mr-2 text-yellow-400"></i>Jadwal Mendatang
            </h3>
            <div class="space-y-3 mb-8">
                @foreach($pending as $match)
                <div class="card-glass rounded-xl p-4 flex items-center gap-4 flex-wrap">
                    <div class="text-center bg-yellow-500/10 rounded-lg px-3 py-2 w-16 shrink-0">
                        <div class="text-[10px] text-slate-400 uppercase">{{ $match->jadwal_tanding->format('M') }}</div>
                        <div class="text-xl font-black text-white">{{ $match->jadwal_tanding->format('d') }}</div>
                        <div class="text-[10px] text-yellow-300 font-mono">{{ $match->jadwal_tanding->format('H:i') }}</div>
                    </div>
                    <div class="flex-1 flex items-center justify-center gap-6">
                        <span class="font-black text-lg text-white text-right w-32 truncate">{{ $match->tim_a }}</span>
                        <span class="text-slate-500 text-sm font-bold px-3 py-1 border border-white/10 rounded-lg">VS</span>
                        <span class="font-black text-lg text-white text-left w-32 truncate">{{ $match->tim_b }}</span>
                    </div>
                    <div class="flex items-center gap-2 shrink-0">
                        <span class="text-xs bg-yellow-500/10 text-yellow-400 border border-yellow-500/20 px-3 py-1 rounded-full">Pending</span>
                        @auth @if(auth()->user()->isWasit() || auth()->user()->isAdmin())
                        <a href="{{ route('matches.hasil', $match) }}"
                           class="text-xs bg-purple-600 hover:bg-purple-700 text-white px-3 py-1 rounded-lg transition">
                            Input Hasil
                        </a>
                        @endif @endauth
                    </div>
                </div>
                @endforeach
            </div>
            @endif

            {{-- Match Selesai --}}
            @php $selesai = $matches->where('status','selesai'); @endphp
            @if($selesai->isNotEmpty())
            <h3 class="text-sm font-bold text-slate-400 uppercase tracking-widest mb-3">
                <i class="fa-solid fa-flag-checkered mr-2 text-green-400"></i>Hasil Match
            </h3>
            <div class="space-y-3">
                @foreach($selesai->sortByDesc('jadwal_tanding') as $match)
                <div class="card-glass rounded-xl p-5">
                    <div class="flex items-center gap-4 flex-wrap justify-between">
                        <div class="text-xs text-slate-500 w-20 shrink-0">
                            {{ $match->jadwal_tanding->format('d M Y') }}<br>
                            <span class="font-mono">{{ $match->jadwal_tanding->format('H:i') }}</span>
                        </div>
                        <div class="flex-1 flex items-center justify-center gap-4">
                            <span class="font-black text-xl w-36 text-right truncate
                                {{ $match->skor_a > $match->skor_b ? 'text-green-400' : 'text-slate-400' }}">
                                {{ $match->tim_a }}
                                @if($match->skor_a > $match->skor_b)
                                <i class="fa-solid fa-crown text-xs text-yellow-400 ml-1"></i>
                                @endif
                            </span>
                            <div class="text-center shrink-0">
                                <div class="font-black text-3xl text-white tracking-wider">
                                    <span class="{{ $match->skor_a > $match->skor_b ? 'text-green-400' : '' }}">{{ $match->skor_a }}</span>
                                    <span class="text-slate-600 mx-2">:</span>
                                    <span class="{{ $match->skor_b > $match->skor_a ? 'text-green-400' : '' }}">{{ $match->skor_b }}</span>
                                </div>
                                <div class="text-xs text-slate-500 mt-1">Final Score</div>
                            </div>
                            <span class="font-black text-xl w-36 text-left truncate
                                {{ $match->skor_b > $match->skor_a ? 'text-green-400' : 'text-slate-400' }}">
                                @if($match->skor_b > $match->skor_a)
                                <i class="fa-solid fa-crown text-xs text-yellow-400 mr-1"></i>
                                @endif
                                {{ $match->tim_b }}
                            </span>
                        </div>
                        <span class="text-xs bg-green-500/10 text-green-400 border border-green-500/20 px-3 py-1 rounded-full w-20 text-center shrink-0">Selesai</span>
                    </div>
                    @if($match->mvp)
                    <div class="mt-3 pt-3 border-t border-white/5 text-center text-xs text-yellow-400">
                        <i class="fa-solid fa-star mr-1"></i>
                        <span class="font-bold">MVP: {{ $match->mvp->ign }}</span>
                        <span class="text-slate-500 ml-1">({{ $match->mvp->nama_asli }} · {{ ucfirst($match->mvp->role_game) }})</span>
                    </div>
                    @endif
                </div>
                @endforeach
            </div>
            @endif

            @endif
        </div>

        {{-- ── TAB: KLASEMEN ───────────────────────────────────── --}}
        <div x-show="tab==='klasemen'" x-cloak>
            @if($standings->isEmpty())
            <div class="card-glass rounded-2xl p-12 text-center text-slate-500">
                <i class="fa-solid fa-ranking-star text-4xl mb-3 block opacity-30"></i>
                Klasemen belum tersedia.
            </div>
            @else
            <div class="card-glass rounded-2xl overflow-hidden">
                <table class="w-full text-sm">
                    <thead>
                        <tr class="border-b border-white/10 text-xs text-slate-400 uppercase tracking-wide">
                            <th class="px-6 py-4 text-left w-8">#</th>
                            <th class="px-6 py-4 text-left">Tim</th>
                            <th class="px-6 py-4 text-center">Main</th>
                            <th class="px-6 py-4 text-center text-green-400">Menang</th>
                            <th class="px-6 py-4 text-center text-red-400">Kalah</th>
                            <th class="px-6 py-4 text-center text-purple-400 font-bold">Poin</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($standings as $i => $s)
                        <tr class="border-b border-white/5 hover:bg-white/5 transition
                            {{ $i === 0 ? 'bg-yellow-500/5' : '' }}">
                            <td class="px-6 py-4">
                                @if($i === 0) <span class="text-yellow-400 font-black">🥇</span>
                                @elseif($i === 1) <span class="text-slate-300 font-black">🥈</span>
                                @elseif($i === 2) <span class="text-amber-600 font-black">🥉</span>
                                @else <span class="text-slate-500 font-bold text-xs">{{ $i+1 }}</span>
                                @endif
                            </td>
                            <td class="px-6 py-4">
                                <div class="font-bold text-white">{{ $s->nama_tim }}</div>
                            </td>
                            <td class="px-6 py-4 text-center text-slate-300">{{ $s->menang + $s->kalah }}</td>
                            <td class="px-6 py-4 text-center text-green-400 font-bold">{{ $s->menang }}</td>
                            <td class="px-6 py-4 text-center text-red-400 font-bold">{{ $s->kalah }}</td>
                            <td class="px-6 py-4 text-center">
                                <span class="font-black text-lg text-white bg-purple-500/10 px-3 py-1 rounded-lg">{{ $s->poin }}</span>
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
            @endif
        </div>

        {{-- ── TAB: BRACKET ────────────────────────────────────── --}}
        <div x-show="tab==='bracket'" x-cloak>
            @php $selesaiMatches = $matches->where('status','selesai'); @endphp
            @if($selesaiMatches->isEmpty())
            <div class="card-glass rounded-2xl p-12 text-center text-slate-500">
                <i class="fa-solid fa-diagram-project text-4xl mb-3 block opacity-30"></i>
                Bracket belum tersedia. Match belum ada yang selesai.
            </div>
            @else
            <div class="overflow-x-auto pb-4">
                <div class="min-w-[600px]">
                    <h3 class="text-sm font-bold text-slate-400 uppercase tracking-widest mb-4">
                        Match Bracket — {{ $tournament->nama }}
                    </h3>
                    <div class="space-y-3">
                        @foreach($selesaiMatches as $idx => $match)
                        <div class="flex items-stretch gap-0">
                            {{-- Nomor --}}
                            <div class="flex items-center justify-center w-10 text-xs text-slate-600 font-bold shrink-0">
                                {{ $idx + 1 }}
                            </div>
                            {{-- Tim A --}}
                            <div class="flex-1 flex items-center justify-between px-4 py-3 rounded-l-xl border border-r-0
                                {{ $match->skor_a > $match->skor_b ? 'bg-green-500/10 border-green-500/20' : 'bg-white/3 border-white/5' }}">
                                <span class="font-bold text-sm {{ $match->skor_a > $match->skor_b ? 'text-green-400' : 'text-slate-400' }}">
                                    @if($match->skor_a > $match->skor_b)<i class="fa-solid fa-crown text-yellow-400 text-xs mr-1"></i>@endif
                                    {{ $match->tim_a }}
                                </span>
                                <span class="font-black text-2xl {{ $match->skor_a > $match->skor_b ? 'text-green-400' : 'text-slate-600' }}">
                                    {{ $match->skor_a }}
                                </span>
                            </div>
                            {{-- Divider --}}
                            <div class="flex items-center justify-center w-8 bg-white/3 border-y border-white/5 text-slate-600 text-xs font-bold shrink-0">:</div>
                            {{-- Tim B --}}
                            <div class="flex-1 flex items-center justify-between px-4 py-3 rounded-r-xl border border-l-0
                                {{ $match->skor_b > $match->skor_a ? 'bg-green-500/10 border-green-500/20' : 'bg-white/3 border-white/5' }}">
                                <span class="font-black text-2xl {{ $match->skor_b > $match->skor_a ? 'text-green-400' : 'text-slate-600' }}">
                                    {{ $match->skor_b }}
                                </span>
                                <span class="font-bold text-sm text-right {{ $match->skor_b > $match->skor_a ? 'text-green-400' : 'text-slate-400' }}">
                                    {{ $match->tim_b }}
                                    @if($match->skor_b > $match->skor_a)<i class="fa-solid fa-crown text-yellow-400 text-xs ml-1"></i>@endif
                                </span>
                            </div>
                        </div>
                        @endforeach
                    </div>
                </div>
            </div>
            @endif
        </div>

        {{-- ── TAB: ROSTER ─────────────────────────────────────── --}}
        <div x-show="tab==='roster'" x-cloak>
            @if($players->isEmpty())
            <div class="card-glass rounded-2xl p-12 text-center text-slate-500">
                <i class="fa-solid fa-users text-4xl mb-3 block opacity-30"></i>
                Belum ada pemain terdaftar.
            </div>
            @else
            <div class="grid md:grid-cols-2 gap-6">
                @foreach($players as $tim => $roster)
                <div class="card-glass rounded-2xl p-5">
                    <div class="flex items-center gap-3 mb-4 pb-4 border-b border-white/10">
                        @php $pl = $roster->first(); @endphp
                        @if($pl && $pl->logo_tim)
                        <img src="{{ asset('storage/'.$pl->logo_tim) }}" class="w-10 h-10 rounded-lg object-contain bg-white/5">
                        @else
                        <div class="w-10 h-10 rounded-lg bg-purple-500/20 flex items-center justify-center text-lg">🛡️</div>
                        @endif
                        <div>
                            <h3 class="font-black text-white">{{ $tim }}</h3>
                            <p class="text-xs text-slate-500">{{ $roster->count() }} pemain</p>
                        </div>
                    </div>
                    <div class="space-y-2">
                        @foreach($roster as $player)
                        <div class="flex items-center justify-between gap-3 bg-white/3 rounded-lg px-3 py-2.5">
                            <div class="min-w-0">
                                <div class="font-bold text-white text-sm truncate">{{ $player->ign }}</div>
                                <div class="text-xs text-slate-400 truncate">{{ $player->nama_asli }}</div>
                            </div>
                            @php $roleColor = [
                                'jungler'   => 'text-red-400 bg-red-500/10 border-red-500/20',
                                'roamer'    => 'text-blue-400 bg-blue-500/10 border-blue-500/20',
                                'midlaner'  => 'text-yellow-400 bg-yellow-500/10 border-yellow-500/20',
                                'goldlaner' => 'text-green-400 bg-green-500/10 border-green-500/20',
                                'explaner'  => 'text-orange-400 bg-orange-500/10 border-orange-500/20',
                            ][$player->role_game]; @endphp
                            <span class="text-xs {{ $roleColor }} border px-2 py-0.5 rounded-full shrink-0 capitalize">
                                {{ $player->role_game }}
                            </span>
                        </div>
                        @endforeach
                    </div>
                </div>
                @endforeach
            </div>
            @endif
        </div>

    </div>{{-- end x-data --}}
</div>

{{-- Alpine.js CDN (fallback jika belum ada) --}}
<script>
if (typeof Alpine === 'undefined') {
    const s = document.createElement('script');
    s.src = 'https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js';
    s.defer = true;
    document.head.appendChild(s);
}
</script>

@endsection
