<?php

use Inertia\Inertia;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\JobsController;
use App\Http\Controllers\TaskController;
use App\Http\Controllers\SummaryController;

Route::get('/', function () {
    return Inertia::render('Welcome');
})->name('home');
Route::get('/test', function () {
    return Inertia::render('absen/test');
})->name('test');
Route::post('saved', [JobsController::class, 'save'])->name('saved');
Route::get('dashboard', function () {
    return Inertia::render('Dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');
Route::middleware('auth', 'verified')->group(function () {
    // Route::get('job', [TaskController::class, 'frontline'])->name('job');
    // Route::post('put', [TaskController::class, 'save'])->name('put');
    // Route::delete('delete', [TaskController::class, 'destroy'])->name('delete');
    Route::get('job', [JobsController::class, 'jobView'])->name('job');
    Route::post('store', [JobsController::class, 'store'])->name('store');
    Route::post('save', [JobsController::class, 'save'])->name('save');
    Route::delete('delete', [JobsController::class, 'destroy'])->name('delete');
    Route::get('laporan', [SummaryController::class, 'show'])->name('laporan');
    Route::get('pdf', [SummaryController::class, 'create'])->name('pdf');
});
require __DIR__ . '/settings.php';
require __DIR__ . '/auth.php';
