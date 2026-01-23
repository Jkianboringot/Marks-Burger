<?php

namespace Database\Seeders;

use App\Models\Branch;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class BranchSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
     Branch::insert([
            ['location' => 'Calatagan', 'branch_type' => 'sub'],
            ['location' => 'San Andres', 'branch_type' => 'sub'],
            ['location' => 'San Juan', 'branch_type' => 'main']
        ]);
    }
}
