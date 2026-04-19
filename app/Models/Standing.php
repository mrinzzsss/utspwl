<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Standing extends Model
{
    use HasFactory;

    protected $fillable = [
        'team_id',
        'season',
        'played',
        'wins',
        'losses',
        'points',
    ];

    // ── Relasi ───────────────────────────────────

    public function team()
    {
        return $this->belongsTo(Team::class);
    }

    // ── Scope ────────────────────────────────────

    /** Ambil klasemen untuk season tertentu, diurutkan berdasarkan poin */
    public function scopeSeason($query, int $year)
    {
        return $query->where('season', $year)->orderByDesc('points');
    }
}
