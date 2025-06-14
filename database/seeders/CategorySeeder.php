<?php

namespace Database\Seeders;

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
        // Seed categories safely
        $categories = ['Bug', 'Feature Request', 'UI/UX'];
        foreach ($categories as $categoryName) {
            Category::updateOrCreate(['name' => $categoryName]);
        }

        // Seed labels safely
        $labels = ['Urgent', 'Client', 'Internal'];
        foreach ($labels as $labelName) {
            Label::updateOrCreate(['name' => $labelName]);
        }
    }
}
