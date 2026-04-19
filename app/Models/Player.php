<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Player extends Model
{
    use HasFactory;

    protected $fillable = [
        'team_id',
        'name',
        'role',
        'game_id',
        'nationality',
        'birth_date',
    ];

    protected $casts = [
        'birth_date' => 'date',
    ];

    // ── Relasi ───────────────────────────────────

    public function team()
    {
        return $this->belongsTo(Team::class);
    }

    public function user()
    {
        return $this->hasOne(User::class);
    }
}
