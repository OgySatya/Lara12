<?php

namespace Database\Seeders;

use Carbon\Carbon;
use App\Models\User;
use App\Models\Absen;
use Illuminate\Database\Seeder;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;

class AbsenSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $users = User::get();
        foreach ($users as $user) {
            for ($i = 0; $i < 10; $i++) {
                Absen::create([
                    'user_id' => $user->id,
                    'shift' => 1,
                    'nip' => $user->NIP,
                    'tanggal' => Carbon::now()->toDateString(),
                ]);
            }
        };
       
    }
}
