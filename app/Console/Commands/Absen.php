<?php

namespace App\Console\Commands;

use Throwable;
use Carbon\Carbon;
use App\Jobs\Robot;
use App\Models\User;
use Illuminate\Bus\Batch;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Bus;
use Illuminate\Support\Facades\Http;

class BatchLepas extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'absen:for {shift}';

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
    $dayOfYear = Carbon::today()->dayOfYear;
    $whatDay = $dayOfYear % 6;
    $awal = User::first()->awal;
    $isAwalOdd = $awal % 2 !== 0;

    // Define shift maps based on `awal` parity
    $shiftMaps = $isAwalOdd ? [
        'pagi' => [
            [3, 4], [1, 2], [1, 2], [5, 0], [5, 0], [3, 4],
        ],
        'malam' => [
            [5, 0], [3, 4], [3, 4], [1, 2], [1, 2], [5, 0],
        ],
        'libur' => [
            [1, 2], [5, 0], [5, 0], [3, 4], [3, 4], [1, 2],
        ],
    ] : [
        'pagi' => [
            [1, 2], [1, 2], [5, 0], [5, 0], [3, 4], [3, 4],
        ],
        'malam' => [
            [3, 4], [3, 4], [1, 2], [1, 2], [5, 0], [5, 0],
        ],
        'libur' => [
            [5, 0], [5, 0], [3, 4], [3, 4], [1, 2], [1, 2],
        ],
    ];

    // Get groups
    $pagi = $shiftMaps['pagi'][$whatDay];
    $malam = $shiftMaps['malam'][$whatDay];
    $lepas = $shiftMaps['libur'][$whatDay];

   // Fetch users for each group
        $shift1 = User::whereIn('awal', $pagi)->where('group', '!=', 'Admin')->where('status', 1)->get(['id', 'name', 'NIP','absen']);
        $shift2 = User::whereIn('awal', $malam)->where('group', '!=', 'Admin')->where('status', 1)->get(['id', 'name', 'NIP','absen']);
        $libur  = User::whereIn('awal', $lepas)->where('group', '!=', 'Admin')->where('status', 1)->get(['id', 'name', 'NIP','absen']);
        $admin = User::where('group',  'Admin')->where('status', 1)->select('id', 'name', 'NIP','absen')->get();


    // Determine shift2 split and libur1
    $isEvenDay = $whatDay % 2 === 0;
    if ($isAwalOdd) {
        $shift2a = !$isEvenDay ? $shift2 : collect();
        $shift2b = $isEvenDay ? $shift2 : collect();
        $libur  = !$isEvenDay ? $libur : collect();
    } else {
        $shift2a = $isEvenDay ? $shift2 : collect();
        $shift2b = !$isEvenDay ? $shift2 : collect();
        $libur  = $isEvenDay ? $libur : collect();
    }
         $absen = $this->argument('shift');
         $shift = [];
         $melebu = 0;
         $jobs = [];
         if ($absen === 'pagi') {
            $shift = $shift1;
            $melebu = 1;
        }elseif ($absen === 'malam1') {
            $shift = $shift2a;
            $melebu = 2;  
        }elseif($absen === 'malam2') {
            $shift = $shift2b;
            $melebu = 2;
        }elseif($absen === 'libur') {
            $shift = $libur;
            $melebu = 2;
        }elseif($absen === 'admin') {
            $shift = $admin;
            $melebu = 1;
        }
        
        foreach ($shift as $user) {
            $user->shift = $melebu;
            $jobs[] = new Robot($user);
        }
        echo "Shift $absen: " . $shift->count() . " users\n";
       Bus::batch($jobs)
            ->then(function (Batch $batch) use ($shift ) {
                $names = $shift->pluck('name')->join(', ');
                // Http::post("https://api.telegram.org/bot" . env('TELEGRAM_BOT_TOKEN') . "/sendMessage", [
                //     'chat_id' => env('TELEGRAM_CHAT_ID'),
                //     'text' => "✅ Semua absen selesai Boss!!! untuk:\n$names",
                // ]);
            })
            ->catch(function (Batch $batch, Throwable $e) use ($shift) {
                $failedCount = $batch->failedJobs;   // number of failed jobs
                $total = $batch->totalJobs;
                $processed = $batch->processedJobs();

                Http::post("https://api.telegram.org/bot" . env('TELEGRAM_BOT_TOKEN') . "/sendMessage", [
                    'chat_id' => env('TELEGRAM_CHAT_ID'),
                    'text' => "❌ Ada $failedCount Absen gagal dari $total total.\n"
                        . "👉 Selesai diproses: $processed\n"
                        . "⚠️ LastError : {$e->getMessage()}",
                ]);
            })
            ->dispatch();
    }
}
