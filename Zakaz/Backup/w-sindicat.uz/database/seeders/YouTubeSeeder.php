<?php

namespace Database\Seeders;

use App\Models\YouTube;
use Illuminate\Database\Seeder;

class YouTubeSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $data = [
            [
                'name' => 'Qo\'shimcha video',
                'url' => 'https://www.youtube.com/watch?v=dQw4w9WgXcQ',
            ],
            [
                'name' => 'Qo\'shimcha video',
                'url' => 'https://www.youtube.com/watch?v=dQw4w9WgXcQ',
            ],
            [
                'name' => 'Qo\'shimcha video',
                'url' => 'https://www.youtube.com/watch?v=dQw4w9WgXcQ',
            ],
            [
                'name' => 'Qo\'shimcha video',
                'url' => 'https://www.youtube.com/watch?v=dQw4w9WgXcQ',
            ],
            [
                'name' => 'Qo\'shimcha video',
                'url' => 'https://www.youtube.com/watch?v=dQw4w9WgXcQ',
            ],
        ];

        YouTube::insert($data);
    }
}
