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
        // Delete the user if it exists
        \App\Models\User::where('email', 'test@example.com')->delete();
    
        // Create a user with a default role, e.g., 'regular'
        User::factory()->create([
            'name' => 'Test User',
            'email' => 'test@example.com',
            'role' => 'regular', // Assigning 'regular' role
        ]);
    
        $this->call([
            CategorySeeder::class,
            LabelSeeder::class,
        ]);
    }
}
