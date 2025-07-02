<?php

use Carbon\Carbon;
use App\Jobs\Robot;
use App\Models\Absen;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\Schedule;


schedule::call(function () {
   
$shift1 = Absen::whereDate('tanggal', Carbon::today())
    ->where('status', 1)
    ->where('shift', 1)
    ->get();

    foreach ($shift1 as $absen) {
        Robot::dispatch($absen->id);
    }
})->dailyAt('6:45');

schedule::call(function () {

$shift1 = Absen::with('user:id,group')
    ->whereDate('tanggal', Carbon::today())
    ->where('status', 1)
    ->where('shift', 1)
    ->get()
    ->filter(fn($item) => in_array($item->user->group, ['A', 'B', 'C']))
    ->values();

    foreach ($shift1 as $absen) {
        Robot::dispatch($absen->id);
    }
})->dailyAt('19:32');

schedule::call(function () {
    $shift2 = Absen::with('user:id,group')
    ->whereDate('tanggal', Carbon::today())
    ->where('status', 1)
    ->where('shift', 2)
    ->where('pagi', 1)
    ->get()
    ->filter(fn($item) => in_array($item->user->group, ['A', 'B', 'C']))
    ->values();

    foreach ($shift2 as $absen) {
        Robot::dispatch($absen->id);
    }
})->dailyAt('7:35');

schedule::call(function () {
    $shift2 = Absen::with('user:id,group')
    ->whereDate('tanggal', Carbon::today())
    ->where('status', 1)
    ->where('shift', 2)
    ->where('malam', 1)
    ->get()
    ->filter(fn($item) => in_array($item->user->group, ['A', 'B', 'C']))
    ->values();

    foreach ($shift2 as $absen) {
        Robot::dispatch($absen->id);
    }
})->dailyAt('19:00');

schedule::call(function () {
     $admin = Absen::with('user:id,group')
    ->whereDate('tanggal', Carbon::today())
    ->where('status', 1)
    ->where('shift', 2)
    ->get()
    ->filter(fn($item) => $item->user->group === 'Admin')
    ->values();

    foreach ($admin as $absen) {
        Robot::dispatch($absen->id);
    }
})->dailyAt('16:02');

schedule::call(function () {
    $admin = Absen::with('user:id,group')
    ->whereDate('tanggal', Carbon::today())
    ->where('status', 1)
    ->where('shift', 2)
    ->get()
    ->filter(fn($item) => $item->user->group === 'Admin')
    ->values();

    foreach ($admin as $absen) {
        Robot::dispatch($absen->id);
    }
})->weekly()->fridays()->at('16:35');

schedule::call(function () {
    $failedJobs = DB::table('failed_jobs')->count();
    if ($failedJobs > 0) {
        Artisan::call('queue:retry all');
    }
})->everyTenMinutes();
