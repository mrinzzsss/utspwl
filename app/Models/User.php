<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable
{
    use HasFactory, Notifiable;

    protected $fillable = [
        'name',
        'email',
        'password',
        'role',
        'player_id',
    ];

    protected $hidden = [
        'password',
        'remember_token',
    ];

    protected function casts(): array
    {
        return [
            'password' => 'hashed',
        ];
    }

    // ── Role helpers ─────────────────────────────

    public function isManajemen(): bool
    {
        return $this->role === 'manajemen';
    }

    public function isWasit(): bool
    {
        return $this->role === 'wasit';
    }

    public function isPlayer(): bool
    {
        return $this->role === 'player';
    }

    // ── Relasi ───────────────────────────────────

    /** User dengan role player ditautkan ke data pemain */
    public function player()
    {
        return $this->belongsTo(Player::class);
    }
}
