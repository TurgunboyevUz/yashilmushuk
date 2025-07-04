<?php
namespace Database\Seeders;

use App\Models\Page\Meta;
use Illuminate\Database\Seeder;

class MetaSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $metas = [
            //['Viewport', 'viewport', 'width=device-width, initial-scale=1.0'],
            ['Sarlavha', 'title', 'Texno Innovator'],
            ['Tavsif', 'description', 'Texno Innovator - Barcha turdagi plastmassa mahsulotlar va xo\'jalik mollari'],
            ['Kalit so\'zlar', 'keywords', 'texno, innovator, plastmassa mahsulotlar, mahsulotlar, texnologiyalar, yangiliklar, gul tuvaklar, plastmassa paqirlar, plastmassa tuvaklar, yashik'],
            ['Muallif', 'author', 'Anvarov Oyatillo'],
            ['Robotlar', 'robots', 'index, follow'],
            ['Google Bot', 'googlebot', 'index, follow'],
            ['Qayta tashrif', 'revisit-after', '1 days'],
            ['Til', 'language', 'Uzbek (uz)'],
            ['Copyright', 'copyright', 'Texno Innovator, 2025'],
            ['Tarqatma', 'distribution', 'Global'],
            ['Reyting', 'rating', 'General'],
            ['Tugash vaqti', 'expires', 'never'],
            ['Mazvu rangi', 'theme-color', '#ff9900'],
            ['OG Sarlavha', 'og:title', 'Texno Innovator'],
            ['OG Tavsif', 'og:description', 'Texno Innovator - Barcha turdagi plastmassa mahsulotlarini ishlab chiqarish va buyurtma asosida tayyorlab berish'],
            ['OG Rasm', 'og:image', '{{ asset(\'img/logo/1000x300.jpg\') }}'],
            ['OG Rasm turi', 'og:image:type', 'image/jpeg'],
            ['OG Rasm eni', 'og:image:width', '1000'],
            ['OG Rasm uzunligi', 'og:image:height', '300'],
            ['OG Havola', 'og:url', 'https://texno-innovator.uz/'],
            ['OG Turi', 'og:type', 'website'],
            ['OG lokalizatsiya', 'og:locale', 'uz_UZ'],
        ];

        foreach ($metas as $meta) {
            Meta::create([
                'label' => $meta[0],
                'key' => $meta[1],
                'value' => $meta[2],
            ]);
        }
    }
}
