<?php

use App\Http\Controllers\SummaryController;
use Inertia\Inertia;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\TugasController;

Route::get('/', function () {
    return Inertia::render('Welcome');
})->name('home');

Route::get('dashboard', function () {
    return Inertia::render('Dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');
Route::middleware('auth', 'verified')->group(function () {
    Route::get('tugas', [TugasController::class, 'tugas'])->name('tugas');
    Route::post('upload', [TugasController::class, 'store'])->name('upload');
    Route::get('laporan', [SummaryController::class, 'show'])->name('laporan');
    Route::get('pdf', [SummaryController::class, 'create'])->name('pdf');
});
require __DIR__ . '/settings.php';
require __DIR__ . '/auth.php';
