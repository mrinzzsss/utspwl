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
            $table->foreignId('tournament_id')->constrained('tournaments')->cascadeOnDelete();
            $table->string('tim_a');              // nama tim langsung (tanpa FK ke teams)
            $table->string('tim_b');
            $table->tinyInteger('skor_a')->default(0);
            $table->tinyInteger('skor_b')->default(0);
            $table->foreignId('mvp_id')->nullable()->constrained('players')->nullOnDelete();
            $table->datetime('jadwal_tanding');
            $table->enum('status', ['pending', 'selesai'])->default('pending');
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('matches');
    }
};
