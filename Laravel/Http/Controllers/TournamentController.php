<?php

namespace App\Http\Controllers;

use App\Models\Tournament;
use App\Models\Standing;
use Illuminate\Http\Request;

class TournamentController extends Controller
{
    /** Daftar semua tournament */
    public function index()
    {
        $tournaments = Tournament::orderByDesc('mulai')->paginate(10);
        return view('pages.tournaments.index', compact('tournaments'));
    }

    /** Detail tournament: matches + standings + players */
    public function show(Tournament $tournament)
    {
        $matches = $tournament->matches()
            ->with('mvp')
            ->orderBy('jadwal_tanding')
            ->get();

        $standings = $tournament->standings()
            ->orderByDesc('poin')
            ->orderByDesc('menang')
            ->get();

        $players = $tournament->players()
            ->orderBy('nama_tim')
            ->get()
            ->groupBy('nama_tim'); // kelompokkan per tim

        return view('pages.tournaments.show', compact(
            'tournament',
            'matches',
            'standings',
            'players'
        ));
    }

    /** Form tambah tournament (admin only) */
    public function create()
    {
        return view('pages.tournaments.create');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'nama'   => 'required|string|max:255',
            'logo'   => 'nullable|image|max:2048',
            'format' => 'required|in:single_elimination,round_robin',
            'status' => 'required|in:upcoming,ongoing,finished',
            'mulai'  => 'required|date',
            'selesai'=> 'required|date|after_or_equal:mulai',
        ]);

        if ($request->hasFile('logo')) {
            $validated['logo'] = $request->file('logo')->store('logos/tournaments', 'public');
        }

        Tournament::create($validated);
        return redirect()->route('tournaments.index')->with('success', 'Tournament berhasil ditambahkan!');
    }

    public function edit(Tournament $tournament)
    {
        return view('pages.tournaments.edit', compact('tournament'));
    }

    public function update(Request $request, Tournament $tournament)
    {
        $validated = $request->validate([
            'nama'   => 'required|string|max:255',
            'logo'   => 'nullable|image|max:2048',
            'format' => 'required|in:single_elimination,round_robin',
            'status' => 'required|in:upcoming,ongoing,finished',
            'mulai'  => 'required|date',
            'selesai'=> 'required|date|after_or_equal:mulai',
        ]);

        if ($request->hasFile('logo')) {
            $validated['logo'] = $request->file('logo')->store('logos/tournaments', 'public');
        }

        $tournament->update($validated);
        return redirect()->route('tournaments.show', $tournament)->with('success', 'Tournament berhasil diupdate!');
    }

    public function destroy(Tournament $tournament)
    {
        $tournament->delete();
        return redirect()->route('tournaments.index')->with('success', 'Tournament berhasil dihapus!');
    }
}
