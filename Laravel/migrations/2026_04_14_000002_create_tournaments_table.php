<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('tournaments', function (Blueprint $table) {
            $table->id();
            $table->string('nama');
            $table->string('logo')->nullable();
            $table->enum('format', ['single_elimination', 'round_robin'])->default('round_robin');
            $table->enum('status', ['upcoming', 'ongoing', 'finished'])->default('upcoming');
            $table->date('mulai');
            $table->date('selesai');
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('tournaments');
    }
};
