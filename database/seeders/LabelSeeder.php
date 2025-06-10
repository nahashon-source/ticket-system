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
        DB::table('labels')->truncate();

        Label::insert([
            ['name' => 'Urgent'],
            ['name' => 'Client'],
            ['name' => 'Internal']
        ]);
    }
}
