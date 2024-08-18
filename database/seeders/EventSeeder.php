<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Faker\Factory as Faker;
use App\Models\Event;

class EventSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $faker = Faker::create();

        for ($i=0; $i < 10; $i++) { 
            Event::create([
                'title' => $faker->name, 
                'description' => $faker->sentence(), 
                'dateEvent' => $faker->dateTime(), 
                'location' => $faker->address, 
                'maxParticipants' => $faker->randomDigit()
            ]);
        }
    }
}
