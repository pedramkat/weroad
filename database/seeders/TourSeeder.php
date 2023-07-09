<?php

namespace Database\Seeders;

use App\Models\Tour;
use App\Models\Travel;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class TourSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Tour::truncate();

        $jsonTours = json_decode(file_get_contents(base_path("storage/app/seeder/tours.json")), true);

        foreach ($jsonTours as $tour) {
            Tour::create([
                'id' => $tour['id'],
                'name' => $tour['name'],
                'startingDate' => $tour['startingDate'],
                'endingDate' => $tour['endingDate'],
                'price' => $tour['price'],
                'travelId' => Travel::where('id', $tour['travelId'])->first()->id
            ]);
        }
    }
}
