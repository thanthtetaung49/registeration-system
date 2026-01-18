<?php

namespace Database\Seeders;

use App\Models\User;
// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {

        User::create([
            'name' => 'super admin',
            'age' => rand(20, 30),
            'gender' => 'male',
            'phone_number' => fake()->phoneNumber(),
            'nrc_number' => fake()->text(),
            'edu_background'=> fake()->text(),
            'position' => fake()->text(),
            'department' => fake()->text(),
            'address' => fake()->address(),
            'email' => 'superadmin@gmail.com',
            'password' => Hash::make('superadmin123'),
            'role' => 'super_admin' // super admin
        ]);

        User::create([
            'name' => 'admin',
            'age' => rand(20, 30),
            'gender' => 'male',
            'phone_number' => fake()->phoneNumber(),
            'nrc_number' => fake()->text(),
            'edu_background'=> fake()->text(),
            'position' => fake()->text(),
            'department' => fake()->text(),
            'address' => fake()->address(),
            'email' => 'admin@gmail.com',
            'password' => Hash::make('admin123'),
            'role' => 'admin' // admin
        ]);

        $this->call([
            SecuritySeeder::class
        ]);
    }
}
