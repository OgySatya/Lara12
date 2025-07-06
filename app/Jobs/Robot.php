<?php

namespace App\Jobs;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Symfony\Component\Process\Process;

class Robot implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable;
    protected $user;
    public $tries = 3;
    public $retryAfter = 10;

    public function __construct($absen)
    {
        $this->user = $absen; // Assuming $absen is an Absen model instance
    }



    public function handle(): void
    {

        $scriptPath = base_path('resources\js\pages\absen\absenBot.js');
        $process = new Process(['node', $scriptPath, $this->user->nip, $this->user->shift]);
        $process->run();

        if (!$process->isSuccessful()) {
            $errorOutput = $process->getErrorOutput();
            $output = $process->getOutput(); // optional, may be helpful for debugging
            throw new \Exception("Node script failed:\nError: $errorOutput\nOutput: $output");
        }
        sleep(3);
    }
}
