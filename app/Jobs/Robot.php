<?php

namespace App\Jobs;

use Throwable;
use Illuminate\Bus\Batchable;
use Illuminate\Bus\Queueable;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Http;
use Symfony\Component\Process\Process;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;

class Robot implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, Batchable;

    public $user;
    public $tries = 3;
    public $backoff = 10;

    public function __construct($user)
    {
        $this->user = $user;
    }

    public function handle(): void
    {


        $scriptPath = base_path('resources/js/pages/absen/absenBot.js');

        $process = new Process(['node', $scriptPath, $this->user->NIP, $this->user->shift]);
        $process->run();

        if (!$process->isSuccessful()) {
            $errorOutput = $process->getErrorOutput();

            Http::post("https://api.telegram.org/bot" . env('TELEGRAM_BOT_TOKEN') . "/sendMessage", [
                'chat_id' => env('TELEGRAM_CHAT_ID'),
                'text' => "❌ Gagal Absen : {$this->user->name}n/ Error: $errorOutput",
            ]);
        }
        sleep(10);
    }
}
