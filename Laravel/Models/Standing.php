<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Standing extends Model
{
    use HasFactory;

    protected $fillable = [
        'tournament_id',
        'nama_tim',
        'logo_tim',
        'menang',
        'kalah',
        'poin',
    ];

    // ─── Relationships ───────────────────────────────────────────

    /** Standing ini milik tournament mana */
    public function tournament(): BelongsTo
    {
        return $this->belongsTo(Tournament::class, 'tournament_id');
    }
}
