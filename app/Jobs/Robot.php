<?php

namespace App\Jobs;

use App\Models\Absen;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Symfony\Component\Process\Process;

class Robot implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable;
    protected $user;
    public function __construct($user)
    {
        $this->user = $user;
    }

    /**
     * Execute the job.
     */
    public function handle(): void
    {
        $scriptPath = base_path('resources\js\pages\absen\bot.js');
        $process = new Process(['node', $scriptPath, $this->user]);

        $process->run();
        sleep(2);

        // Absen::find($this->user)->update([
        //     'status' => true,
        // ]);
    }
}
