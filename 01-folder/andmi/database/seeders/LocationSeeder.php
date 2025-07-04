<?php

namespace Database\Seeders;

use App\Models\Auth\Location;
use Illuminate\Database\Seeder;

class LocationSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Location::insert([
            [
                'name' => 'Andijon',
            ],
            [
                'name' => 'Buxoro',
            ],
            [
                'name' => 'Farg\'ona',
            ],
            [
                'name' => 'Jizzax',
            ],
            [
                'name' => 'Xorazm',
            ],
            [
                'name' => 'Namangan',
            ],
            [
                'name' => 'Navoiy',
            ],
            [
                'name' => 'Qashqadaryo',
            ],
            [
                'name' => 'Samarqand',
            ],
            [
                'name' => 'Sirdaryo',
            ],
            [
                'name' => 'Surxondaryo',
            ],
            [
                'name' => 'Toshkent',
            ],
            [
                'name' => 'Qoraqalpog\'iston Respublikasi',
            ],
        ]);
    }
}
