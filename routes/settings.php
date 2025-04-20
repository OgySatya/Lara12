<?php

use Inertia\Inertia;
use Illuminate\Support\Facades\Route;
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
    Route::patch('setting/save', [AbsenController::class, 'update'])->name('absen.update');
    Route::patch('setting/cancel', [AbsenController::class, 'revoke'])->name('absen.revoke');
});
