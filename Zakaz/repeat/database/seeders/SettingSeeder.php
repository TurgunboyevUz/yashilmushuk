<?php

namespace Database\Seeders;

use App\Models\Setting;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class SettingSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $data = [
            [
                'name' => "Speaking fayllar o'chirish vaqti",
                'key' => 'delete_speaking_files_interval',
                'value' => '7' //days
            ]
        ];

        Setting::upsert($data, ['key']);
    }
}
