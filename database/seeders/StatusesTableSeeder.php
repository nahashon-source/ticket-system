<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Status;


class StatusesTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        //
        $statuses = [
            'Open',
            'In Progress',
            'Resolved',
            'Closed',
        ];

        foreach ($statuses as $status) {
            Status::updateOrCreate(['name' => $status]);
        }
    }
}
