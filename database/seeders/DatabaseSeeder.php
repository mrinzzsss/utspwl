<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use App\Models\User;
use App\Models\Team;
use App\Models\Player;
use App\Models\Standing;
use App\Models\GameMatch; // FIX: ganti dari App\Models\Match

class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        $currentYear = (int) date('Y'); // FIX: season mengikuti tahun saat ini

        // ──────────────────────────────────────────
        // 1. TEAMS
        // ──────────────────────────────────────────
        $teams = [
            ['name' => 'RRQ Hoshi',    'city' => 'Jakarta',  'founded_year' => 2015],
            ['name' => 'EVOS Legends', 'city' => 'Jakarta',  'founded_year' => 2016],
            ['name' => 'Alter Ego',    'city' => 'Bandung',  'founded_year' => 2018],
            ['name' => 'ONIC Esports', 'city' => 'Jakarta',  'founded_year' => 2018],
            ['name' => 'Aura Fire',    'city' => 'Surabaya', 'founded_year' => 2019],
            ['name' => 'Geek Fam',     'city' => 'Medan',    'founded_year' => 2019],
        ];

        foreach ($teams as $data) {
            Team::create($data);
        }

        // ──────────────────────────────────────────
        // 2. PLAYERS (per team, 5 role MLBB)
        // ──────────────────────────────────────────
        $roles = ['EXP', 'MID', 'GOLD', 'ROAM', 'JUNGLE'];

        $playerData = [
            'RRQ Hoshi' => [
                ['name' => 'R7',     'game_id' => 'R7',     'nationality' => 'ID'],
                ['name' => 'Lemon',  'game_id' => 'Lemon',  'nationality' => 'ID'],
                ['name' => 'Skylar', 'game_id' => 'Skylar', 'nationality' => 'ID'],
                ['name' => 'Onic.F', 'game_id' => 'OnicF',  'nationality' => 'ID'],
                ['name' => 'Zxuan',  'game_id' => 'Zxuan',  'nationality' => 'ID'],
            ],
            'EVOS Legends' => [
                ['name' => 'Luminaire', 'game_id' => 'Lumin', 'nationality' => 'ID'],
                ['name' => 'Antimage',  'game_id' => 'Anti',  'nationality' => 'ID'],
                ['name' => 'Rekt',      'game_id' => 'Rekt',  'nationality' => 'ID'],
                ['name' => 'Clover',    'game_id' => 'Clov',  'nationality' => 'ID'],
                ['name' => 'Oura',      'game_id' => 'Oura',  'nationality' => 'ID'],
            ],
            'Alter Ego' => [
                ['name' => 'Hadess',  'game_id' => 'Hadess', 'nationality' => 'ID'],
                ['name' => 'Celiboy', 'game_id' => 'Celi',   'nationality' => 'ID'],
                ['name' => 'Kiboy',   'game_id' => 'Kiboy',  'nationality' => 'ID'],
                ['name' => 'Bal',     'game_id' => 'Bal',    'nationality' => 'ID'],
                ['name' => 'Wann',    'game_id' => 'Wann',   'nationality' => 'ID'],
            ],
            'ONIC Esports' => [
                ['name' => 'Butsss', 'game_id' => 'Butsss', 'nationality' => 'ID'],
                ['name' => 'Sanz',   'game_id' => 'Sanz',   'nationality' => 'ID'],
                ['name' => 'Kairi',  'game_id' => 'Kairi',  'nationality' => 'PH'],
                ['name' => 'Drian',  'game_id' => 'Drian',  'nationality' => 'ID'],
                ['name' => 'Xavier', 'game_id' => 'Xavier', 'nationality' => 'ID'],
            ],
            'Aura Fire' => [
                ['name' => 'Dewa',  'game_id' => 'Dewa',  'nationality' => 'ID'],
                ['name' => 'Branz', 'game_id' => 'Branz', 'nationality' => 'ID'],
                ['name' => 'Seth',  'game_id' => 'Seth',  'nationality' => 'ID'],
                ['name' => 'Rexxy', 'game_id' => 'Rexxy', 'nationality' => 'ID'],
                ['name' => 'Fredo', 'game_id' => 'Fredo', 'nationality' => 'ID'],
            ],
            'Geek Fam' => [
                ['name' => 'Solid', 'game_id' => 'Solid', 'nationality' => 'ID'],
                ['name' => 'Momo',  'game_id' => 'Momo',  'nationality' => 'ID'],
                ['name' => 'Nana',  'game_id' => 'Nana',  'nationality' => 'ID'],
                ['name' => 'Panda', 'game_id' => 'Panda', 'nationality' => 'MY'],
                ['name' => 'Lion',  'game_id' => 'Lion',  'nationality' => 'MY'],
            ],
        ];

        $allPlayers = [];

        foreach ($playerData as $teamName => $players) {
            $team = Team::where('name', $teamName)->first();
            foreach ($players as $i => $p) {
                $player = Player::create([
                    'team_id'     => $team->id,
                    'name'        => $p['name'],
                    'role'        => $roles[$i],
                    'game_id'     => $p['game_id'],
                    'nationality' => $p['nationality'],
                    'birth_date'  => now()->subYears(rand(18, 26))->subDays(rand(0, 365)),
                ]);
                $allPlayers[] = $player;
            }
        }

        // ──────────────────────────────────────────
        // 3. STANDINGS (FIX: season = tahun sekarang)
        // ──────────────────────────────────────────
        $standingsData = [
            'RRQ Hoshi'    => ['played' => 14, 'wins' => 10, 'losses' => 4,  'points' => 30],
            'ONIC Esports' => ['played' => 14, 'wins' => 9,  'losses' => 5,  'points' => 27],
            'EVOS Legends' => ['played' => 14, 'wins' => 8,  'losses' => 6,  'points' => 24],
            'Alter Ego'    => ['played' => 14, 'wins' => 7,  'losses' => 7,  'points' => 21],
            'Aura Fire'    => ['played' => 14, 'wins' => 5,  'losses' => 9,  'points' => 15],
            'Geek Fam'     => ['played' => 14, 'wins' => 3,  'losses' => 11, 'points' => 9],
        ];

        foreach ($standingsData as $teamName => $stat) {
            $team = Team::where('name', $teamName)->first();
            Standing::create([
                'team_id' => $team->id,
                'season'  => $currentYear, // FIX: pakai tahun sekarang
                ...$stat,
            ]);
        }

        // ──────────────────────────────────────────
        // 4. MATCHES (FIX: pakai GameMatch, tanggal menyesuaikan tahun ini)
        // ──────────────────────────────────────────
        $matchList = [
            ['RRQ Hoshi',    'EVOS Legends', 3,    1,    'finished',  "$currentYear-03-01 19:00:00", 'Jakarta Studio'],
            ['ONIC Esports', 'Alter Ego',    2,    0,    'finished',  "$currentYear-03-02 19:00:00", 'Jakarta Studio'],
            ['Aura Fire',    'Geek Fam',     1,    2,    'finished',  "$currentYear-03-03 19:00:00", 'Surabaya Arena'],
            ['RRQ Hoshi',    'ONIC Esports', 3,    2,    'finished',  "$currentYear-03-08 19:00:00", 'Jakarta Studio'],
            ['EVOS Legends', 'Aura Fire',    3,    0,    'finished',  "$currentYear-03-09 19:00:00", 'Jakarta Studio'],
            ['Alter Ego',    'Geek Fam',     2,    1,    'finished',  "$currentYear-03-10 19:00:00", 'Bandung Arena'],
            ['RRQ Hoshi',    'Alter Ego',    null, null, 'scheduled', "$currentYear-12-05 19:00:00", 'Jakarta Studio'],
            ['ONIC Esports', 'Geek Fam',     null, null, 'scheduled', "$currentYear-12-06 19:00:00", 'Jakarta Studio'],
        ];

        foreach ($matchList as $m) {
            GameMatch::create([ // FIX: ganti Match:: → GameMatch::
                'home_team_id' => Team::where('name', $m[0])->value('id'),
                'away_team_id' => Team::where('name', $m[1])->value('id'),
                'home_score'   => $m[2],
                'away_score'   => $m[3],
                'status'       => $m[4],
                'match_date'   => $m[5],
                'venue'        => $m[6],
            ]);
        }

        // ──────────────────────────────────────────
        // 5. USERS (3 role)
        // ──────────────────────────────────────────

        // Manajemen
        User::create([
            'name'      => 'Admin Manajemen',
            'email'     => 'manajemen@mpl.id',
            'password'  => Hash::make('123'),
            'role'      => 'manajemen',
            'player_id' => null,
        ]);

        // Wasit
        User::create([
            'name'      => 'Wasit Satu',
            'email'     => 'wasit1@mpl.id',
            'password'  => Hash::make('password'),
            'role'      => 'wasit',
            'player_id' => null,
        ]);

        User::create([
            'name'      => 'Wasit Dua',
            'email'     => 'wasit2@mpl.id',
            'password'  => Hash::make('password'),
            'role'      => 'wasit',
            'player_id' => null,
        ]);

        // Players (tautkan ke beberapa player yang sudah dibuat)
        $linkedPlayers = Player::take(5)->get();
        foreach ($linkedPlayers as $player) {
            User::create([
                'name'      => $player->name,
                'email'     => strtolower($player->game_id) . '@mpl.id',
                'password'  => Hash::make('password'),
                'role'      => 'player',
                'player_id' => $player->id,
            ]);
        }
    }
}
