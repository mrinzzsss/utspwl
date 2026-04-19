<?php

namespace App\Http\Controllers;

use App\Models\Standing;
use App\Models\Team;
use Illuminate\Http\Request;

class StandingController extends Controller
{
    public function index(Request $request)
    {
        $season = $request->season ?? date('Y');
        $standings = Standing::with('team')->season($season)->get();
        $seasons = Standing::select('season')->distinct()->orderByDesc('season')->pluck('season');
        return view('manajemen.standings.index', compact('standings', 'season', 'seasons'));
    }

    public function create()
    {
        $this->authorizeRole('manajemen');
        $teams = Team::orderBy('name')->get();
        return view('manajemen.standings.create', compact('teams'));
    }

    public function store(Request $request)
    {
        $this->authorizeRole('manajemen');

        $validated = $request->validate([
            'team_id' => 'required|exists:teams,id',
            'season'  => 'required|integer',
            'played'  => 'required|integer|min:0',
            'wins'    => 'required|integer|min:0',
            'losses'  => 'required|integer|min:0',
            'points'  => 'required|integer|min:0',
        ]);

        Standing::updateOrCreate(
            ['team_id' => $validated['team_id'], 'season' => $validated['season']],
            $validated
        );

        return redirect()->route('manajemen.standings.index')
            ->with('success', 'Klasemen berhasil disimpan.');
    }

    public function edit(Standing $standing)
    {
        $this->authorizeRole('manajemen');
        $teams = Team::orderBy('name')->get();
        return view('manajemen.standings.edit', compact('standing', 'teams'));
    }

    public function update(Request $request, Standing $standing)
    {
        $this->authorizeRole('manajemen');

        $validated = $request->validate([
            'played'  => 'sometimes|integer|min:0',
            'wins'    => 'sometimes|integer|min:0',
            'losses'  => 'sometimes|integer|min:0',
            'points'  => 'sometimes|integer|min:0',
        ]);

        $standing->update($validated);
        return redirect()->route('manajemen.standings.index')
            ->with('success', 'Klasemen berhasil diperbarui.');
    }

    public function destroy(Standing $standing)
    {
        $this->authorizeRole('manajemen');
        $standing->delete();
        return redirect()->route('manajemen.standings.index')
            ->with('success', 'Klasemen berhasil dihapus.');
    }

    private function authorizeRole(string $role): void
    {
        abort_if(auth()->user()->role !== $role, 403, 'Akses ditolak');
    }
}
