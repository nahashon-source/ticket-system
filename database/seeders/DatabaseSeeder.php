<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // Safely create or update the test user
        User::updateOrCreate(
            ['email' => 'test@example.com'],
            [
                'name' => 'Test User',
                'role' => 'regular',
                'password' => bcrypt('password')  // optional default password
            ]
            
        );

        $this->call([
            CategorySeeder::class,
            LabelSeeder::class,
            AdminSeeder::class,
            PrioritySeeder::class,
            StatusSeeder::class,
            StatusesTableSeeder::class,
        ]);
    }
}
