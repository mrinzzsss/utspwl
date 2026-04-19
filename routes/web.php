<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\TeamController;
use App\Http\Controllers\PlayerController;
use App\Http\Controllers\StandingController;
use App\Http\Controllers\MatchController;
use App\Http\Controllers\UserController;

/*
|--------------------------------------------------------------------------
| MPL Lite — Web Routes
|--------------------------------------------------------------------------
|
| Role akses:
|   manajemen  → full CRUD semua resource + kelola user
|   wasit      → read-only + input skor match
|   player     → hanya halaman publik (home)
|
*/

// ── Halaman Publik ────────────────────────────────────────────────────
Route::get('/', [HomeController::class, 'index'])->name('home');

// ── Auth ──────────────────────────────────────────────────────────────
Route::middleware('guest')->group(function () {
    Route::get('/login', [AuthController::class, 'showLogin'])->name('login');
    Route::post('/login', [AuthController::class, 'login'])->name('login.post');
});

Route::post('/logout', [AuthController::class, 'logout'])
    ->name('logout')
    ->middleware('auth');

// ── Dashboard Manajemen ───────────────────────────────────────────────
Route::middleware(['auth', 'role:manajemen'])->prefix('manajemen')->name('manajemen.')->group(function () {

    Route::get('/dashboard', [HomeController::class, 'manajemenDashboard'])->name('dashboard');

    // Tim
    Route::resource('teams', TeamController::class);

    // Pemain
    Route::resource('players', PlayerController::class);

    // Klasemen
    Route::resource('standings', StandingController::class)->except(['show']);

    // Pertandingan
    Route::resource('matches', MatchController::class);

    // User management
    Route::resource('users', UserController::class);
});

// ── Dashboard Wasit ───────────────────────────────────────────────────
Route::middleware(['auth', 'role:wasit'])->prefix('wasit')->name('wasit.')->group(function () {

    Route::get('/dashboard', [HomeController::class, 'wasitDashboard'])->name('dashboard');

    // Lihat daftar pertandingan (read only)
    Route::get('/matches', [MatchController::class, 'index'])->name('matches.index');
    Route::get('/matches/{match}', [MatchController::class, 'show'])->name('matches.show');

    // Input skor
    Route::get('/matches/{match}/score', [MatchController::class, 'inputScoreForm'])->name('matches.score.form');
    Route::post('/matches/{match}/score', [MatchController::class, 'inputScore'])->name('matches.score');
});
