@php $withSidebar = true; @endphp
@extends('layouts.app')
@section('title', 'Detail User — ' . $user->name)

@section('sidebar')
@include('components.sidebar-manajemen', ['active' => 'users'])
@endsection

@section('content')
<div class="d-flex align-items-center gap-3 mb-4">
    <a href="{{ route('manajemen.users.index') }}" class="btn btn-sm btn-outline-secondary">
        <i class="bi bi-arrow-left"></i>
    </a>
    <div>
        <h4 class="fw-bold mb-0">{{ $user->name }}</h4>
        <small class="text-muted">{{ $user->email }}</small>
    </div>
    <a href="{{ route('manajemen.users.edit', $user) }}" class="btn btn-sm btn-outline-primary ms-auto">
        <i class="bi bi-pencil me-1"></i> Edit
    </a>
</div>

<div class="card" style="max-width:500px;">
    <div class="card-body">
        <table class="table table-borderless mb-0">
            <tr><td class="text-muted" style="width:140px;">Nama</td><td class="fw-semibold">{{ $user->name }}</td></tr>
            <tr><td class="text-muted">Email</td><td>{{ $user->email }}</td></tr>
            <tr><td class="text-muted">Role</td>
                <td>
                    @php
                        $badge = match($user->role) {
                            'manajemen' => 'bg-primary',
                            'wasit'     => 'bg-success',
                            'player'    => 'bg-warning text-dark',
                            default     => 'bg-secondary',
                        };
                    @endphp
                    <span class="badge {{ $badge }}">{{ ucfirst($user->role) }}</span>
                </td>
            </tr>
            @if($user->player)
            <tr><td class="text-muted">Player</td><td>{{ $user->player->name }}</td></tr>
            <tr><td class="text-muted">Tim</td><td>{{ $user->player->team->name ?? '—' }}</td></tr>
            @endif
            <tr><td class="text-muted">Bergabung</td><td>{{ $user->created_at->format('d M Y') }}</td></tr>
        </table>
    </div>
</div>
@endsection
