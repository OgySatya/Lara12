<?php

use Carbon\Carbon;
use App\Jobs\Robot;

use App\Models\Absen;
use Illuminate\Foundation\Inspiring;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\Schedule;

Artisan::command('inspire', function () {
    $this->comment(Inspiring::quote());
})->purpose('Display an inspiring quote');


schedule::call(function () {
    $data = Absen::where('tanggal', Carbon::now()->toDateString())->where('status', 1)->get();

    foreach ($data as $absen) {
        Robot::dispatch($absen->id);
    }
})->everyFiveMinutes();
