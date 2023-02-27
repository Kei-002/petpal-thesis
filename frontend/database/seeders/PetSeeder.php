<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Faker\Factory as faker;
use App\Models\Pet;

class PetSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $faker = \Faker\Factory::create();
        foreach(range(1,25) as $index){
            Pet::create([
                'pet_name' => $faker->firstName($gender = 'others'|'male'|'female'),
                'age'=> $faker->numberBetween($min = 1, $max = 5),
                'customer_id'=> $faker->numberBetween($min = 1, $max = 20),
            ]);
        }
    }
}
