<?php

namespace Database\Seeders;

use App\Models\User;
use App\Models\Tugas;
use App\Models\Target;
use App\Models\Jabatan;
use Illuminate\Database\Seeder;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;

class JobSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // $userId = User::where('username', 'ogy')->value('id');
        $penguji = Jabatan::create(['name' => 'Penguji']);
        
        $uji1 = Tugas::create(['name' => 'Rampchek', 'jabatan_id' => $penguji->id]);

        Target::create(['name' => 'target a1', 'tugas_id' => $uji1->id]);
        Target::create(['name' => 'target a2', 'tugas_id' => $uji1->id]);

        $uji2 = Tugas::create(['name' => 'Makan', 'jabatan_id' => $penguji->id]);

        Target::create(['name' => 'target b1', 'tugas_id' => $uji2->id]);
        Target::create(['name' => 'target b2', 'tugas_id' => $uji2->id]);

    }
}
