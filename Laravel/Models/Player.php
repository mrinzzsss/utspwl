<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Player extends Model
{
    use HasFactory;

    protected $fillable = [
        'tournament_id',
        'nama_tim',
        'logo_tim',
        'ign',
        'nama_asli',
        'role_game',
    ];

    // ─── Relationships ───────────────────────────────────────────

    /** Player ini ikut tournament mana */
    public function tournament(): BelongsTo
    {
        return $this->belongsTo(Tournament::class, 'tournament_id');
    }

    /** Match-match di mana player ini jadi MVP */
    public function mvpMatches(): HasMany
    {
        return $this->hasMany(Matchs::class, 'mvp_id');
    }
}
