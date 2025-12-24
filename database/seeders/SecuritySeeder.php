<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class SecuritySeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        for ($i=1; $i < 10; $i++) {
            User::create([
                'name' => 'security0' . $i+1,
                'age' => 30,
                'sex' => rand(0, 1),
                'phone_number' => fake()->phoneNumber(),
                'nrc_number' => fake()->text(),
                'edu_background' => fake()->text(),
                'position' => fake()->text(),
                'department' => fake()->text(),
                'address' => fake()->address(),
                'email' => 'security0' . $i+1 . "@gmail.com",
                'password' => Hash::make('ILU@2024'),
                'is_admin' => 2 // security
            ]);
        }
    }
}
