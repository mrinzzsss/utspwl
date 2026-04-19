@php $withSidebar = true; @endphp
@extends('layouts.app')
@section('title', 'Manajemen Tim')

@section('sidebar')
@include('components.sidebar-manajemen', ['active' => 'teams'])
@endsection

@section('content')
<div class="d-flex justify-content-between align-items-center mb-4">
    <div>
        <h4 class="fw-bold mb-0">Manajemen Tim</h4>
        <small class="text-muted">Kelola seluruh tim peserta MPL</small>
    </div>
    <a href="{{ route('manajemen.teams.create') }}" class="btn btn-primary">
        <i class="bi bi-plus-lg me-1"></i> Tambah Tim
    </a>
</div>

<div class="card">
    <div class="card-body p-0">
        @if($teams->isEmpty())
            <div class="text-center py-5 text-muted">
                <i class="bi bi-shield-x fs-1 d-block mb-2"></i>
                Belum ada data tim. <a href="{{ route('manajemen.teams.create') }}">Tambah sekarang</a>
            </div>
        @else
        <div class="table-responsive">
            <table class="table table-hover align-middle mb-0">
                <thead>
                    <tr>
                        <th class="ps-4">#</th>
                        <th>Nama Tim</th>
                        <th>Kota</th>
                        <th>Berdiri</th>
                        <th class="text-center">Pemain</th>
                        <th class="text-center">Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($teams as $i => $team)
                    <tr>
                        <td class="ps-4 text-muted">{{ $i + 1 }}</td>
                        <td>
                            <div class="d-flex align-items-center gap-2">
                                <div class="rounded-circle d-flex align-items-center justify-content-center text-white fw-bold"
                                     style="width:38px;height:38px;background:#0f2b5b;font-size:.85rem;flex-shrink:0;">
                                    {{ strtoupper(substr($team->name, 0, 2)) }}
                                </div>
                                <div>
                                    <div class="fw-semibold">{{ $team->name }}</div>
                                </div>
                            </div>
                        </td>
                        <td>{{ $team->city ?? '—' }}</td>
                        <td>{{ $team->founded_year ?? '—' }}</td>
                        <td class="text-center">
                            <span class="badge bg-primary rounded-pill">{{ $team->players->count() }} pemain</span>
                        </td>
                        <td class="text-center">
                            <div class="d-flex gap-1 justify-content-center">
                                <a href="{{ route('manajemen.teams.show', $team) }}"
                                   class="btn btn-sm btn-outline-secondary" title="Detail">
                                    <i class="bi bi-eye"></i>
                                </a>
                                <a href="{{ route('manajemen.teams.edit', $team) }}"
                                   class="btn btn-sm btn-outline-primary" title="Edit">
                                    <i class="bi bi-pencil"></i>
                                </a>
                                <form action="{{ route('manajemen.teams.destroy', $team) }}" method="POST"
                                      onsubmit="return confirm('Hapus tim {{ $team->name }}? Semua pemain akan ikut terhapus.')">
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
