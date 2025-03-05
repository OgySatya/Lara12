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
            'name' => 'admin',
            'username' => 'boss',
            'NIP' => '123',
            'jabatan' => 'boss',
            'group' => 'a',
            'email' => 'admin@gmail.com',
            'password' => bcrypt('123')
        ]);
        $user = User::create([
            'name' => 'Ogy Satya',
            'username' => 'ogy',
            'NIP' => '321',
            'jabatan' => 'kates',
            'group' => 'b',
            'email' => 'admin2@gmail.com',
            'password' => bcrypt('321')
        ]);
        $user = User::create([
            'name' => 'lekzar',
            'username' => 'zar',
            'NIP' => '567',
            'jabatan' => 'entah',
            'group' => 'c',
            'email' => 'admin1@gmail.com',
            'password' => bcrypt('567')
        ]);
        $user->assignRole('admin');
    }
}
