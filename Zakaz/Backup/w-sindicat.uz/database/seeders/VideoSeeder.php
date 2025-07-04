<?php

namespace Database\Seeders;

use App\Models\Video;
use Illuminate\Database\Seeder;

class VideoSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $data = [
            [
                'name' => 'Asosiy (1)',
                'key' => 'main-1',
                'video' => '',
            ],
            [
                'name' => 'Asosiy (2)',
                'key' => 'main-2',
                'video' => '',
            ],
            [
                'name' => 'Biz haqimizda',
                'key' => 'about',
                'video' => '',
            ],
        ];

        Video::insert($data);
    }
}
