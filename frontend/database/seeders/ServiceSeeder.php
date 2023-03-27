<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Faker\Factory as faker;
use App\Models\GroomServices;

class ServiceSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $faker = \Faker\Factory::create();
        $services = array(
            "Haircut" => 1000,
            "Bath" => 600,
            "Nail Trim" => 400,
            "Brush Teeth" => 200,
        );

        foreach ($services as $name => $price) {
            GroomServices::create([
                'groom_name' => $name,
                'price' => $price,
                'description' => $faker->realText($maxNbChars = 50, $indexSize = 2),
            ]);
        }
    }
}
