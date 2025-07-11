<?php

namespace App\Console\Commands;


use Illuminate\Console\Command;
use App\Models\User;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Http;

class Test extends Command
{
    protected $signature = 'shift:send-telegram';
    protected $description = 'Send today\'s shift users to Telegram';

    public function handle()
    {
        $dayOfYear = Carbon::today()->dayOfYear;
        $whatDay = $dayOfYear % 6;
        $awal = User::first()->awal ?? 0;
        $isAwalOdd = $awal % 2 !== 0;

        $shiftMaps = $isAwalOdd ? [
            'pagi' => [[3, 4], [1, 2], [1, 2], [5, 0], [5, 0], [3, 4]],
            'malam' => [[5, 0], [3, 4], [3, 4], [1, 2], [1, 2], [5, 0]],
            'libur' => [[1, 2], [5, 0], [5, 0], [3, 4], [3, 4], [1, 2]],
        ] : [
            'pagi' => [[1, 2], [1, 2], [5, 0], [5, 0], [3, 4], [3, 4]],
            'malam' => [[3, 4], [3, 4], [1, 2], [1, 2], [5, 0], [5, 0]],
            'libur' => [[5, 0], [5, 0], [3, 4], [3, 4], [1, 2], [1, 2]],
        ];

        $pagi = $shiftMaps['pagi'][$whatDay];
        $malam = $shiftMaps['malam'][$whatDay];
        $lepas = $shiftMaps['libur'][$whatDay];

        $shift1 = User::whereIn('awal', $pagi)->where('group', '!=', 'Admin')->get(['name']);
        $shift2 = User::whereIn('awal', $malam)->where('group', '!=', 'Admin')->get(['name', 'awal']);
        $libur = User::whereIn('awal', $lepas)->where('group', '!=', 'Admin')->get(['name']);

        $isEvenDay = $whatDay % 2 === 0;

        if ($isAwalOdd) {
            $shift2a = !$isEvenDay ? $shift2 : collect();
            $shift2b = $isEvenDay ? $shift2 : collect();
            $libur1 = !$isEvenDay ? $libur : collect();
        } else {
            $shift2a = $isEvenDay ? $shift2 : collect();
            $shift2b = !$isEvenDay ? $shift2 : collect();
            $libur1 = $isEvenDay ? $libur : collect();
        }

        // Format the message
        $message = "*📅 Shift Hari Ini (" . Carbon::now()->toDateString() . ")*\n\n";

        $message .= "*Shift 1 (Pagi)*\n";
        foreach ($shift1 as $user) {
            $message .= "- " . $user->name . "\n";
        }

        $message .= "\n*Shift 2A (Malam)*\n";
        foreach ($shift2a as $user) {
            $message .= "- " . $user->name . "\n";
        }

        $message .= "\n*Shift 2B (Malam)*\n";
        foreach ($shift2b as $user) {
            $message .= "- " . $user->name . "\n";
        }

        $message .= "\n*Libur*\n";
        foreach ($libur1 as $user) {
            $message .= "- " . $user->name . "\n";
        }

        // Send to Telegram
        $response = Http::post("https://api.telegram.org/bot". env('TELEGRAM_BOT_TOKEN')."/sendMessage", [
            'chat_id' => env('TELEGRAM_CHAT_ID'),
            'text' => $message,
            'parse_mode' => 'Markdown',
        ]);

        if ($response->successful()) {
            $this->info('Shift list sent to Telegram successfully.');
        } else {
            $this->error('Failed to send message: ' . $response->body());
        }
    }
}
