<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('players', function (Blueprint $table) {
            $table->id();
            $table->foreignId('team_id')
                  ->constrained('teams')
                  ->cascadeOnDelete();
            $table->string('name');
            $table->string('role')->nullable();          // e.g. EXP, MID, GOLD, ROAM, JUNGLE
            $table->string('game_id')->nullable();       // in-game username
            $table->string('nationality')->nullable();
            $table->date('birth_date')->nullable();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('players');
    }
};
