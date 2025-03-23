<?php

use Inertia\Inertia;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\TaskController;
use App\Http\Controllers\TugasController;
use App\Http\Controllers\SummaryController;
use Illuminate\Console\View\Components\Task;

Route::get('/', function () {
    return Inertia::render('Welcome');
})->name('home');

Route::get('dashboard', function () {
    return Inertia::render('Dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');
Route::middleware('auth', 'verified')->group(function () {
    // Route::get('tugas', [TugasController::class, 'tugas'])->name('tugas');
    // Route::post('upload', [TugasController::class, 'store'])->name('upload');
    Route::get('job', [TaskController::class, 'frontline'])->name('job');
    Route::post('put', [TaskController::class, 'save'])->name('put');
    Route::delete('image', [TaskController::class, 'destroy'])->name('image');
    Route::get('layout', [SummaryController::class, 'show'])->name('layout');
    Route::get('pdf', [SummaryController::class, 'create'])->name('pdf');
});
require __DIR__ . '/settings.php';
require __DIR__ . '/auth.php';
