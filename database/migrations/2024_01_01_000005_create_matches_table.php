<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('matches', function (Blueprint $table) {
            $table->id();

            // Dua relasi ke tabel teams (home & away)
            $table->foreignId('home_team_id')
                  ->constrained('teams')
                  ->cascadeOnDelete();

            $table->foreignId('away_team_id')
                  ->constrained('teams')
                  ->cascadeOnDelete();

            $table->unsignedTinyInteger('home_score')->nullable();
            $table->unsignedTinyInteger('away_score')->nullable();

            $table->enum('status', ['scheduled', 'ongoing', 'finished', 'cancelled'])
                  ->default('scheduled');

            $table->dateTime('match_date');
            $table->string('venue')->nullable();

            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('matches');
    }
};
