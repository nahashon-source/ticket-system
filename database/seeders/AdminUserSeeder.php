<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\User;
use Illuminate\Support\Facades\Hash;



class AdminUserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Create Super Admin
        if (!User::where('email', 'admin@example.com')->exists()) {
            User::create([
                'name' => 'Super Admin',
                'email' => 'admin@example.com',
                'password' => Hash::make('password123'),
                'role' => 'admin',
            ]);
            
            echo "Super Admin created: admin@example.com / password123\n";
        }
        
        // Create Regular Admin
        if (!User::where('email', 'admin2@example.com')->exists()) {
            User::create([
                'name' => 'Admin User',
                'email' => 'admin2@example.com',
                'password' => Hash::make('admin123'),
                'role' => 'admin',
            ]);
            
            echo "Admin User created: admin2@example.com / admin123\n";
        }
        
        // Create Test User
        if (!User::where('email', 'user@example.com')->exists()) {
            User::create([
                'name' => 'Test User',
                'email' => 'user@example.com',
                'password' => Hash::make('user123'),
                'role' => 'user',
            ]);
            
            echo "Test User created: user@example.com / user123\n";
        }
    }
}
