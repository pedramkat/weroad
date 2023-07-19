<?php

namespace Database\Seeders;

use App\Models\Role;
use Illuminate\Database\Seeder;

class RoleSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Role::truncate();

        $jsonRoles = json_decode(file_get_contents(base_path('storage/app/seeder/roles.json')), true);

        foreach ($jsonRoles as $role) {
            Role::create([
                'id' => $role['id'],
                'name' => $role['name'],
            ]);
        }
    }
}
