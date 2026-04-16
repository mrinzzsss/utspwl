<?php

namespace App\Http\Controllers;

use App\Models\Tournament;
use App\Models\Matchs;
use App\Models\Player;

class HomeController extends Controller
{
    public function index()
    {
        // Tournament yang sedang berjalan (untuk hero section)
        $tournamentAktif = Tournament::ongoing()->latest()->first();

        // Semua tournament untuk list
        $tournaments = Tournament::orderByDesc('mulai')->get();

        // 5 match terdekat yang belum selesai
        $jadwalTerdekat = Matchs::pending()
            ->with('tournament')
            ->orderBy('jadwal_tanding')
            ->limit(5)
            ->get();

        // 5 match terakhir yang sudah selesai
        $hasilTerakhir = Matchs::selesai()
            ->with(['tournament', 'mvp'])
            ->orderByDesc('jadwal_tanding')
            ->limit(5)
            ->get();

        return view('pages.home', compact(
            'tournamentAktif',
            'tournaments',
            'jadwalTerdekat',
            'hasilTerakhir'
        ));
    }
}
