<?php

namespace Database\Seeders;

use App\Models\User;
// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        Permission::create(['name' => 'make user']);
        Permission::create(['name' => 'edit user']);
        Permission::create(['name' => 'view user']);
        Permission::create(['name' => 'delete user']);

        Role::create(['name' => 'admin']);

        $admin = Role::findByName('admin');
        $admin->givePermissionTo('make user');
        $admin->givePermissionTo('view user');
        $admin->givePermissionTo('edit user');
        $admin->givePermissionTo('delete user');


        $user = User::create([
            'name' => 'GEDE OGY SATIA HAPRABU',
            'username' => 'ogy',
            'NIP' => '199106192023211005',
            'jabatan_id' => 1,
            'group' => 'b',
            'password' => bcrypt('199106192023211005')
        ]);
        $user->assignRole('admin');
        $user = User::create([
            'name' => 'WULAN AFRIAL CATUR KUNCORO',
            'username' => 'kuncoro',
            'NIP' => '198004102008011018',
            'jabatan_id' => 2,
            'group' => 'b',
            'password' => bcrypt('198004102008011018')
        ]);
        $user = User::create([
            'name' => 'SUKOCO',
            'username' => 'sukoco',
            'NIP' => '198105022008011022',
            'jabatan_id' => 2,
            'group' => 'c',
            'password' => bcrypt('198105022008011022')
        ]);
    }
}
