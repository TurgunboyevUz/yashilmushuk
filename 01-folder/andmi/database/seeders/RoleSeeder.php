<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Role;

class RoleSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $roles = [
            'student' => 'Talaba',
            'teacher' => 'O\'qituvchi',
            'dean' => 'Dekan',
            'inspeksiya' => 'Ta\'lim sifat inspeksiyasi',
            'talent' => 'Iqtidor bo\'limi',
        ];

        foreach ($roles as $name => $label) {
            Role::create(['name' => $name, 'label' => $label]);
        }
    }
}
