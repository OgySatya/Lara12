<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
     
        User::create([
            'name' => 'GEDE OGY SATIA HAPRABU',
            'username' => 'ogy',
            'NIP' => '199106192023211005',
            'jabatan_id' => 1,
            'group' => 'b',
            'password' => bcrypt('199106192023211005')
        ]);
        User::create([
            'name' => 'WULAN AFRIAL CATUR KUNCORO',
            'username' => 'kuncoro',
            'NIP' => '198004102008011018',
            'jabatan_id' => 2,
            'group' => 'b',
            'password' => bcrypt('198004102008011018')
        ]);
        User::create([
            'name' => 'SUKOCO',
            'username' => 'sukoco',
            'NIP' => '198105022008011022',
            'jabatan_id' => 2,
            'group' => 'c',
            'password' => bcrypt('198105022008011022')
        ]);
    }
}
