<?php

namespace App\Http\Controllers;

use App\Models\GameMatch;
use App\Models\Team;
use Illuminate\Http\Request;

class MatchController extends Controller
{
    /**
     * FIX: index() sekarang mendeteksi role user dan return view yang tepat.
     * - manajemen → view('manajemen.matches.index')
     * - wasit     → view('wasit.matches')
     */
    public function index(Request $request)
    {
        $matches = GameMatch::with('homeTeam', 'awayTeam')
            ->when($request->status, fn($q) => $q->where('status', $request->status))
            ->orderBy('match_date')
            ->get();

        // FIX: Wasit dapat view wasit, manajemen dapat view manajemen
        $view = auth()->user()?->role === 'wasit'
            ? 'wasit.matches'
            : 'manajemen.matches.index';

        return view($view, compact('matches'));
    }

    public function create()
    {
        $this->authorizeRoles(['manajemen']);
        $teams = Team::orderBy('name')->get();
        return view('manajemen.matches.create', compact('teams'));
    }

    public function store(Request $request)
    {
        $this->authorizeRoles(['manajemen']);

        $validated = $request->validate([
            'home_team_id' => 'required|exists:teams,id|different:away_team_id',
            'away_team_id' => 'required|exists:teams,id',
            'match_date'   => 'required|date',
            'venue'        => 'nullable|string',
        ]);

        GameMatch::create($validated + ['status' => 'scheduled']);
        return redirect()->route('manajemen.matches.index')
            ->with('success', 'Pertandingan berhasil dijadwalkan.');
    }

    /**
     * FIX: show() juga deteksi role untuk view yang tepat
     */
    public function show(GameMatch $match)
    {
        $match->load('homeTeam', 'awayTeam');

        $view = auth()->user()?->role === 'wasit'
            ? 'wasit.match-show'
            : 'manajemen.matches.show';

        return view($view, compact('match'));
    }

    public function edit(GameMatch $match)
    {
        $this->authorizeRoles(['manajemen']);
        $teams = Team::orderBy('name')->get();
        return view('manajemen.matches.edit', compact('match', 'teams'));
    }

    public function update(Request $request, GameMatch $match)
    {
        $this->authorizeRoles(['manajemen']);

        $validated = $request->validate([
            'match_date' => 'sometimes|date',
            'venue'      => 'nullable|string',
            'status'     => 'sometimes|in:scheduled,ongoing,finished,cancelled',
        ]);

        $match->update($validated);
        return redirect()->route('manajemen.matches.index')
            ->with('success', 'Pertandingan berhasil diperbarui.');
    }

    public function destroy(GameMatch $match)
    {
        $this->authorizeRoles(['manajemen']);
        $match->delete();
        return redirect()->route('manajemen.matches.index')
            ->with('success', 'Pertandingan berhasil dihapus.');
    }

    // ── Wasit: input skor ────────────────────────

    public function inputScoreForm(GameMatch $match)
    {
        $this->authorizeRoles(['wasit']);
        abort_if($match->status === 'finished', 422, 'Match sudah selesai');
        $match->load('homeTeam', 'awayTeam');
        return view('wasit.input-score', compact('match'));
    }

    public function inputScore(Request $request, GameMatch $match)
    {
        $this->authorizeRoles(['wasit']);
        abort_if($match->status === 'finished', 422, 'Match sudah selesai');

        $validated = $request->validate([
            'home_score' => 'required|integer|min:0',
            'away_score' => 'required|integer|min:0',
        ]);

        $match->update([
            ...$validated,
            'status' => 'finished',
        ]);

        return redirect()->route('wasit.dashboard')
            ->with('success', 'Skor berhasil diinput.');
    }

    private function authorizeRoles(array $roles): void
    {
        abort_if(!in_array(auth()->user()->role, $roles), 403, 'Akses ditolak');
    }
}
