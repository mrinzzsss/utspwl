<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use App\Models\Tournament;
use App\Models\Player;
use App\Models\Matchs;
use App\Models\Standing;

class TournamentSeeder extends Seeder
{
    // Tim-tim dummy MPL style
    private array $teams = [
        'RRQ Hoshi'     => ['jungler'=>'Alberttt','roamer'=>'Psychoo','midlaner'=>'Lemon','goldlaner'=>'R7','explaner'=>'Antimage'],
        'ONIC Esports'  => ['jungler'=>'Butsss','roamer'=>'Sanz','midlaner'=>'Kairi','goldlaner'=>'Udil','explaner'=>'War'],
        'Alter Ego'     => ['jungler'=>'Celiboy','roamer'=>'Hadji','midlaner'=>'Kiboy','goldlaner'=>'Branz','explaner'=>'Ryzen'],
        'Aura Fire'     => ['jungler'=>'Demonkite','roamer'=>'Ino','midlaner'=>'Renbo','goldlaner'=>'Zux','explaner'=>'FlapTzy'],
        'Geek Fam'      => ['jungler'=>'Kelra','roamer'=>'Dlar','midlaner'=>'KarlTzy','goldlaner'=>'Hadess','explaner'=>'Oheb'],
        'Rebellion Zion'=> ['jungler'=>'Ferxiic','roamer'=>'Renejay','midlaner'=>'Edto','goldlaner'=>'Ty','explaner'=>'Mckee'],
    ];

    public function run(): void
    {
        DB::statement('SET FOREIGN_KEY_CHECKS=0;');
        Standing::truncate();
        Matchs::truncate();
        Player::truncate();
        Tournament::truncate();
        DB::statement('SET FOREIGN_KEY_CHECKS=1;');

        // ── Tournament 1: Season Ongoing (Round Robin) ────────────
        $t1 = Tournament::create([
            'nama'    => 'MPL PWL Season 15',
            'format'  => 'round_robin',
            'status'  => 'ongoing',
            'mulai'   => '2026-03-01',
            'selesai' => '2026-05-30',
        ]);
        $this->seedPlayers($t1->id);
        $this->seedMatches($t1, 'ongoing');

        // ── Tournament 2: Upcoming (Single Elimination) ───────────
        $t2 = Tournament::create([
            'nama'    => 'MPL PWL Playoff S15',
            'format'  => 'single_elimination',
            'status'  => 'upcoming',
            'mulai'   => '2026-06-01',
            'selesai' => '2026-06-15',
        ]);
        $this->seedPlayers($t2->id);

        // ── Tournament 3: Finished ────────────────────────────────
        $t3 = Tournament::create([
            'nama'    => 'MPL PWL Season 14',
            'format'  => 'round_robin',
            'status'  => 'finished',
            'mulai'   => '2025-09-01',
            'selesai' => '2025-12-20',
        ]);
        $this->seedPlayers($t3->id);
        $this->seedMatches($t3, 'finished');

        $this->command->info('✅ Tournaments, players, matches, standings seeded!');
    }

    private function seedPlayers(int $tournamentId): void
    {
        $realNames = [
            'Alberttt' => 'Albert Timotius',    'Psychoo'  => 'Rizky Faidan',
            'Lemon'    => 'Enriko Dewangga',    'R7'       => 'Rivaldy Ramadhan',
            'Antimage' => 'Andika Saputra',     'Butsss'   => 'Rivaldy Putra',
            'Sanz'     => 'Sanzio Putra',       'Kairi'    => 'Muhammad Kairi',
            'Udil'     => 'Muhammad Udil',      'War'      => 'Warlito Bangko',
            'Celiboy'  => 'Firman Firgiawan',   'Hadji'    => 'Hadji Munandar',
            'Kiboy'    => 'Kiboy Rivaldi',      'Branz'    => 'Brandon Jawato',
            'Ryzen'    => 'Rizky Ananda',       'Demonkite'=> 'Alfi Ramadhan',
            'Ino'      => 'Inocent Senjaya',    'Renbo'    => 'Renzo Buana',
            'Zux'      => 'Rizal Firmansyah',   'FlapTzy'  => 'Ferhat Kücüksarı',
            'Kelra'    => 'Kelvin Rasugue',     'Dlar'     => 'Dlar Diodata',
            'KarlTzy'  => 'Karl Nepomuceno',    'Hadess'   => 'Hadess Navarro',
            'Oheb'     => 'Stephen Oheb',       'Ferxiic'  => 'Ferxiic Reyes',
            'Renejay'  => 'Renejay Adriano',    'Edto'     => 'Edtooo Abidin',
            'Ty'       => 'Ty Hernandez',       'Mckee'    => 'McKee Reyes',
        ];

        foreach ($this->teams as $tim => $roles) {
            foreach ($roles as $role => $ign) {
                Player::create([
                    'tournament_id' => $tournamentId,
                    'nama_tim'      => $tim,
                    'ign'           => $ign . '_T' . $tournamentId,
                    'nama_asli'     => $realNames[$ign] ?? $ign,
                    'role_game'     => $role,
                ]);
            }
        }
    }

