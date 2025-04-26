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
    protected $absenId;


    public function __construct($id)
    {
        $this->absenId = $id;
    }



    public function handle(): void
    {
        $absen = Absen::find($this->absenId);
        $scriptPath = base_path('resources\js\pages\absen\bot.js');
        $process = new Process(['node', $scriptPath, $absen->nip, $absen->shift]);
        $process->run();
        sleep(3);
    }
}
