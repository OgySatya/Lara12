<?php

namespace App\Console\Commands;

use Throwable;
use Carbon\Carbon;
use App\Jobs\Robot;
use App\Models\Absen;
use Illuminate\Bus\Batch;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Bus;
use Illuminate\Support\Facades\Http;

class BatchShift1 extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'app:batch-shift1';

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

        $shift1 = Absen::with('user:id,name,group')
            ->whereDate('tanggal', Carbon::today())
            ->where('status', 1)
            ->where('shift', 1)
            ->get()
            ->filter(fn($item) => in_array($item->user->group, ['A', 'B', 'C']))
            ->values();

        // Prepare jobs
        $jobs = [];
        foreach ($shift1 as $absen) {
            $jobs[] = new Robot($absen); // or pass the whole model if needed
        }

        // Dispatch batch
        Bus::batch($jobs)
            ->then(function (Batch $batch) use ($shift1) {
                $names = $shift1->pluck('user.name')->join(', ');
                Http::post("https://api.telegram.org/bot" . env('TELEGRAM_BOT_TOKEN') . "/sendMessage", [
                    'chat_id' => env('TELEGRAM_CHAT_ID'),
                    'text' => "✅ Semua job absen selesai untuk:\n👥 $names",
                ]);
            })
            ->catch(function (Batch $batch, Throwable $e) {
                Http::post("https://api.telegram.org/bot" . env('TELEGRAM_BOT_TOKEN') . "/sendMessage", [
                    'chat_id' => env('TELEGRAM_CHAT_ID'),
                    'text' => "❌ Batch gagal: {$batch->id}\n🧨 Error: {$e->getMessage()}",
                ]);
            })

            ->dispatch();
    }
}
