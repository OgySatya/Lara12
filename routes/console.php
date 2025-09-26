<?php

use App\Models\User;
use Illuminate\Support\Facades\Http;
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
Schedule::command(BatchAdmin::class)->fridays()->at('16:45');

Schedule::command(BatchShift1::class)->dailyAt('7:00');
Schedule::command(BatchShift1::class)->dailyAt('19:40');

Schedule::command(BatchShift2a::class)->dailyAt('07:40');
Schedule::command(BatchShift2b::class)->dailyAt('07:40');
Schedule::command(BatchShift2b::class)->dailyAt('19:05');
Schedule::command(BatchLepas::class)->dailyAt('07:40'); 

schedule::call(function () {
    $failedJobs = DB::table('failed_jobs')->count();
    if ($failedJobs > 0) {
        Artisan::call('queue:retry all');
    }
})->everyTenMinutes()->between('7:00', '08:00');

schedule::call(function () {
    $failedJobs = DB::table('failed_jobs')->count();
    if ($failedJobs > 0) {
        Artisan::call('queue:retry all');
    }
})->everyTenMinutes()->between('19:00', '20:00');

schedule::call(function () {
        Artisan::call('queue:flush');
})->twiceDailyAt(8, 20, 15);

schedule::call(function () {
    User::query()->update(['status' => false]);
    Http::post("https://api.telegram.org/bot" . env('TELEGRAM_BOT_TOKEN') . "/sendMessage", [
                'chat_id' => env('TELEGRAM_CHAT_ID'),
                'text' => "Absen Pegawai di nonaktifkan semua, silahkan aktifkan kembali sesuai jadwal Shift yang Baru, Matur Suwun",
            ]);
})->yearly();