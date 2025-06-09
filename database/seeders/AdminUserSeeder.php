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
        if(!user::where('email', 'MlQ2d@example.com')->exists()){
             //
        User::create([
            'name' => 'Admin',
            'email' => 'MlQ2d@example.com',
            'password' => Hash::make('password'),
            'role' => 'admin',
            
        ]);
            
        }
       
    }
}
