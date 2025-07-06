<?php

namespace App\Console\Commands;

use App\Jobs\Robot;
use Throwable;
use App\Models\Absen;
use Illuminate\Bus\Batch;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Bus;
use Illuminate\Support\Facades\Http;

class absenBatch extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'app:absen-batch';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Command description';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $absenIds = Absen::whereDate('tanggal', now())->pluck('id');

        $batch = Bus::batch([])

            ->then(function (Batch $batch) {
                Http::post("https://api.telegram.org/bot" . env('TELEGRAM_BOT_TOKEN') . "/sendMessage", [
                    'chat_id' => env('TELEGRAM_CHAT_ID'),
                    'text' => "✅ Semua job absen selesai untuk batch ID: {$batch->id}",
                ]);
            })

            ->catch(function (Batch $batch, Throwable $e) {
                Http::post("https://api.telegram.org/bot" . env('TELEGRAM_BOT_TOKEN') . "/sendMessage", [
                    'chat_id' => env('TELEGRAM_CHAT_ID'),
                    'text' => "❌ Batch gagal: {$batch->id}\n" . $e->getMessage(),
                ]);
            })

            ->dispatch();

        foreach ($absenIds as $id) {
            $batch->add(new Robot($id));
        }

        $this->info('Batch started.');
    }
}
