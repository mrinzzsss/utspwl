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
            $table->foreignId('tournament_id')->constrained('tournaments')->cascadeOnDelete();
            $table->string('nama_tim');           // nama tim langsung (konsisten dengan matches)
            $table->string('logo_tim')->nullable();
            $table->unsignedSmallInteger('menang')->default(0);
            $table->unsignedSmallInteger('kalah')->default(0);
            $table->unsignedSmallInteger('poin')->default(0);
            $table->timestamps();

            $table->unique(['tournament_id', 'nama_tim']); // 1 tim = 1 baris per tournament
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('standings');
    }
};
