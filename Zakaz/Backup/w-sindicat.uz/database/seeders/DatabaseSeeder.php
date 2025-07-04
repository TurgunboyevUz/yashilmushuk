<?php

namespace Database\Seeders;

use App\Models\User;
// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        User::create([
            'name' => 'Faxriddin',
            'email' => 'admin@sindicat.uz',
            'password' => Hash::make('password'),
        ]);

        $this->call([
            BannerSeeder::class,
            SocialSeeder::class,
            VideoSeeder::class,
            YouTubeSeeder::class,
        ]);
    }
}
