<?php

use Carbon\Carbon;
use App\Jobs\Robot;
use App\Models\Absen;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\Schedule;


schedule::call(function () {
    $data = Absen::where('tanggal', Carbon::now()->toDateString())->where('status', 1)->get();

    foreach ($data as $absen) {
        Robot::dispatch($absen->id);
    }
})->twiceDaily(7, 12);

schedule::call(function () {
    $data = Absen::where('tanggal', Carbon::now()->toDateString())->where('status', 1)->get();

    foreach ($data as $absen) {
        Robot::dispatch($absen->id);
    }
})->dailyAt('16:00');

schedule::call(function () {
    $data = Absen::where('tanggal', Carbon::now()->toDateString())->where('status', 1)->get();

    foreach ($data as $absen) {
        Robot::dispatch($absen->id);
    }
})->weekly()->fridays()->at('16:30');

schedule::call(function () {
    $failedJobs = DB::table('failed_jobs')->count();
    if ($failedJobs > 0) {
        Artisan::call('queue:retry all');
    }
})->everyTenMinutes();
