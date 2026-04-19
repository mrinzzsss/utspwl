<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('standings', function (Blueprint $table) {
            $table->id();
            $table->foreignId('team_id')
                  ->constrained('teams')
                  ->cascadeOnDelete();
            $table->unsignedSmallInteger('season');      // e.g. 2024
            $table->unsignedTinyInteger('played')->default(0);
            $table->unsignedTinyInteger('wins')->default(0);
            $table->unsignedTinyInteger('losses')->default(0);
            $table->unsignedSmallInteger('points')->default(0);

            $table->timestamps();

            // Satu tim hanya punya satu baris klasemen per season
            $table->unique(['team_id', 'season']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('standings');
    }
};
