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
        Permission::create(['name' => 'view anime']);
        Permission::create(['name' => 'view pokemon']);

        Role::create(['name' => 'admin']);
        Role::create(['name' => 'superuser']);

        $admin = Role::findByName('admin');
        $admin->givePermissionTo('make user');
        $admin->givePermissionTo('view user');
        $admin->givePermissionTo('edit user');
        $admin->givePermissionTo('delete user');

        $superuser = Role::findByName('superuser');
        $superuser->givePermissionTo('view anime');
        $superuser->givePermissionTo('view pokemon');

        $user = User::create([
            'name' => 'admin',
            'username' => 'boss',
            'email' => 'admin@gmail.com',
            'password' => bcrypt('123qweasd')
        ]);
        $user->assignRole('admin');
    }
}
