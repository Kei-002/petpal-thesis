<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Product;
use App\Models\Category;
use App\Models\Stock;

class ProductSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $faker = \Faker\Factory::create();
        $products = array(
            "Rectangular Plush" => 3,
            "CatDog Bed Plush" => 3,
            "Doggo Smooth Bone" => 2,
            "DoggyRoar Squik Bone" => 2,
            "Doggo Quality Food" => 1,
            "Fantastic Comfy Leash" => 4,
            "CatDog Toothpaste" => 5,
            "CatDog Leash" => 4,
            "Catxelent CatFood" => 1,
            "DoggyRoar Dog Food" => 1,
        );

        foreach ($products as $name => $category) {
            $price = ($faker->numberBetween(500, 2000));
            $product = Product::create([
                'product_name' => $name,
                'category_id' => $category,
                'cost_price' => $price,
                'sell_price' => (float)$price + 200,
                'description' => $faker->realText($maxNbChars = 100, $indexSize = 2),
            ]);

            $random_stock = $faker->numberBetween(50, 200);
            Stock::create([
                'product_id' => $product->id,
                'stock' => $random_stock,
            ]);
        }
    }
}
