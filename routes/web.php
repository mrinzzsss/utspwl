<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\TournamentController;
use App\Http\Controllers\MatchController;
use App\Http\Controllers\PlayerController;
use App\Http\Controllers\Auth\AuthController;


// Login
Route::middleware('guest')->group(function () {
    Route::get('/login',    [AuthController::class, 'showLogin'])->name('login');
    Route::post('/login',   [AuthController::class, 'login']);
    Route::get('/register', [AuthController::class, 'showRegister'])->name('register');
    Route::post('/register', [AuthController::class, 'register']);
});
Route::post('/logout', [AuthController::class, 'logout'])->name('logout')->middleware('auth');


// PUBLIC ROUTES — Guest bisa akses tanpa login

Route::get('/', [HomeController::class, 'index'])->name('home');

// Tournament: list & detail (bracket, jadwal, skor, roster)
Route::get('/tournaments', [TournamentController::class, 'index'])->name('tournaments.index');
Route::get('/tournaments/{tournament}', [TournamentController::class, 'show'])->name('tournaments.show');


// AUTH REQUIRED — Harus login

Route::middleware(['auth'])->group(function () {

    // Tournament CRUD (Admin)
    Route::get('/tournaments/create', [TournamentController::class, 'create'])->name('tournaments.create');
    Route::post('/tournaments', [TournamentController::class, 'store'])->name('tournaments.store');
    Route::get('/tournaments/{tournament}/edit', [TournamentController::class, 'edit'])->name('tournaments.edit');
    Route::put('/tournaments/{tournament}', [TournamentController::class, 'update'])->name('tournaments.update');
    Route::delete('/tournaments/{tournament}', [TournamentController::class, 'destroy'])->name('tournaments.destroy');

    // Player CRUD (Admin & Manajemen)
    Route::get('/tournaments/{tournament}/players/create', [PlayerController::class, 'create'])->name('tournaments.players.create');
    Route::post('/tournaments/{tournament}/players', [PlayerController::class, 'store'])->name('tournaments.players.store');
    Route::get('/players/{player}/edit', [PlayerController::class, 'edit'])->name('players.edit');
    Route::put('/players/{player}', [PlayerController::class, 'update'])->name('players.update');
    Route::delete('/players/{player}', [PlayerController::class, 'destroy'])->name('players.destroy');

    // Match Schedule (Admin & Manajemen)
    Route::get('/tournaments/{tournament}/matches/create', [MatchController::class, 'create'])->name('tournaments.matches.create');
    Route::post('/tournaments/{tournament}/matches', [MatchController::class, 'store'])->name('tournaments.matches.store');
    Route::delete('/matches/{match}', [MatchController::class, 'destroy'])->name('matches.destroy');

    // Match Hasil (Wasit & Admin)
    Route::get('/matches/{match}/hasil', [MatchController::class, 'editHasil'])->name('matches.hasil');
    Route::put('/matches/{match}/hasil', [MatchController::class, 'updateHasil'])->name('matches.updateHasil');
});
