<?php

namespace Database\Seeders;

use App\Models\Social;
use Illuminate\Database\Seeder;

class SocialSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $data = [
            [
                'name' => 'Telegram',
                'key' => 'telegram',
                'value' => 'https://t.me/',
                'icon' => 'fab fa-telegram', // Updated class
                'color' => '#0088CC',
                'status' => true,
            ],
            [
                'name' => 'Whatsapp',
                'key' => 'whatsapp',
                'value' => 'https://wa.me/',
                'icon' => 'fab fa-whatsapp', // Correct class
                'color' => '#25D366',
                'status' => true,
            ],
            [
                'name' => 'Facebook',
                'key' => 'facebook',
                'value' => 'https://www.facebook.com/',
                'icon' => 'fab fa-facebook-f', // Updated class (or use 'fab fa-facebook' for full logo)
                'color' => '#1877F2',
                'status' => true,
            ],
            [
                'name' => 'Instagram',
                'key' => 'instagram',
                'value' => 'https://www.instagram.com/',
                'icon' => 'fab fa-instagram', // Correct class
                'color' => '#E1306C',
                'status' => true,
            ],
            [
                'name' => 'Pinterest',
                'key' => 'pinterest', // Corrected key spelling
                'value' => 'https://pinterest.com/',
                'icon' => 'fab fa-pinterest', // Updated class
                'color' => '#E60023',
                'status' => false,
            ],
            [
                'name' => 'YouTube',
                'key' => 'youtube',
                'value' => 'https://www.youtube.com/',
                'icon' => 'fab fa-youtube', // Updated class
                'color' => '#FF0000',
                'status' => true,
            ],
            [
                'name' => 'TikTok',
                'key' => 'tiktok',
                'value' => 'https://www.tiktok.com/',
                'icon' => 'fab fa-tiktok', // Updated class
                'color' => '#25F4EE',
                'status' => true,
            ],
            [
                'name' => 'Telefon raqami',
                'key' => 'phone',
                'value' => 'tel:+998',
                'icon' => 'fas fa-phone', // Updated class
                'color' => '#34B7F1',
                'status' => false,
            ],
        ];

        Social::insert($data);
    }
}
