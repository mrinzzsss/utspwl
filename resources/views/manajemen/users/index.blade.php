@php $withSidebar = true; @endphp
@extends('layouts.app')
@section('title', 'Manajemen Pengguna')

@section('sidebar')
@include('components.sidebar-manajemen', ['active' => 'users'])
@endsection

@section('content')
<div class="d-flex justify-content-between align-items-center mb-4">
    <div>
        <h4 class="fw-bold mb-0">Manajemen Pengguna</h4>
        <small class="text-muted">Kelola akun manajemen, wasit, dan pemain</small>
    </div>
    <a href="{{ route('manajemen.users.create') }}" class="btn btn-primary">
        <i class="bi bi-person-plus-fill me-1"></i> Tambah User
    </a>
</div>

<div class="card">
    <div class="card-body p-0">
        @if($users->isEmpty())
            <div class="text-center py-5 text-muted">
                <i class="bi bi-people fs-1 d-block mb-2"></i>Belum ada pengguna.
            </div>
        @else
        <div class="table-responsive">
            <table class="table table-hover align-middle mb-0">
                <thead>
                    <tr>
                        <th class="ps-4">#</th>
                        <th>Nama</th>
                        <th>Email</th>
                        <th class="text-center">Role</th>
                        <th>Tim / Player</th>
                        <th>Dibuat</th>
                        <th class="text-center">Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($users as $i => $user)
                    <tr>
                        <td class="ps-4 text-muted">{{ $i + 1 }}</td>
                        <td>
                            <div class="fw-semibold">{{ $user->name }}</div>
                            @if($user->id === auth()->id())
                                <span class="badge bg-warning text-dark small">Anda</span>
                            @endif
                        </td>
                        <td class="text-muted small">{{ $user->email }}</td>
                        <td class="text-center">
                            @php
                                $roleBadge = match($user->role) {
                                    'manajemen' => 'bg-primary',
                                    'wasit'     => 'bg-success',
                                    'player'    => 'bg-warning text-dark',
                                    default     => 'bg-secondary',
                                };
                            @endphp
                            <span class="badge {{ $roleBadge }} text-capitalize">{{ $user->role }}</span>
                        </td>
                        <td class="text-muted small">
                            @if($user->player)
                                {{ $user->player->name }}
                                <span class="text-muted">({{ $user->player->team->name ?? '—' }})</span>
                            @else
                                —
                            @endif
                        </td>
                        <td class="text-muted small">{{ $user->created_at->format('d M Y') }}</td>
                        <td class="text-center">
                            <div class="d-flex gap-1 justify-content-center">
                                <a href="{{ route('manajemen.users.edit', $user) }}"
                                   class="btn btn-sm btn-outline-primary" title="Edit">
                                    <i class="bi bi-pencil"></i>
                                </a>
                                @if($user->id !== auth()->id())
                                <form action="{{ route('manajemen.users.destroy', $user) }}" method="POST"
                                      onsubmit="return confirm('Hapus user {{ $user->name }}?')">
                                    @csrf @method('DELETE')
                                    <button class="btn btn-sm btn-outline-danger" title="Hapus">
                                        <i class="bi bi-trash"></i>
                                    </button>
                                </form>
                                @endif
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
