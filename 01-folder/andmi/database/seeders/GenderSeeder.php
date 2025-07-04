<?php

namespace Database\Seeders;

use App\Models\Auth\Gender;
use Illuminate\Database\Seeder;

class GenderSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Gender::insert([
            [
                'name' => 'Erkak',
                'code' => '11',
            ],
            [
                'name' => 'Ayol',
                'code' => '12',
            ],
        ]);
    }
}
