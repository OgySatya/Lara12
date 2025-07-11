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
    // public $tries = 3;
    // public $retryAfter = 10;

    public function __construct( $user)
    {
        $this->user = $user;
    }

    public function handle(): void
    {
        dd($this->user);
    //    Http::post("https://api.telegram.org/bot" . env('TELEGRAM_BOT_TOKEN'). "/sendMessage", [
    //             'chat_id' => env('TELEGRAM_CHAT_ID'),
    //             'text' => "✅ name:\n👥 {$this->user}",
    //         ]);
        // $scriptPath = base_path('resources/js/pages/absen/absenBot.js');

        // $process = new Process(['node', $scriptPath, $this->user->NIP, $this->user->shift]);
        // echo "Running Node script for user: {$this->user->name} with NIP: {$this->user->NIP} and shift: {$this->user->shift}\n";
        // $process->run();

        // if (!$process->isSuccessful()) {
        //     Log::error("Node script failed for user {$this->user->name}", [
        //         'error' => $process->getErrorOutput(),
        //         'output' => $process->getOutput(),
        //     ]);

        //     throw new \Exception("Node script failed:\nError: {$process->getErrorOutput()}");
        // }

        sleep(3); // Simulate delay between executions
    }
}
