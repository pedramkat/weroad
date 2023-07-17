<?php

namespace Database\Seeders;

use App\Models\Role;
use App\Models\User;
use Illuminate\Database\Seeder;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        //Create Admin user
        $adminuser = User::create([
            'name' => 'Admin',
            'email' => 'admin@weroad.it',
            'password' => bcrypt('admin'),
        ]);
        $adminuser->roles()->sync(Role::all()->pluck('id')->toArray());
        $adminuser->markEmailAsVerified();
        $adminuser->save();

        // Create Editor user
        $editorUser = User::create([
            'name' => 'Editor',
            'email' => 'editor@weroad.it',
            'password' => bcrypt('editor'),
        ]);
        $editorUser->roles()->sync(Role::where('name', 'editor')->pluck('id')->toArray());
        $editorUser->markEmailAsVerified();
        $editorUser->save();
    }
}
