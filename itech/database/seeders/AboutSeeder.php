<?php

namespace Database\Seeders;

use App\Models\Page\About;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class AboutSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $abouts = [
            ['Kompaniya haqida', 'company', ""],
            ['Biz haqimizda', 'about', "Barcha turdagi plastmassa mahsulotlarini ishlab chiqarish va buyurtma asosida tayyorlab berish."],
            ['Joylashuv', 'address', "Andijon viloyati Andijon tuman Oq-Yor QFY Naymanobod MFY Temiryo'l ko'cha-2"],
            ['Email', 'email', "info@texno-innovator.uz"],
            ['Telefon', 'phone', "+998 99 444 70 99"],
            ['Xarita havolasi', 'map', "https://www.google.com/maps/embed?pb=!1m17!1m12!1m3!1d483.0710579687439!2d72.32730929872279!3d40.81423799871108!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m2!1m1!2zNDDCsDQ4JzUxLjMiTiA3MsKwMTknMzguOSJF!5e0!3m2!1suz!2s!4v1705500774120!5m2!1suz!2s"],
            ['Instagram', 'instagram', "https://www.instagram.com/texno_innovator/"],
            ['Telegram', 'telegram', "https://t.me/texnoplast_1"],
            ['Whatsapp', 'whatsapp', "https://api.whatsapp.com/send?phone=+998994447099"],
            ['Youtube', 'youtube', "https://www.youtube.com/channel/UCW2kDnLj3nQZkOq6Cq2Wkxw"],
        ];

        foreach ($abouts as $about) {
            About::create([
                'label' => $about[0],
                'key' => $about[1],
                'value' => $about[2],
            ]);
        }
    }
}
