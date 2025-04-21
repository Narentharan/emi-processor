<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Support\Facades\Hash;
// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // User::factory(10)->create();
        \App\Models\User::truncate();

        User::factory()->create([
            'name' => 'developer',
            'email' => 'developer@example.com',
            'password' => Hash::make('Test@Password123#')
        ]);

        $this->call([
            LoanDetailsSeeder::class,
        ]);
    }
}
