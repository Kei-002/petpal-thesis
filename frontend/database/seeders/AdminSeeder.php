<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Employee;
use Faker\Factory as faker;
use App\Models\User;

class AdminSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $faker = Faker::create();
        User::create([
            'name' => 'Admin Account',
            'email' => 'admin@admin.com',
            'password' => bcrypt("password"),
            'role' => 'admin',
            'is_admin' => 1
        ]);

        Employee::create([
            'user_id' => 1,
            'fname' => 'Admin',
            'lname' => 'Account',
            'phone' => $faker->phoneNumber(),
            'addressline' => $faker->address()
        ]);
    }
}
