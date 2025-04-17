<?php

namespace Database\Seeders;

use App\Models\Absen;
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
            'group' => 'B',
            'password' => bcrypt('199106192023211005')
        ]);
        for ($i = 0; $i < 10; $i++) {
            Absen::create([
                'user_id' => 1,
                'nip' => 199106192023211005,
                'tanggal' => '2001-10-'. ($i+1)
            ]);
        }
        User::create([
            'name' => 'DARYANTO',
            'username' => 'daryanto',
            'NIP' => '197304172007011019',
            'jabatan_id' => 3,
            'group' => 'B',
            'password' => bcrypt('197304172007011019')
        ]);
        for ($i = 0; $i < 10; $i++) {
            Absen::create([
                'user_id' => 2,
                'nip' => 197304172007011019,
                'tanggal' => '2001-10-'. ($i+1)
            ]);
        }
        User::create([
            'name' => 'SUWITO',
            'username' => 'suwito',
            'NIP' => '197909182008011015',
            'jabatan_id' => 2,
            'group' => 'B',
            'password' => bcrypt('197909182008011015')
        ]);
        for ($i = 0; $i < 10; $i++) {
            Absen::create([
                'user_id' => 3,
                'nip' => 197909182008011015,
                'tanggal' => '2001-10-'. ($i+1)
            ]);
        }
        User::create([
            'name' => 'WULAN AFRIAL CATUR KUNCORO',
            'username' => 'kuncoro',
            'NIP' => '198004102008011018',
            'jabatan_id' => 2,
            'group' => 'B',
            'password' => bcrypt('198004102008011018')
        ]);
        for ($i = 0; $i < 10; $i++) {
            Absen::create([
                'user_id' => 4,
                'nip' => 198004102008011018,
                'tanggal' => '2001-10-'. ($i+1)
            ]);}
        User::create([
            'name' => 'ISNA R. KHOIRI',
            'username' => 'isna',
            'NIP' => '197909302009011006',
            'jabatan_id' => 2,
            'group' => 'B',
            'password' => bcrypt('197909302009011006')
        ]);
        for ($i = 0; $i < 10; $i++) {
            Absen::create([
                'user_id' => 5,
                'nip' => 197909302009011006,
                'tanggal' => '2001-10-'. ($i+1)
            ]);
        }
        User::create([
            'name' => 'DIGDO SUBROTO',
            'username' => 'digdo',
            'NIP' => '197204222009011005',
            'jabatan_id' => 2,
            'group' => 'C',
            'password' => bcrypt('197204222009011005')
        ]);
        for ($i = 0; $i < 10; $i++) {
            Absen::create([
                'user_id' => 6,
                'nip' => 197204222009011005,
                'tanggal' => '2001-10-'. ($i+1)
            ]);
        }
        User::create([
            'name' => 'SUKOCO',
            'username' => 'sukoco',
            'NIP' => '198105022008011022',
            'jabatan_id' => 2,
            'group' => 'C',
            'password' => bcrypt('198105022008011022')
        ]);
        for ($i = 0; $i < 10; $i++) {
            Absen::create([
                'user_id' => 7,
                'nip' => 198105022008011022,
                'tanggal' => '2001-10-'. ($i+1)
            ]);
        }
        User::create([
            'name' => 'MARSUDI',
            'username' => 'marsudi',
            'NIP' => '197005202008011021',
            'jabatan_id' => 2,
            'group' => 'C',
            'password' => bcrypt('197005202008011021')
        ]);
        for ($i = 0; $i < 10; $i++) {
            Absen::create([
                'user_id' => 8,
                'nip' => 197005202008011021,
                'tanggal' => '2001-10-'. ($i+1)
            ]);
        }
        User::create([
            'name' => 'SUPARDI',
            'username' => 'supardi',
            'NIP' => '197207252007011017',
            'jabatan_id' => 4,
            'group' => 'C',
            'password' => bcrypt('197207252007011017')
        ]);
        for ($i = 0; $i < 10; $i++) {
            Absen::create([
                'user_id' => 9,
                'nip' => 197207252007011017,
                'tanggal' => '2001-10-'. ($i+1)
            ]);
        }
    }
}