    private function seedMatches(Tournament $tournament, string $type): void
    {
        $teamNames = array_keys($this->teams);
        $matchDefs = [
            ['RRQ Hoshi', 'ONIC Esports'],
            ['Alter Ego', 'Aura Fire'],
            ['Geek Fam', 'Rebellion Zion'],
            ['RRQ Hoshi', 'Alter Ego'],
            ['ONIC Esports', 'Geek Fam'],
            ['Aura Fire', 'Rebellion Zion'],
            ['RRQ Hoshi', 'Geek Fam'],
            ['ONIC Esports', 'Rebellion Zion'],
        ];

        $results = [
            [3,0], [2,1], [1,2], [3,1],
            [2,2], [3,2], [1,3], [2,0],
        ];

        $baseDate = $type === 'finished'
            ? now()->subMonths(3)
            : now()->subDays(5);

        foreach ($matchDefs as $i => [$timA, $timB]) {
            $isSelesai = $type === 'finished' || $i < 5;
            $jadwal    = $baseDate->copy()->addDays($i * 3)->setHour(19)->setMinute(0);

            // Cari MVP player dari tim pemenang
            $mvpPlayer = null;
            if ($isSelesai) {
                [$sA, $sB] = $results[$i];
                $winnerTim  = $sA > $sB ? $timA : ($sB > $sA ? $timB : null);
                if ($winnerTim) {
                    $mvpPlayer = Player::where('tournament_id', $tournament->id)
                        ->where('nama_tim', $winnerTim)
                        ->inRandomOrder()
                        ->first();
                }
            }

            $match = Matchs::create([
                'tournament_id'  => $tournament->id,
                'tim_a'          => $timA,
                'tim_b'          => $timB,
                'skor_a'         => $isSelesai ? $results[$i][0] : 0,
                'skor_b'         => $isSelesai ? $results[$i][1] : 0,
                'mvp_id'         => $mvpPlayer?->id,
                'jadwal_tanding' => $isSelesai ? $jadwal : $baseDate->copy()->addDays(($i + 6) * 3)->setHour(19),
                'status'         => $isSelesai ? 'selesai' : 'pending',
            ]);

            // Update standings untuk match selesai
            if ($isSelesai && $match->pemenang && $match->pemenang !== 'Draw') {
                $this->updateStandings($match);
            }
        }
    }

    private function updateStandings(Matchs $match): void
    {
        $pemenang = $match->pemenang;
        $kalah    = $pemenang === $match->tim_a ? $match->tim_b : $match->tim_a;

        // Menang
        $s = Standing::firstOrCreate(
            ['tournament_id' => $match->tournament_id, 'nama_tim' => $pemenang],
            ['menang' => 0, 'kalah' => 0, 'poin' => 0]
        );
        $s->increment('menang');
        $s->increment('poin', 2);

        // Kalah
        $s2 = Standing::firstOrCreate(
            ['tournament_id' => $match->tournament_id, 'nama_tim' => $kalah],
            ['menang' => 0, 'kalah' => 0, 'poin' => 0]
        );
        $s2->increment('kalah');
    }
}
