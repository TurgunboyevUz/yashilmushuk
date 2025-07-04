<?php

namespace Database\Seeders;

use App\Models\User;
// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        Storage::disk('public')->deleteDirectory('categories');
        Storage::disk('public')->deleteDirectory('products');
        Storage::disk('public')->deleteDirectory('images');
        Storage::disk('public')->deleteDirectory('blogs');

        User::create([
            'name' => 'Admin',
            'email' => 'admin@texno-innovator.uz',
            'password' => Hash::make('password'),
        ]);

        $this->call([
            MetaSeeder::class,
            ImageSeeder::class,
            AboutSeeder::class,
            AdvantageSeeder::class,
            SizeSeeder::class,
            ColorSeeder::class,
        ]);
    }
}
