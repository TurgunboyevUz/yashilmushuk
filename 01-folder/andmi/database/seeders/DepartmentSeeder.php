<?php

namespace Database\Seeders;

use App\Enums\StructureType;
use App\Models\Auth\Department;
use Illuminate\Database\Seeder;

class DepartmentSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $data = json_decode(file_get_contents(storage_path('hemis/department.json')), true);

        foreach ($data['data']['items'] as $item) {
            Department::firstOrCreate(['code' => $item['code']], [
                'name' => $item['name'],

                'structure_type' => $item['structureType']['name'],
                'structure_code' => $item['structureType']['code'],
            ]);
        }

        $data = json_decode(file_get_contents(storage_path('hemis/faculty.json')), true);

        foreach ($data['data']['items'] as $item) {
            $faculty = Department::firstOrCreate(['code' => $item['code']], [
                'name' => $item['name'],

                'structure_type' => $item['structureType']['name'],
                'structure_code' => $item['structureType']['code'],
            ]);

            Department::where('code', 'like', "%{$faculty->code}%")
                ->where('structure_code', StructureType::DEPARTMENT->value)
                ->update(['parent_id' => $faculty->id]);
        }
    }
}
