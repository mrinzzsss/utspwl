<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Tournament extends Model
{
    use HasFactory;

    protected $fillable = [
        'nama',
        'logo',
        'format',
        'status',
        'mulai',
        'selesai',
    ];

    protected $casts = [
        'mulai'   => 'date',
        'selesai' => 'date',
    ];

    // ─── Relationships ───────────────────────────────────────────

    /** Semua match dalam tournament ini */
    public function matches(): HasMany
    {
        return $this->hasMany(Matchs::class, 'tournament_id');
    }

    /** Semua pemain yang terdaftar dalam tournament ini */
    public function players(): HasMany
    {
        return $this->hasMany(Player::class, 'tournament_id');
    }

    /** Klasemen tournament ini */
    public function standings(): HasMany
    {
        return $this->hasMany(Standing::class, 'tournament_id');
    }

    // ─── Scopes ──────────────────────────────────────────────────

    public function scopeOngoing($query)  { return $query->where('status', 'ongoing'); }
    public function scopeUpcoming($query) { return $query->where('status', 'upcoming'); }
    public function scopeFinished($query) { return $query->where('status', 'finished'); }
}
