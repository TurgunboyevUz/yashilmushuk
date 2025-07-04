<?php

namespace Database\Seeders;

use App\Models\Banner;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Storage;

class BannerSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $data = [
            [
                'name' => 'Asosiy 1',
                'key' => 'main1',
                'image' => '',
            ],
            [
                'name' => 'Asosiy 2',
                'key' => 'main2',
                'image' => '',
            ],
            [
                'name' => 'Biz haqimizda',
                'key' => 'about',
                'image' => '',
            ],
            [
                'name' => 'Katalog',
                'key' => 'catalog',
                'image' => '',
            ],
            [
                'name' => 'Xizmatlar',
                'key' => 'services',
                'image' => '',
            ],
            [
                'name' => 'Savollar',
                'key' => 'faq',
                'image' => '',
            ],
            [
                'name' => 'Kontaktlar',
                'key' => 'contacts',
                'image' => '',
            ],
            [
                'name' => 'Footer 1',
                'key' => 'footer1',
                'image' => 'banners/footer1.png',
            ],
            [
                'name' => 'Footer 2',
                'key' => 'footer2',
                'image' => 'banners/footer1.png',
            ],
        ];

        Storage::disk('public')->delete('banners');

        $files = [
            public_path('assets/Sectionfooter1.png') => 'banners/footer1.png',
            public_path('assets/Sectionfooter2.png') => 'banners/footer2.png',
        ];

        foreach ($files as $from => $to) {
            Storage::disk('public')->put($to, file_get_contents($from));
        }

        Banner::insert($data);
    }
}
