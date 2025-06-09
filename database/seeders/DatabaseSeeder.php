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
    
        User::factory()->create([
            'name' => 'Test User',
            'email' => 'test@example.com',
        ]);
    
        $this->call([
            CategorySeeder::class,
            LabelSeeder::class,
        ]);
    }
}
