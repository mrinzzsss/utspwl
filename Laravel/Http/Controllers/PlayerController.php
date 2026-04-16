<?php

namespace App\Http\Controllers;

use App\Models\Player;
use App\Models\Tournament;
use Illuminate\Http\Request;

class PlayerController extends Controller
{
    public function create(Tournament $tournament)
    {
        return view('pages.players.create', compact('tournament'));
    }

    public function store(Request $request, Tournament $tournament)
    {
        $validated = $request->validate([
            'nama_tim'  => 'required|string|max:255',
            'logo_tim'  => 'nullable|image|max:2048',
            'ign'       => 'required|string|max:255|unique:players,ign',
            'nama_asli' => 'required|string|max:255',
            'role_game' => 'required|in:jungler,roamer,midlaner,goldlaner,explaner',
        ]);

        if ($request->hasFile('logo_tim')) {
            $validated['logo_tim'] = $request->file('logo_tim')->store('logos/teams', 'public');
        }

        $validated['tournament_id'] = $tournament->id;
        Player::create($validated);

        return redirect()->route('tournaments.show', $tournament)->with('success', 'Pemain berhasil ditambahkan!');
    }

    public function edit(Player $player)
    {
        return view('pages.players.edit', compact('player'));
    }

    public function update(Request $request, Player $player)
    {
        $validated = $request->validate([
            'nama_tim'  => 'required|string|max:255',
            'logo_tim'  => 'nullable|image|max:2048',
            'ign'       => 'required|string|max:255|unique:players,ign,' . $player->id,
            'nama_asli' => 'required|string|max:255',
            'role_game' => 'required|in:jungler,roamer,midlaner,goldlaner,explaner',
        ]);

        if ($request->hasFile('logo_tim')) {
            $validated['logo_tim'] = $request->file('logo_tim')->store('logos/teams', 'public');
        }

        $player->update($validated);
        return redirect()->route('tournaments.show', $player->tournament_id)->with('success', 'Pemain berhasil diupdate!');
    }

    public function destroy(Player $player)
    {
        $tournamentId = $player->tournament_id;
        $player->delete();
        return redirect()->route('tournaments.show', $tournamentId)->with('success', 'Pemain berhasil dihapus!');
    }
}
