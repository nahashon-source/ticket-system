<?php

namespace Database\Seeders;

use App\Models\Label;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB; // ✅ this was missing

class LabelSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::statement('SET FOREIGN_KEY_CHECKS=0;');
        \App\Models\Label::truncate();
        DB::statement('SET FOREIGN_KEY_CHECKS=1;');
    
        \App\Models\Label::updateOrCreate(['name' => 'Urgent']);
        \App\Models\Label::updateOrCreate(['name' => 'Client']);
        \App\Models\Label::updateOrCreate(['name' => 'Internal']);
        
    }
}
