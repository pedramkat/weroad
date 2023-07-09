<?php

namespace Database\Seeders;

use App\Models\Travel;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class TravelSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Travel::truncate();

        $jsonTravels = json_decode(file_get_contents(base_path("storage/app/seeder/travels.json")), true);

        foreach ($jsonTravels as $travel) {
            $params = [];
            if (array_key_exists('moods', $travel) && !empty($travel['moods'])) {
                $params = $travel['moods'];
            }
            Travel::updateOrCreate([
                'id' => $travel['id'],
                'name' => $travel['name'],
                'slug' => $travel['slug'],
                'description' => $travel['description'],
                'numberOfDays' => $travel['numberOfDays'],
            ], $params);
        }
    }
}
