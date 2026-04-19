<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Team extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'logo',
        'city',
        'founded_year',
    ];

    // ── Relasi ───────────────────────────────────

    public function players()
    {
        return $this->hasMany(Player::class);
    }

    public function standing()
    {
        return $this->hasOne(Standing::class);
    }

    /** Match sebagai tim tuan rumah */
    public function homeMatches()
    {
        // FIX: ganti Match::class → GameMatch::class
        return $this->hasMany(GameMatch::class, 'home_team_id');
    }

    /** Match sebagai tim tamu */
    public function awayMatches()
    {
        // FIX: ganti Match::class → GameMatch::class
        return $this->hasMany(GameMatch::class, 'away_team_id');
    }

    /** Semua match (home + away) — sebagai query builder */
    public function allMatches()
    {
        // FIX: ganti Match:: → GameMatch::
        return GameMatch::where('home_team_id', $this->id)
                        ->orWhere('away_team_id', $this->id);
    }
}
