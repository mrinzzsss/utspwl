<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Matchs extends Model
{
    use HasFactory;

    // 'matches' adalah nama tabel yang sudah benar di DB
    protected $table = 'matches';

    protected $fillable = [
        'tournament_id',
        'tim_a',
        'tim_b',
        'skor_a',
        'skor_b',
        'mvp_id',
        'jadwal_tanding',
        'status',
    ];

    protected $casts = [
        'jadwal_tanding' => 'datetime',
    ];

    // ─── Relationships ───────────────────────────────────────────

    /** Match ini milik tournament mana */
    public function tournament(): BelongsTo
    {
        return $this->belongsTo(Tournament::class, 'tournament_id');
    }

    /** Siapa MVP match ini */
    public function mvp(): BelongsTo
    {
        return $this->belongsTo(Player::class, 'mvp_id');
    }

    // ─── Helpers ─────────────────────────────────────────────────

    /** Ambil nama pemenang, null jika belum selesai */
    public function getPemenangAttribute(): ?string
    {
        if ($this->status !== 'selesai') return null;
        if ($this->skor_a > $this->skor_b) return $this->tim_a;
        if ($this->skor_b > $this->skor_a) return $this->tim_b;
        return 'Draw';
    }

    public function scopePending($query)  { return $query->where('status', 'pending'); }
    public function scopeSelesai($query)  { return $query->where('status', 'selesai'); }
}
