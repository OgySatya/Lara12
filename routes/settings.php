<?php

use Inertia\Inertia;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ReviewController;
use App\Http\Controllers\Absen\AbsenController;
use App\Http\Controllers\Settings\ProfileController;


Route::middleware('auth')->group(function () {
    Route::redirect('settings', 'settings/profile');
    Route::get('settings/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('settings/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('settings/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');

    Route::get('settings/appearance', function () {
        return Inertia::render('settings/Appearance');
    })->name('appearance');

    Route::get('setting/absen', [AbsenController::class, 'index'])->name('absen');
});

Route::patch('setting/update', [AbsenController::class, 'update'])->name('absen.update');
Route::patch('setting/edit', [AbsenController::class, 'edit'])->name('absen.edit');
Route::get('review/absen', [ReviewController::class, 'index'])->name('review');
Route::get('review/active', [ReviewController::class, 'active'])->name('active');
Route::get('review/retry', [ReviewController::class, 'retry'])->name('retry');
Route::get('review/clear', [ReviewController::class, 'clear'])->name('clear');
