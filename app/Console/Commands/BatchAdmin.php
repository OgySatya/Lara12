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

class BatchAdmin extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'app:batch-admin';

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

        $admin = User::where('group',  'Admin')
                    ->where('status', 1)
                    ->select('id', 'name', 'NIP')
                    ->get();
         $jobs = [];
        foreach ($admin as $user) {
            $user->shift = 1;
            $jobs[] = new Robot($user);
        }
        echo "Admin: " . $admin->count() . " users\n";
        Bus::batch($jobs)
            ->then(function (Batch $batch) use ($admin) {
                $names = $admin->pluck('user.name')->join(', ');
                Http::post("https://api.telegram.org/bot" . env('TELEGRAM_BOT_TOKEN') . "/sendMessage", [
                    'chat_id' => env('TELEGRAM_CHAT_ID'),
                    'text' => "✅ Semua job absen selesai untuk:\n👥 $names",
                ]);
            })
            ->dispatch();
       
    }
}
