<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $data = json_decode(file_get_contents(storage_path('hemis/talent.json')), true);

        $basic = $data['data']['items'][0];
        $user = User::firstOrCreate(['hemis_id' => $basic['employee_id_number']]);

        $user->assignRole('talent');
    }
}
