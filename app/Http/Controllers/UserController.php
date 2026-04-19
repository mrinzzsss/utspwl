<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Player;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class UserController extends Controller
{
    public function index()
    {
        $this->authorizeRole('manajemen');
        $users = User::with('player.team')
            ->select('id', 'name', 'email', 'role', 'player_id', 'created_at')
            ->get();
        return view('manajemen.users.index', compact('users'));
    }

    public function create()
    {
        $this->authorizeRole('manajemen');
        $players = Player::with('team')->whereDoesntHave('user')->get();
        return view('manajemen.users.create', compact('players'));
    }

    public function store(Request $request)
    {
        $this->authorizeRole('manajemen');

        $validated = $request->validate([
            'name'      => 'required|string',
            'email'     => 'required|email|unique:users',
            'password'  => 'required|string|min:8|confirmed',
            'role'      => 'required|in:manajemen,wasit,player',
            'player_id' => 'nullable|exists:players,id',
        ]);

        if ($validated['role'] !== 'player') {
            $validated['player_id'] = null;
        }
        $validated['password'] = Hash::make($validated['password']);

        User::create($validated);
        return redirect()->route('manajemen.users.index')
            ->with('success', 'User berhasil ditambahkan.');
    }

    public function show(User $user)
    {
        $this->authorizeRole('manajemen');
        $user->load('player.team');
        return view('manajemen.users.show', compact('user'));
    }

    public function edit(User $user)
    {
        $this->authorizeRole('manajemen');
        $players = Player::with('team')
            ->where(fn($q) => $q->whereDoesntHave('user')->orWhere('id', $user->player_id))
            ->get();
        return view('manajemen.users.edit', compact('user', 'players'));
    }

    public function update(Request $request, User $user)
    {
        $this->authorizeRole('manajemen');

        $validated = $request->validate([
            'name'      => 'sometimes|string',
            'email'     => 'sometimes|email|unique:users,email,' . $user->id,
            'password'  => 'nullable|string|min:8|confirmed',
            'role'      => 'sometimes|in:manajemen,wasit,player',
            'player_id' => 'nullable|exists:players,id',
        ]);

        if (isset($validated['password']) && $validated['password']) {
            $validated['password'] = Hash::make($validated['password']);
        } else {
            unset($validated['password']);
        }

        $user->update($validated);
        return redirect()->route('manajemen.users.index')
            ->with('success', 'User berhasil diperbarui.');
    }

    public function destroy(User $user)
    {
        $this->authorizeRole('manajemen');
        abort_if($user->id === auth()->id(), 422, 'Tidak bisa menghapus akun sendiri');
        $user->delete();
        return redirect()->route('manajemen.users.index')
            ->with('success', 'User berhasil dihapus.');
    }

    private function authorizeRole(string $role): void
    {
        abort_if(auth()->user()->role !== $role, 403, 'Akses ditolak');
    }
}
