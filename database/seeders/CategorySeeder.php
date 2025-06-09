<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Category;
use App\Models\Label;

class CategorySeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        //
        Category::insert([
            ['name' => 'Bug'],
            ['name' => 'Feature Request'],
            ['name' => 'UI/UX']
        ]);
        
        Label::insert([
            ['name' => 'Urgent'],
            ['name' => 'Client'],
            ['name' => 'Internal']
        ]);
        
    }
}
