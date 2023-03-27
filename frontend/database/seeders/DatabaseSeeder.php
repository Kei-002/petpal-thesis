<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Database\Seeders\CustomerSeeder;
use Database\Seeders\AdminSeeder;
use Database\Seeders\PetSeeder;
use Database\Seeders\CategorySeeder;
use Database\Seeders\ServiceSeeder;
class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        // \App\Models\User::factory(10)->create();

        // \App\Models\User::factory()->create([
        //     'name' => 'Test User',
        //     'email' => 'test@example.com',
        // ]);

        $this->call(AdminSeeder::class);
        // $this->call(EmployeeSeeder::class);
        $this->call(CustomerSeeder::class);
        $this->call(PetSeeder::class);
        $this->call(CategorySeeder::class);
        $this->call(ServiceSeeder::class);
    }
}
