<?php

use App\Jobs\SpanUser;
use App\Models\Absen;
use Illuminate\Foundation\Inspiring;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\Schedule;

Artisan::command('inspire', function () {
    $this->comment(Inspiring::quote());
})->purpose('Display an inspiring quote');


schedule::call(function () {
    $users = Absen::get();

    foreach ($users as $nip) {
        SpanUser::dispatch($nip->user_id);
    } 
       
})->everyFiveSeconds();