<?php

namespace Database\Seeders;

use App\Models\Page\Advantage;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class AdvantageSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $advantages = [
            ['fa-recycle', "Atrof-muhit himoyasi"],
            ['fa-industry', "Sifatli mahsulotlar"],
            ['fa-truck', "Tez yetkazib berish"],
            ['fa-phone-volume', "24/7 Mijozlar bilan bog'lanish"]
        ];

        foreach ($advantages as $advantage) {
            Advantage::create([
                'icon' => $advantage[0],
                'content' => $advantage[1],
            ]);
        }
    }
}
