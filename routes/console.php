<?php

use Carbon\Carbon;
use App\Jobs\Robot;
use App\Models\Absen;
use Illuminate\Support\Facades\DB;
use App\Console\Commands\BatchAdmin;
use App\Console\Commands\BatchLepas;
use App\Console\Commands\BatchShift1;
use App\Console\Commands\BatchShift2a;
use App\Console\Commands\BatchShift2b;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\Schedule;


Schedule::command(BatchAdmin::class)->weekdays()->at('7:05');
Schedule::command(BatchAdmin::class)->cron('2 16 * * 1-4');
Schedule::command(BatchAdmin::class)->fridays()->at('16:32');

Schedule::command(BatchShift1::class)->dailyAt('7:00');
Schedule::command(BatchShift1::class)->dailyAt('19:32');

Schedule::command(BatchShift2a::class)->dailyAt('07:32');
Schedule::command(BatchShift2b::class)->dailyAt('07:32');
Schedule::command(BatchShift2b::class)->dailyAt('19:05');
Schedule::command(BatchLepas::class)->dailyAt('07:35'); 

schedule::call(function () {
    $failedJobs = DB::table('failed_jobs')->count();
    if ($failedJobs > 0) {
        Artisan::call('queue:retry all');
    }
})->everyTenMinutes();
