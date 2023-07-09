<?php

namespace Database\Seeders;

use App\Models\Role;
use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        //Create Admin user
        User::factory()->create([
            'name' => 'Admin',
            'email' => 'admin@weroad.it',
            'password' => bcrypt('admin'),
            'role_id' => Role::where('name', 'admin')->first()->id
        ])->markEmailAsVerified();

        // Create Editor user
        User::factory()->create([
            'name' => 'Editor',
            'email' => 'editor@weroad.it',
            'password' => bcrypt('editor'),
            'role_id' => Role::where('name', 'editor')->first()->id
        ])->markEmailAsVerified();
    }
}
