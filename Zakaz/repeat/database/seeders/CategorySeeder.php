<?php

namespace Database\Seeders;

use App\Models\Category;
use Illuminate\Database\Seeder;

class CategorySeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Category::upsert([
            [
                'name' => 'Speaking',
                'code' => 'speaking',
                'image' => null,
            ],
            [
                'name' => 'Writing',
                'code' => 'writing',
                'image' => null,
            ],
        ], ['key']);
    }
}
