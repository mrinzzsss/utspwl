<?php

namespace App\Http\Controllers;

use App\Models\Matchs;
use App\Models\Tournament;
use App\Models\Player;
use App\Models\Standing;
use Illuminate\Http\Request;

class MatchController extends Controller
{
    public function create(Tournament $tournament)
    {
        $players = $tournament->players()->orderBy('nama_tim')->get();
        return view('pages.matches.create', compact('tournament', 'players'));
    }

    public function store(Request $request, Tournament $tournament)
    {
        $validated = $request->validate([
            'tim_a'          => 'required|string|max:255',
            'tim_b'          => 'required|string|max:255|different:tim_a',
            'jadwal_tanding' => 'required|date',
        ]);

        $validated['tournament_id'] = $tournament->id;
        $validated['status'] = 'pending';

        Matchs::create($validated);
        return redirect()->route('tournaments.show', $tournament)->with('success', 'Match berhasil dijadwalkan!');
    }

    /** Wasit input hasil match */
    public function editHasil(Matchs $match)
    {
        $players = $match->tournament->players()
            ->whereIn('nama_tim', [$match->tim_a, $match->tim_b])
            ->get();

        return view('pages.matches.hasil', compact('match', 'players'));
    }

    public function updateHasil(Request $request, Matchs $match)
    {
        $validated = $request->validate([
            'skor_a' => 'required|integer|min:0',
            'skor_b' => 'required|integer|min:0',
            'mvp_id' => 'nullable|exists:players,id',
        ]);

        $validated['status'] = 'selesai';
        $match->update($validated);

        // Update standings otomatis
        $this->updateStandings($match);

        return redirect()->route('tournaments.show', $match->tournament_id)
            ->with('success', 'Hasil match berhasil disimpan!');
    }

    public function destroy(Matchs $match)
    {
        $tournamentId = $match->tournament_id;
        $match->delete();
        return redirect()->route('tournaments.show', $tournamentId)->with('success', 'Match berhasil dihapus!');
    }

    /** Auto-update standings setelah hasil diinput */
    private function updateStandings(Matchs $match): void
    {
        $pemenang = $match->pemenang; // pakai accessor dari model
        if (!$pemenang || $pemenang === 'Draw') return;

        $kalah = ($pemenang === $match->tim_a) ? $match->tim_b : $match->tim_a;

        // Update tim menang
        Standing::updateOrCreate(
            ['tournament_id' => $match->tournament_id, 'nama_tim' => $pemenang],
            ['menang' => \DB::raw('menang + 1'), 'poin' => \DB::raw('poin + 2')]
        );

        // Update tim kalah
        Standing::updateOrCreate(
            ['tournament_id' => $match->tournament_id, 'nama_tim' => $kalah],
            ['kalah' => \DB::raw('kalah + 1')]
        );
    }
}
