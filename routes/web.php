<?php

use Inertia\Inertia;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\TugasController;

Route::get('/', function () {
    return Inertia::render('Welcome');
})->name('home');

Route::get('dashboard', function () {
    return Inertia::render('Dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');
// Route::get('tugas1', function () {
//     return Inertia::render('Tugas1');
// })->middleware(['auth', 'verified'])->name('tugas1');
Route::middleware('auth', 'verified')->group(function () {
    Route::get('tugas1', [TugasController::class, 'tugas1'])->name('tugas1');
    Route::post('upload', [TugasController::class, 'store'])->name('upload');
});
require __DIR__ . '/settings.php';
require __DIR__ . '/auth.php';
