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

        echo "Processing user: {$this->user->name}, NIP: {$this->user->NIP}, Shift: {$this->user->shift}\n";
        // $scriptPath = base_path('resources/js/pages/absen/absenBot.js');

        // $process = new Process(['node', $scriptPath, $this->user->NIP, $this->user->shift]);
        // $process->run();

        // if (!$process->isSuccessful()) {
        //     $errorOutput = $process->getErrorOutput();

        //     // Send immediate error notification
        //     Http::post("https://api.telegram.org/bot" . env('TELEGRAM_BOT_TOKEN') . "/sendMessage", [
        //         'chat_id' => env('TELEGRAM_CHAT_ID'),
        //         'text' => "❌ Gagal Absen : {$this->user->name}\nAbsen Dewe-Dewe dulu ya Boss!!\nMatur suwun🙏",
        //     ]);

        //     // 🚨 Mark job as failed for the batch
        //     throw new \Exception("Process failed for {$this->user->name}: $errorOutput");
        // }

        // sleep(10);
    }

    public function failed(\Throwable $exception)
    {
        // // Called after all retries are exhausted
        // Http::post("https://api.telegram.org/bot" . env('TELEGRAM_BOT_TOKEN') . "/sendMessage", [
        //     'chat_id' => env('TELEGRAM_CHAT_ID'),
        //     'text' => "💀 gagal absen 3x Capek Boss!! : {$this->user->name}",
        // ]);
    }
}
