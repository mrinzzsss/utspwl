@extends('layouts.app')
@section('title', 'Edit Tournament — MPL PWL')

@section('content')
<div class="max-w-2xl mx-auto px-4 py-12">

    {{-- Header --}}
    <div class="mb-8">
        <a href="{{ route('tournaments.show', $tournament) }}"
           class="inline-flex items-center gap-2 text-slate-400 hover:text-purple-400 text-sm transition mb-4">
            <i class="fa fa-arrow-left"></i> Kembali ke Detail
        </a>
        <h1 class="text-3xl font-black text-white">Edit Tournament</h1>
        <p class="text-slate-400 text-sm mt-1">{{ $tournament->nama }}</p>
    </div>

    {{-- Card --}}
    <div class="card-glass rounded-2xl p-8">
        <form method="POST" action="{{ route('tournaments.update', $tournament) }}" enctype="multipart/form-data" class="space-y-6">
            @csrf
            @method('PUT')

            {{-- Nama --}}
            <div>
                <label class="block text-sm font-medium text-slate-300 mb-1.5">Nama Tournament <span class="text-red-400">*</span></label>
                <input type="text" name="nama" value="{{ old('nama', $tournament->nama) }}" placeholder="MPL Season 14"
                    class="w-full rounded-xl px-4 py-2.5 text-sm bg-white/5 border @error('nama') border-red-500/60 @else border-white/10 @enderror text-slate-200 placeholder-slate-500 focus:outline-none focus:border-purple-500 focus:bg-purple-500/5 transition">
                @error('nama') <p class="text-red-400 text-xs mt-1"><i class="fa fa-triangle-exclamation mr-1"></i>{{ $message }}</p> @enderror
            </div>

            {{-- Logo --}}
            <div>
                <label class="block text-sm font-medium text-slate-300 mb-1.5">Logo Tournament</label>

                {{-- Preview logo saat ini --}}
                @if($tournament->logo)
                <div class="mb-3 flex items-center gap-3">
                    <img src="{{ asset('storage/' . $tournament->logo) }}" alt="Logo saat ini"
                         class="w-16 h-16 rounded-xl object-cover border border-white/10">
                    <span class="text-slate-500 text-xs">Logo saat ini</span>
                </div>
                @endif

                <input type="file" name="logo" id="logoInput" accept="image/*" onchange="previewImage(this)"
                    class="w-full rounded-xl px-4 py-2.5 text-sm bg-white/5 border border-white/10 text-slate-400
                           file:mr-3 file:py-1 file:px-3 file:rounded-lg file:border-0 file:text-xs file:font-semibold
                           file:bg-purple-600 file:text-white hover:file:bg-purple-700 file:cursor-pointer
                           focus:outline-none focus:border-purple-500 transition">
                <p class="text-slate-600 text-xs mt-1">Kosongkan jika tidak ingin mengganti logo</p>
                <img id="logoPreview" src="" alt="" class="hidden mt-3 w-20 h-20 rounded-xl object-cover border border-white/10">
                @error('logo') <p class="text-red-400 text-xs mt-1"><i class="fa fa-triangle-exclamation mr-1"></i>{{ $message }}</p> @enderror
            </div>

            {{-- Format & Status (2 col) --}}
            <div class="grid grid-cols-2 gap-4">
                <div>
                    <label class="block text-sm font-medium text-slate-300 mb-1.5">Format <span class="text-red-400">*</span></label>
                    <select name="format"
                        class="w-full rounded-xl px-4 py-2.5 text-sm bg-white/5 border @error('format') border-red-500/60 @else border-white/10 @enderror text-slate-200 focus:outline-none focus:border-purple-500 transition">
                        <option value="single_elimination" {{ old('format', $tournament->format) == 'single_elimination' ? 'selected' : '' }}>Single Elimination</option>
                        <option value="round_robin"        {{ old('format', $tournament->format) == 'round_robin'        ? 'selected' : '' }}>Round Robin</option>
                    </select>
                    @error('format') <p class="text-red-400 text-xs mt-1">{{ $message }}</p> @enderror
                </div>

                <div>
                    <label class="block text-sm font-medium text-slate-300 mb-1.5">Status <span class="text-red-400">*</span></label>
                    <select name="status"
                        class="w-full rounded-xl px-4 py-2.5 text-sm bg-white/5 border @error('status') border-red-500/60 @else border-white/10 @enderror text-slate-200 focus:outline-none focus:border-purple-500 transition">
                        <option value="upcoming" {{ old('status', $tournament->status) == 'upcoming' ? 'selected' : '' }}>Upcoming</option>
                        <option value="ongoing"  {{ old('status', $tournament->status) == 'ongoing'  ? 'selected' : '' }}>Ongoing</option>
                        <option value="finished" {{ old('status', $tournament->status) == 'finished' ? 'selected' : '' }}>Finished</option>
                    </select>
                    @error('status') <p class="text-red-400 text-xs mt-1">{{ $message }}</p> @enderror
                </div>
            </div>

            {{-- Tanggal (2 col) --}}
            <div class="grid grid-cols-2 gap-4">
                <div>
                    <label class="block text-sm font-medium text-slate-300 mb-1.5">Tanggal Mulai <span class="text-red-400">*</span></label>
                    <input type="date" name="mulai" value="{{ old('mulai', $tournament->mulai?->format('Y-m-d')) }}"
                        class="w-full rounded-xl px-4 py-2.5 text-sm bg-white/5 border @error('mulai') border-red-500/60 @else border-white/10 @enderror text-slate-200 focus:outline-none focus:border-purple-500 transition">
                    @error('mulai') <p class="text-red-400 text-xs mt-1">{{ $message }}</p> @enderror
                </div>

                <div>
                    <label class="block text-sm font-medium text-slate-300 mb-1.5">Tanggal Selesai <span class="text-red-400">*</span></label>
                    <input type="date" name="selesai" value="{{ old('selesai', $tournament->selesai?->format('Y-m-d')) }}"
                        class="w-full rounded-xl px-4 py-2.5 text-sm bg-white/5 border @error('selesai') border-red-500/60 @else border-white/10 @enderror text-slate-200 focus:outline-none focus:border-purple-500 transition">
                    @error('selesai') <p class="text-red-400 text-xs mt-1">{{ $message }}</p> @enderror
                </div>
            </div>

            {{-- Actions --}}
            <div class="flex items-center gap-3 pt-2">
                <button type="submit"
                    class="bg-purple-600 hover:bg-purple-700 text-white font-semibold text-sm px-6 py-2.5 rounded-xl transition">
                    <i class="fa fa-floppy-disk mr-1.5"></i> Simpan Perubahan
                </button>
                <a href="{{ route('tournaments.show', $tournament) }}"
                   class="text-slate-400 hover:text-slate-200 text-sm px-4 py-2.5 rounded-xl border border-white/10 hover:border-white/20 transition">
                    Batal
                </a>
            </div>
        </form>
    </div>

    {{-- Danger zone --}}
    <div class="mt-6 card-glass rounded-2xl p-6 border border-red-500/20">
        <h3 class="text-sm font-semibold text-red-400 mb-1"><i class="fa fa-triangle-exclamation mr-1.5"></i>Danger Zone</h3>
        <p class="text-slate-500 text-xs mb-4">Menghapus tournament akan menghapus semua match, pemain, dan klasemen secara permanen.</p>
        <form method="POST" action="{{ route('tournaments.destroy', $tournament) }}"
              onsubmit="return confirm('Yakin hapus tournament {{ $tournament->nama }}? Tidak bisa dibatalkan!')">
            @csrf @method('DELETE')
            <button type="submit"
                class="bg-red-600/20 hover:bg-red-600/40 text-red-400 border border-red-500/30 font-semibold text-xs px-5 py-2 rounded-xl transition">
                <i class="fa fa-trash mr-1.5"></i> Hapus Tournament
            </button>
        </form>
    </div>
</div>

<script>
    function previewImage(input) {
        const preview = document.getElementById('logoPreview');
        if (input.files && input.files[0]) {
            const reader = new FileReader();
            reader.onload = e => { preview.src = e.target.result; preview.classList.remove('hidden'); };
            reader.readAsDataURL(input.files[0]);
        }
    }
</script>
@endsection
