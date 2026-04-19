<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

/**
 * GameMatch — menggantikan Match.php
 * Nama class "Match" adalah reserved keyword di PHP 8,
 * sehingga menyebabkan Parse Error. Gunakan GameMatch.
 * Tabel tetap menggunakan 'matches'.
 */
class GameMatch extends Model
{
    use HasFactory;

    // Tetap pakai tabel 'matches'
    protected $table = 'matches';

    protected $fillable = [
        'home_team_id',
        'away_team_id',
        'home_score',
        'away_score',
        'status',
        'match_date',
        'venue',
    ];

    protected $casts = [
        'match_date' => 'datetime',
    ];

    // ── Relasi ───────────────────────────────────

    public function homeTeam()
    {
        return $this->belongsTo(Team::class, 'home_team_id');
    }

    public function awayTeam()
    {
        return $this->belongsTo(Team::class, 'away_team_id');
    }

    // ── Scope ────────────────────────────────────

    public function scopeFinished($query)
    {
        return $query->where('status', 'finished');
    }

    public function scopeScheduled($query)
    {
        return $query->where('status', 'scheduled');
    }

    // ── Helper ───────────────────────────────────

    public function getWinner(): ?Team
    {
        if ($this->status !== 'finished') return null;

        if ($this->home_score > $this->away_score) return $this->homeTeam;
        if ($this->away_score > $this->home_score) return $this->awayTeam;

        return null; // draw
    }
}
