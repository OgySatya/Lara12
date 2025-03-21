<?php

use App\Http\Controllers\SummaryController;
use Inertia\Inertia;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\TaskController;

Route::get('/', function () {
    return Inertia::render('Welcome');
})->name('home');

Route::get('dashboard', function () {
    return Inertia::render('Dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');
Route::middleware('auth', 'verified')->group(function () {
    Route::get('job', [TaskController::class, 'frontline'])->name('job');
    Route::post('store', [TaskController::class, 'save'])->name('store');
    Route::get('report', [SummaryController::class, 'show'])->name('report');
    Route::get('pdf', [SummaryController::class, 'create'])->name('pdf');
});
require __DIR__ . '/settings.php';
require __DIR__ . '/auth.php';
