<?php

namespace Database\Seeders;

use App\Models\Product\Color;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class ColorSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $colors = [
            ['name' => 'Qizil', 'code' => '#FF0000'],
            ['name' => 'Yashil', 'code' => '#00FF00'],
            ['name' => 'Ko\'k', 'code' => '#0000FF'],
            ['name' => 'Sariq', 'code' => '#FFFF00'],
            ['name' => 'Kobalt', 'code' => '#00FFFF'],
            ['name' => 'Magenta', 'code' => '#FF00FF'],
            ['name' => 'Apelsin', 'code' => '#FFA500'],
            ['name' => 'Shokolad', 'code' => '#800080'],
            ['name' => 'Gul', 'code' => '#FFC0CB'],
            ['name' => 'Tug\'ma', 'code' => '#A52A2A'],
            ['name' => 'Kulrang', 'code' => '#808080'],
            ['name' => 'Qora', 'code' => '#000000'],
        ];

        Color::insert($colors);
    }
}
