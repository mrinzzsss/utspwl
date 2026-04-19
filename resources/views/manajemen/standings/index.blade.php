@php $withSidebar = true; @endphp
@extends('layouts.app')
@section('title', 'Klasemen')

@section('sidebar')
@include('components.sidebar-manajemen', ['active' => 'standings'])
@endsection

@section('content')
<div class="d-flex justify-content-between align-items-center mb-4">
    <div>
        <h4 class="fw-bold mb-0">Klasemen</h4>
        <small class="text-muted">Data poin dan statistik tim per season</small>
    </div>
    <a href="{{ route('manajemen.standings.create') }}" class="btn btn-primary">
        <i class="bi bi-plus-lg me-1"></i> Tambah / Update Klasemen
    </a>
</div>

{{-- Filter season --}}
<form method="GET" class="mb-3">
    <div class="d-flex gap-2 align-items-center" style="max-width:300px;">
        <select name="season" class="form-select form-select-sm">
            @foreach($seasons as $s)
                <option value="{{ $s }}" {{ $season == $s ? 'selected' : '' }}>Season {{ $s }}</option>
            @endforeach
        </select>
        <button type="submit" class="btn btn-sm btn-outline-primary">Tampilkan</button>
    </div>
</form>

<div class="card">
    <div class="card-header py-3" style="background:#0f2b5b; color:#fff;">
        <span class="fw-semibold"><i class="bi bi-bar-chart-line-fill me-2"></i>Klasemen Season {{ $season }}</span>
    </div>
    <div class="card-body p-0">
        @if($standings->isEmpty())
            <div class="text-center py-5 text-muted">
                <i class="bi bi-bar-chart fs-1 d-block mb-2"></i>
                Belum ada data klasemen untuk season ini.
            </div>
        @else
        <div class="table-responsive">
            <table class="table table-hover align-middle mb-0">
                <thead>
                    <tr>
                        <th class="ps-4" style="width:50px;">#</th>
                        <th>Tim</th>
                        <th class="text-center">Main</th>
                        <th class="text-center">Menang</th>
                        <th class="text-center">Kalah</th>
                        <th class="text-center">Poin</th>
                        <th class="text-center">Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($standings as $i => $s)
                    <tr>
                        <td class="ps-4 fw-bold text-center">
                            @if($i === 0) 🥇
                            @elseif($i === 1) 🥈
                            @elseif($i === 2) 🥉
                            @else {{ $i + 1 }}
                            @endif
                        </td>
                        <td class="fw-semibold">{{ $s->team->name }}</td>
                        <td class="text-center">{{ $s->played }}</td>
                        <td class="text-center text-success fw-semibold">{{ $s->wins }}</td>
                        <td class="text-center text-danger">{{ $s->losses }}</td>
                        <td class="text-center">
                            <span class="badge rounded-pill px-3 py-2" style="background:#0f2b5b; font-size:.9rem;">
                                {{ $s->points }}
                            </span>
                        </td>
                        <td class="text-center">
                            <div class="d-flex gap-1 justify-content-center">
                                <a href="{{ route('manajemen.standings.edit', $s) }}"
                                   class="btn btn-sm btn-outline-primary" title="Edit">
                                    <i class="bi bi-pencil"></i>
                                </a>
                                <form action="{{ route('manajemen.standings.destroy', $s) }}" method="POST"
                                      onsubmit="return confirm('Hapus data klasemen {{ $s->team->name }}?')">
                                    @csrf @method('DELETE')
                                    <button class="btn btn-sm btn-outline-danger" title="Hapus">
                                        <i class="bi bi-trash"></i>
                                    </button>
                                </form>
                            </div>
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
        @endif
    </div>
</div>
@endsection
