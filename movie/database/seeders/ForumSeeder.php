<?php

namespace Database\Seeders;

use App\Models\Forum;
use Illuminate\Database\Seeder;

class ForumSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $data = [
            [
                'tele_id' => '-1001612270534',
                'title' => 'SARIKMBET APK',
                'username' => 'sarikmbet',
                'link' => 'https://t.me/sarikmbet',
                'by_username' => 1,
                'invitable' => 0,
            ],
            [
                'tele_id' => '-1001469430503',
                'title' => 'KAZINO UZ',
                'username' => 'aviator_omad',
                'link' => 'https://t.me/aviator_omad',
                'by_username' => 1,
                'invitable' => 0,
            ],
            [
                'tele_id' => '-1001612270534',
                'title' => 'Instagram',
                'username' => '',
                'link' => 'https://www.instagram.com/jr.sarikmedia/profilecard/?igsh=cG92bDM2aWtzYzVt',
                'by_username' => 1,
                'invitable' => 0,
            ],
            [
                'tele_id' => '-1002489944813',
                'title' => '🍀 Sarik Media 🍀',
                'username' => 'sarikmedia',
                'link' => 'https://t.me/+gQXSle9ujCQwMzYy',
                'by_username' => 1,
                'invitable' => 1,
            ],
        ];

        Forum::insert($data);
    }
}
