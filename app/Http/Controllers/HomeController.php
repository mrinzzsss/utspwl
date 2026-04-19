<?php

namespace App\Http\Controllers;

use App\Models\GameMatch;
use App\Models\Standing;
use App\Models\Team;

class HomeController extends Controller
{
    public function index()
    {
        $standings = Standing::with('team')->season(date('Y'))->take(6)->get();
        $recentMatches = GameMatch::with('homeTeam', 'awayTeam')
            ->where('status', 'finished')
            ->orderByDesc('match_date')
            ->take(5)
            ->get();
        $upcomingMatches = GameMatch::with('homeTeam', 'awayTeam')
            ->where('status', 'scheduled')
            ->orderBy('match_date')
            ->take(5)
            ->get();

        return view('home', compact('standings', 'recentMatches', 'upcomingMatches'));
    }

    public function manajemenDashboard()
    {
        $totalTeams   = Team::count();
        $totalMatches = GameMatch::count();
        $upcoming     = GameMatch::where('status', 'scheduled')->count();
        $finished     = GameMatch::where('status', 'finished')->count();

        return view('dashboard.manajemen', compact('totalTeams', 'totalMatches', 'upcoming', 'finished'));
    }

    public function wasitDashboard()
    {
        $pendingMatches = GameMatch::with('homeTeam', 'awayTeam')
            ->whereIn('status', ['scheduled', 'ongoing'])
            ->orderBy('match_date')
            ->get();
        $recentScored = GameMatch::with('homeTeam', 'awayTeam')
            ->where('status', 'finished')
            ->orderByDesc('updated_at')
            ->take(5)
            ->get();

        return view('dashboard.wasit', compact('pendingMatches', 'recentScored'));
    }
}
