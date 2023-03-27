<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Faker\Factory as faker;
use App\Models\Customer;
use App\Models\User;

require_once 'vendor/autoload.php';

class CustomerSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $faker = Faker::create();
        foreach (range(2, 21) as $index) {
            $first_name = $faker->firstName();
            $last_name = $faker->lastName();
            $cusname = $first_name . ' ' . $last_name;

            $user = User::create([
                'name' => $cusname,
                'email' => $faker->email(),
                'password' => bcrypt("password"),
                'role' => 'customer',
                'is_admin' => 0
            ]);

            Customer::create([
                'user_id' => $user->id,
                'fname' => $first_name,
                'lname' => $last_name,
                'addressline' => $faker->address(),
                'phone' => $faker->phoneNumber()
            ]);
        }
    }
}
