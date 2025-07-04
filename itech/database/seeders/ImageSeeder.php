<?php

namespace Database\Seeders;

use App\Models\Page\Image;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Storage;

class ImageSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Storage::disk('public')->makeDirectory('images');

        copy(public_path('img/logo/1000x300.jpg'), storage_path('app/public/images/logo.jpg')); // Logo
        copy(public_path('img/logo/1112.png'), storage_path('app/public/images/loader.png')); // Loader
        copy(public_path('img/banner/1680X960.jpg'), storage_path('app/public/images/about.jpg')); // Biz haqimizda

        copy(public_path('img/1680x980.png'), storage_path('app/public/images/slider1.jpg')); // Slider
        copy(public_path('img/slide2.jpg'), storage_path('app/public/images/slider2.jpg')); // Slider

        $images = [
            ['logo', 'Asosiy logo', 'Asosiy logo', 'images/logo.jpg'],
            ['loader', 'Loader', 'Loader', 'images/loader.png'],
            ['about', 'Biz haqimizda', 'Biz haqimizda', 'images/about.jpg'],
            ['slider', 'Slider 1', 'Slider 1', 'images/slider1.jpg'],
            ['slider', 'Slider 2', 'Slider 2', 'images/slider2.jpg'],
        ];

        foreach ($images as $image) {
            Image::create([
                'key' => $image[0],
                'name' => $image[1],
                'alt' => $image[2],
                'path' => $image[3],
            ]);
        }
    }
}
