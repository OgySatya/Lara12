<?php

namespace App\Console\Commands;

use Throwable;
use Carbon\Carbon;
use App\Jobs\Robot;
use App\Models\User;
use App\Models\Absen;
use Illuminate\Bus\Batch;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Bus;
use Illuminate\Support\Facades\Http;

class BatchShift2a extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'app:batch-shift2a';

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
                [3, 4],
                [1, 2],
                [1, 2],
                [5, 0],
                [5, 0],
                [3, 4],
            ],
            'malam' => [
                [5, 0],
                [3, 4],
                [3, 4],
                [1, 2],
                [1, 2],
                [5, 0],
            ],
            'libur' => [
                [1, 2],
                [5, 0],
                [5, 0],
                [3, 4],
                [3, 4],
                [1, 2],
            ],
        ] : [
            'pagi' => [
                [1, 2],
                [1, 2],
                [5, 0],
                [5, 0],
                [3, 4],
                [3, 4],
            ],
            'malam' => [
                [3, 4],
                [3, 4],
                [1, 2],
                [1, 2],
                [5, 0],
                [5, 0],
            ],
            'libur' => [
                [5, 0],
                [5, 0],
                [3, 4],
                [3, 4],
                [1, 2],
                [1, 2],
            ],
        ];

        // Get groups
        $pagi = $shiftMaps['pagi'][$whatDay];
        $malam = $shiftMaps['malam'][$whatDay];
        $lepas = $shiftMaps['libur'][$whatDay];

        // Fetch users for each group
         $shift1 = User::whereIn('awal', $pagi)->where('group', '!=', 'Admin')->where('status', 1)->get(['id', 'name', 'NIP']);
        $shift2 = User::whereIn('awal', $malam)->where('group', '!=', 'Admin')->where('status', 1)->get(['id', 'name', 'NIP']);
        $libur  = User::whereIn('awal', $lepas)->where('group', '!=', 'Admin')->where('status', 1)->get(['id', 'name', 'NIP']);

        // Determine shift2 split and libur1
        $isEvenDay = $whatDay % 2 === 0;
        if ($isAwalOdd) {
            $shift2a = !$isEvenDay ? $shift2 : collect();
            $shift2b = $isEvenDay ? $shift2 : collect();
            $libur1  = !$isEvenDay ? $libur : collect();
        } else {
            $shift2a = $isEvenDay ? $shift2 : collect();
            $shift2b = !$isEvenDay ? $shift2 : collect();
            $libur1  = $isEvenDay ? $libur : collect();
        }

        $jobs = [];
        foreach ($shift2a as $user) {
            $user->shift = 2;
            $jobs[] = new Robot($user);
        }
        echo "Shift 2 Pertama: " . $shift2a->count() . " users\n";
        Bus::batch($jobs)
            ->then(function (Batch $batch) use ($shift2a) {
                $names = $shift2a->pluck('name')->join(', ');
                Http::post("https://api.telegram.org/bot" . env('TELEGRAM_BOT_TOKEN') . "/sendMessage", [
                    'chat_id' => env('TELEGRAM_CHAT_ID'),
                    'text' => "✅ Semua absen Shift 2 selesai BOSS!! untuk:\n👥 $names",
                ]);
            })
            ->dispatch();
    }
}
