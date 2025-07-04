<?php

namespace Database\Seeders;

use App\Models\Criteria\Category;
use Illuminate\Database\Seeder;

class CriteriaSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $criterias = [
            [
                'name' => 'Maqolalar uchun',
                'code' => 'article',
                'criterias' => [
                    [
                        'name' => 'Maqola Xalqaro',
                        'code' => 'international_article',
                        'score' => 5,
                    ],
                    [
                        'name' => 'Maqola Mahalliy',
                        'code' => 'national_article',
                        'score' => 4,
                    ],
                    [
                        'name' => 'Tezis Mahalliy',
                        'code' => 'tezis_national',
                        'score' => 2,
                    ],
                    [
                        'name' => 'Tezis Xalqaro',
                        'code' => 'tezis_international',
                        'score' => 3,
                    ],
                    [
                        'name' => 'SCOPUS',
                        'code' => 'scopus',
                        'score' => 20,
                    ],
                ],
            ],

            [
                'name' => 'Stipendiyalar',
                'code' => 'scholarship',
                'criterias' => [
                    [
                        'name' => 'Institut',
                        'code' => 'institute',
                        'score' => 10,
                    ],
                    [
                        'name' => 'Viloyat',
                        'code' => 'regional',
                        'score' => 15,
                    ],
                    [
                        'name' => 'Respublika',
                        'code' => 'republic',
                        'score' => 20,
                    ],
                ],
            ],

            [
                'name' => 'Olimpiadalar',
                'code' => 'olympics',
                'criterias' => [
                    [
                        'name' => 'Institut bosqichi',
                        'code' => 'institute',
                        'score' => 15,
                    ],
                    [
                        'name' => 'Viloyat bosqichi',
                        'code' => 'regional',
                        'score' => 20,
                    ],
                    [
                        'name' => 'Respublika bosqichi',
                        'code' => 'republic',
                        'score' => 25,
                    ],
                    [
                        'name' => 'Xalqaro bosqich',
                        'code' => 'international',
                        'score' => 30,
                    ],
                ],
            ],

            [
                'name' => 'Ixtiro, DGU, Foydali model',
                'code' => 'invention',
                'criterias' => [
                    [
                        'name' => 'Ixtiro',
                        'code' => 'invention',
                        'score' => 30,
                    ],
                    [
                        'name' => 'Foydali model',
                        'code' => 'model',
                        'score' => 20,
                    ],
                    [
                        'name' => 'DGU',
                        'code' => 'dgu',
                        'score' => 10,
                    ],
                    [
                        'name' => 'Sanoat namunasi',
                        'code' => 'industry',
                        'score' => 5,
                    ],
                    [
                        'name' => 'Seleksiya yutuqlari',
                        'code' => 'selection',
                        'score' => 5,
                    ],
                    [
                        'name' => 'Tovar belgisi',
                        'code' => 'product',
                        'score' => 5,
                    ],
                ],
            ],

            [
                'name' => 'Start up, Tanlov',
                'code' => 'startup',
                'criterias' => [
                    [
                        'name' => 'Institut bosqichi',
                        'code' => 'institute',
                        'score' => 15,
                    ],
                    [
                        'name' => 'Viloyat bosqichi',
                        'code' => 'regional',
                        'score' => 20,
                    ],
                    [
                        'name' => 'Respublika bosqichi',
                        'code' => 'republic',
                        'score' => 25,
                    ],
                    [
                        'name' => 'Xalqaro bosqich',
                        'code' => 'international',
                        'score' => 30,
                    ],
                ],
            ],

            [
                'name' => "Grant, Xo'jalik shartnomalar",
                'code' => 'grand-economy',
                'criterias' => [
                    [
                        'name' => "Xo'jalik shartnoma",
                        'code' => 'economic',
                        'score' => 10,
                    ],
                    [
                        'name' => 'Grand',
                        'code' => 'grand',
                        'score' => 15,
                    ],
                ],
            ],

            [
                'name' => 'Til sertifikati',
                'code' => 'lang-certificate',
                'criterias' => [
                    [
                        'name' => 'B1',
                        'code' => 'b1',
                        'score' => 10,
                    ],
                    [
                        'name' => 'B2',
                        'code' => 'b2',
                        'score' => 15,
                    ],
                    [
                        'name' => 'C1',
                        'code' => 'c1',
                        'score' => 20,
                    ],
                    [
                        'name' => 'C2',
                        'code' => 'c2',
                        'score' => 30,
                    ],
                ],
            ],

            [
                'name' => "O'quv yil davomidagi boshqa yutuqlari",
                'code' => 'achievement',
                'criterias' => [
                    [
                        'name' => 'Institut miqyosida',
                        'code' => 'institute',
                        'score' => 3,
                    ],
                    [
                        'name' => 'Viloyat miqyosida',
                        'code' => 'regional',
                        'score' => 6,
                    ],
                    [
                        'name' => 'Respublika miqyosida',
                        'code' => 'republic',
                        'score' => 12,
                    ],
                    [
                        'name' => 'Xalqaro miqyosida',
                        'code' => 'international',
                        'score' => 20,
                    ],
                ],
            ],
        ];

        foreach ($criterias as $criteria) {
            $category = Category::create([
                'name' => $criteria['name'],
                'code' => $criteria['code'],
            ]);

            foreach ($criteria['criterias'] as $criterion) {
                $category->criterias()->create([
                    'name' => $criterion['name'],
                    'code' => $criterion['code'],
                    'score' => $criterion['score'],
                ]);
            }
        }
    }
}
