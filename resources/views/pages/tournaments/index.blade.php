@extends('layouts.app')
@section('title', 'Semua Tournament — MPL PWL')

@section('content')
<div class="max-w-7xl mx-auto px-4 py-12">

    <div class="flex items-center justify-between mb-8 flex-wrap gap-4">
        <div>
            <h1 class="text-3xl font-black text-white">Tournament</h1>
            <p class="text-slate-400 text-sm mt-1">Semua kompetisi MPL PWL</p>
        </div>
        @auth @if(auth()->user()->isAdmin())
        <a href="{{ route('tournaments.create') }}"
           class="bg-purple-600 hover:bg-purple-700 text-white text-sm font-semibold px-5 py-2.5 rounded-xl transition">
            <i class="fa-solid fa-plus mr-1"></i> Tambah Tournament
        </a>
        @endif @endauth
    </div>

    {{-- Filter tabs --}}
    <div class="flex gap-2 mb-8 flex-wrap">
        @foreach(['all'=>'Semua','upcoming'=>'Upcoming','ongoing'=>'Ongoing','finished'=>'Selesai'] as $val=>$label)
        <a href="{{ route('tournaments.index', $val !== 'all' ? ['status'=>$val] : []) }}"
           class="text-xs px-4 py-2 rounded-full border transition
           {{ (request('status',$val==='all'?'all':null) === $val || ($val==='all' && !request('status'))) ? 'bg-purple-600 border-purple-600 text-white' : 'border-white/10 text-slate-400 hover:border-purple-500' }}">
            {{ $label }}
        </a>
        @endforeach
    </div>

    <div class="grid sm:grid-cols-2 lg:grid-cols-3 gap-6">
        @forelse($tournaments as $t)
        <a href="{{ route('tournaments.show', $t) }}"
           class="card-glass rounded-2xl p-6 hover:border-purple-500/40 transition group block">

            {{-- Logo + Status --}}
            <div class="flex items-start justify-between mb-4">
                <div class="w-12 h-12 rounded-xl bg-purple-500/10 flex items-center justify-center text-2xl shrink-0">
                    @if($t->logo)
                        <img src="{{ asset('storage/'.$t->logo) }}" class="w-10 h-10 object-contain rounded-lg">
                    @else
                        🏆
                    @endif
                </div>
                @php $badge = ['upcoming'=>'bg-blue-500/10 text-blue-400 border-blue-500/20',
                               'ongoing' =>'bg-green-500/10 text-green-400 border-green-500/20',
                               'finished'=>'bg-slate-500/10 text-slate-400 border-slate-500/20'][$t->status]; @endphp
                <span class="text-xs {{ $badge }} border px-3 py-1 rounded-full">
                    @if($t->status === 'ongoing') <span class="inline-block w-1.5 h-1.5 bg-green-400 rounded-full mr-1 animate-pulse"></span> @endif
                    {{ ucfirst($t->status) }}
                </span>
            </div>

            <h3 class="font-black text-white text-lg group-hover:text-purple-300 transition mb-1">{{ $t->nama }}</h3>
            <p class="text-xs text-slate-500 mb-4">{{ ucfirst(str_replace('_',' ',$t->format)) }}</p>

            <div class="border-t border-white/5 pt-4 flex items-center justify-between text-xs text-slate-500">
                <span><i class="fa-regular fa-calendar mr-1"></i>{{ $t->mulai->format('d M Y') }}</span>
                <span>→ {{ $t->selesai->format('d M Y') }}</span>
            </div>
        </a>
        @empty
        <div class="col-span-3 card-glass rounded-2xl p-12 text-center text-slate-500">
            <i class="fa-solid fa-trophy text-4xl mb-3 block opacity-20"></i>
            Belum ada tournament.
        </div>
        @endforelse
    </div>

    <div class="mt-8">{{ $tournaments->links() }}</div>
</div>
@endsection
