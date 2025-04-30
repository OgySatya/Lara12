<?php

namespace Database\Seeders;

use App\Models\Absen;
use App\Models\User;
use Illuminate\Database\Seeder;
use Carbon\Carbon;


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
            'group' => 'B',
            'password' => bcrypt('199106192023211005')
        ]);
        
        User::create([
            'name' => 'DARYANTO',
            'username' => 'daryanto',
            'NIP' => '197304172007011019',
            'jabatan_id' => 3,
            'group' => 'B',
            'password' => bcrypt('197304172007011019')
        ]);
        
        User::create([
            'name' => 'SUWITO',
            'username' => 'suwito',
            'NIP' => '197909182008011015',
            'jabatan_id' => 2,
            'group' => 'B',
            'password' => bcrypt('197909182008011015')
        ]);
        
        User::create([
            'name' => 'WULAN AFRIAL CATUR KUNCORO',
            'username' => 'kuncoro',
            'NIP' => '198004102008011018',
            'jabatan_id' => 2,
            'group' => 'B',
            'password' => bcrypt('198004102008011018')
        ]);
        
        User::create([
            'name' => 'ISNA R. KHOIRI',
            'username' => 'isna',
            'NIP' => '197909302009011006',
            'jabatan_id' => 2,
            'group' => 'B',
            'password' => bcrypt('197909302009011006')
        ]);
        
        User::create([
            'name' => 'DIGDO SUBROTO',
            'username' => 'digdo',
            'NIP' => '197204222009011005',
            'jabatan_id' => 2,
            'group' => 'C',
            'password' => bcrypt('197204222009011005')
        ]);
        
        User::create([
            'name' => 'SUKOCO',
            'username' => 'sukoco',
            'NIP' => '198105022008011022',
            'jabatan_id' => 2,
            'group' => 'C',
            'password' => bcrypt('198105022008011022')
        ]);
        
        User::create([
            'name' => 'MARSUDI',
            'username' => 'marsudi',
            'NIP' => '197005202008011021',
            'jabatan_id' => 2,
            'group' => 'C',
            'password' => bcrypt('197005202008011021')
        ]);
        
        User::create([
            'name' => 'SUPARDI',
            'username' => 'supardi',
            'NIP' => '197207252007011017',
            'jabatan_id' => 4,
            'group' => 'C',
            'password' => bcrypt('197207252007011017')
        ]);
        
    }
}
