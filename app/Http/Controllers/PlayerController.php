<?php

namespace App\Http\Controllers;

use App\Models\Player;
use App\Models\Team;
use Illuminate\Http\Request;

class PlayerController extends Controller
{
    public function index(Request $request)
    {
        $players = Player::with('team')
            ->when($request->team_id, fn($q) => $q->where('team_id', $request->team_id))
            ->get();
        $teams = Team::orderBy('name')->get();

        return view('manajemen.players.index', compact('players', 'teams'));
    }

    public function create()
    {
        $this->authorizeRole('manajemen');
        $teams = Team::orderBy('name')->get();
        return view('manajemen.players.create', compact('teams'));
    }

    public function store(Request $request)
    {
        $this->authorizeRole('manajemen');

        $validated = $request->validate([
            'team_id'     => 'required|exists:teams,id',
            'name'        => 'required|string',
            'role'        => 'nullable|in:EXP,MID,GOLD,ROAM,JUNGLE',
            'game_id'     => 'nullable|string',
            'nationality' => 'nullable|string|size:2',
            'birth_date'  => 'nullable|date',
        ]);

        Player::create($validated);
        return redirect()->route('manajemen.players.index')
            ->with('success', 'Pemain berhasil ditambahkan.');
    }

    public function show(Player $player)
    {
        $player->load('team');
        return view('manajemen.players.show', compact('player'));
    }

    public function edit(Player $player)
    {
        $this->authorizeRole('manajemen');
        $teams = Team::orderBy('name')->get();
        return view('manajemen.players.edit', compact('player', 'teams'));
    }

    public function update(Request $request, Player $player)
    {
        $this->authorizeRole('manajemen');

        $validated = $request->validate([
            'team_id'     => 'sometimes|exists:teams,id',
            'name'        => 'sometimes|string',
            'role'        => 'nullable|in:EXP,MID,GOLD,ROAM,JUNGLE',
            'game_id'     => 'nullable|string',
            'nationality' => 'nullable|string|size:2',
            'birth_date'  => 'nullable|date',
        ]);

        $player->update($validated);
        return redirect()->route('manajemen.players.index')
            ->with('success', 'Pemain berhasil diperbarui.');
    }

    public function destroy(Player $player)
    {
        $this->authorizeRole('manajemen');
        $player->delete();
        return redirect()->route('manajemen.players.index')
            ->with('success', 'Pemain berhasil dihapus.');
    }

    private function authorizeRole(string $role): void
    {
        abort_if(auth()->user()->role !== $role, 403, 'Akses ditolak');
    }
}
