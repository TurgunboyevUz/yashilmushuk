<?php

namespace Database\Seeders;

use App\Models\Criteria\EducationYear;
use Illuminate\Database\Seeder;

class EducationYearSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        EducationYear::insert([
            [
                'name' => '2024-2025',
                'status' => true,
                'is_current' => true
            ],
            [
                'name' => '2025-2026',
                'status' => false,
                'is_current' => false
            ],
            [
                'name' => '2026-2027',
                'status' => false,
                'is_current' => false
            ],
            [
                'name' => '2027-2028',
                'status' => false,
                'is_current' => false
            ],
        ]);
    }
}