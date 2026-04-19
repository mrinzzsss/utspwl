@php $withSidebar = true; @endphp
@extends('layouts.app')
@section('title', 'Pertandingan')

@section('sidebar')
@include('components.sidebar-manajemen', ['active' => 'matches'])
@endsection

@section('content')
<div class="d-flex justify-content-between align-items-center mb-4">
    <div>
        <h4 class="fw-bold mb-0">Pertandingan</h4>
        <small class="text-muted">Jadwal & hasil semua pertandingan</small>
    </div>
    <a href="{{ route('manajemen.matches.create') }}" class="btn btn-primary">
        <i class="bi bi-plus-lg me-1"></i> Tambah Jadwal
    </a>
</div>

{{-- Filter status --}}
<form method="GET" class="mb-3">
    <div class="d-flex gap-2 flex-wrap">
        @foreach(['' => 'Semua', 'scheduled' => 'Terjadwal', 'ongoing' => 'Berlangsung', 'finished' => 'Selesai', 'cancelled' => 'Dibatalkan'] as $val => $label)
        <a href="{{ route('manajemen.matches.index', $val ? ['status' => $val] : []) }}"
           class="btn btn-sm {{ request('status', '') === $val ? 'btn-primary' : 'btn-outline-secondary' }}">
            {{ $label }}
        </a>
        @endforeach
    </div>
</form>

<div class="card">
    <div class="card-body p-0">
        @if($matches->isEmpty())
            <div class="text-center py-5 text-muted">
                <i class="bi bi-calendar-x fs-1 d-block mb-2"></i>
                Tidak ada pertandingan.
            </div>
        @else
        <div class="table-responsive">
            <table class="table table-hover align-middle mb-0">
                <thead>
                    <tr>
                        <th class="ps-4">Tanggal</th>
                        <th>Home</th>
                        <th class="text-center">Skor</th>
                        <th>Away</th>
                        <th>Venue</th>
                        <th class="text-center">Status</th>
                        <th class="text-center">Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($matches as $match)
                    <tr>
                        <td class="ps-4 text-muted small">
                            {{ $match->match_date->format('d M Y') }}<br>
                            <span>{{ $match->match_date->format('H:i') }} WIB</span>
                        </td>
                        <td class="fw-semibold {{ $match->status === 'finished' && $match->home_score > $match->away_score ? 'text-success' : '' }}">
                            {{ $match->homeTeam->name }}
                        </td>
                        <td class="text-center fw-bold fs-5">
                            @if($match->status === 'finished')
                                {{ $match->home_score }} – {{ $match->away_score }}
                            @else
                                <span class="text-muted">vs</span>
                            @endif
                        </td>
                        <td class="fw-semibold {{ $match->status === 'finished' && $match->away_score > $match->home_score ? 'text-success' : '' }}">
                            {{ $match->awayTeam->name }}
                        </td>
                        <td class="text-muted small">{{ $match->venue ?? '—' }}</td>
                        <td class="text-center">
                            @php
                                $badge = match($match->status) {
                                    'scheduled'  => 'bg-secondary',
                                    'ongoing'    => 'bg-warning text-dark',
                                    'finished'   => 'bg-success',
                                    'cancelled'  => 'bg-danger',
                                    default      => 'bg-secondary',
                                };
                            @endphp
                            <span class="badge {{ $badge }}">{{ ucfirst($match->status) }}</span>
                        </td>
                        <td class="text-center">
                            <div class="d-flex gap-1 justify-content-center">
                                <a href="{{ route('manajemen.matches.edit', $match) }}"
                                   class="btn btn-sm btn-outline-primary" title="Edit">
                                    <i class="bi bi-pencil"></i>
                                </a>
                                <form action="{{ route('manajemen.matches.destroy', $match) }}" method="POST"
                                      onsubmit="return confirm('Hapus pertandingan ini?')">
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
