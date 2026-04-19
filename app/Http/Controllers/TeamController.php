<?php

namespace App\Http\Controllers;

use App\Models\Team;
use Illuminate\Http\Request;

class TeamController extends Controller
{
    public function index()
    {
        $teams = Team::with('players', 'standing')->get();
        return view('manajemen.teams.index', compact('teams'));
    }

    public function create()
    {
        $this->authorizeRole('manajemen');
        return view('manajemen.teams.create');
    }

    public function store(Request $request)
    {
        $this->authorizeRole('manajemen');

        $validated = $request->validate([
            'name'         => 'required|string|unique:teams',
            'logo'         => 'nullable|string',
            'city'         => 'nullable|string',
            'founded_year' => 'nullable|integer|min:1900|max:' . date('Y'),
        ]);

        Team::create($validated);
        return redirect()->route('manajemen.teams.index')
            ->with('success', 'Tim berhasil ditambahkan.');
    }

    public function show(Team $team)
    {
        $team->load('players', 'standing');
        return view('manajemen.teams.show', compact('team'));
    }

    public function edit(Team $team)
    {
        $this->authorizeRole('manajemen');
        return view('manajemen.teams.edit', compact('team'));
    }

    public function update(Request $request, Team $team)
    {
        $this->authorizeRole('manajemen');

        $validated = $request->validate([
            'name'         => 'sometimes|string|unique:teams,name,' . $team->id,
            'logo'         => 'nullable|string',
            'city'         => 'nullable|string',
            'founded_year' => 'nullable|integer|min:1900|max:' . date('Y'),
        ]);

        $team->update($validated);
        return redirect()->route('manajemen.teams.index')
            ->with('success', 'Tim berhasil diperbarui.');
    }

    public function destroy(Team $team)
    {
        $this->authorizeRole('manajemen');
        $team->delete();
        return redirect()->route('manajemen.teams.index')
            ->with('success', 'Tim berhasil dihapus.');
    }

    private function authorizeRole(string $role): void
    {
        abort_if(auth()->user()->role !== $role, 403, 'Akses ditolak');
    }
}
