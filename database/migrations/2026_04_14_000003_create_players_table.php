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
            $table->foreignId('tournament_id')->constrained('tournaments')->cascadeOnDelete();
            $table->string('nama_tim');           // nama tim langsung di player (tanpa tabel teams)
            $table->string('logo_tim')->nullable();
            $table->string('ign')->unique();      // in-game name
            $table->string('nama_asli');
            $table->enum('role_game', ['jungler', 'roamer', 'midlaner', 'goldlaner', 'explaner']);
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('players');
    }
};
