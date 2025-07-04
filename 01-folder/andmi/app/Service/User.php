<?php

namespace App\Service;

use App\Models\Auth\Department;
use App\Models\Auth\Direction;
use App\Models\Auth\Employee;
use App\Models\Auth\Faculty;
use App\Models\Auth\Gender;
use App\Models\Auth\Group;
use App\Models\Auth\Nation;
use App\Models\Auth\Specialty;
use App\Models\Auth\Student;
use App\Models\User as UserModel;
use App\Utils\Hemis;
use Carbon\Carbon;
use Illuminate\Support\Arr;
use Illuminate\Support\Facades\Storage;
use Spatie\Permission\Models\Role;

class User
{
    public function __construct()
    {}

    public function user(array $response)
    {
        $hemis_id = $response['student_id_number'] ?? $response['employee_id_number'];
        $name = $response['firstname'];
        $surname = $response['surname'];
        $patronymic = $response['patronymic'];
        $short_name = $response['data']['short_name'] ?? $surname . '.' . $name[0] . '.' . $patronymic[0];
        $phone = $response['phone'];
        $email = $response['email'];
        $passport_number = $response['passport_number'];
        $passport_pin = $response['passport_pin'];
        $birth_date = Carbon::parse($response['birth_date'])->format('Y-m-d');
        $picture_path = '';

        $user = UserModel::firstOrCreate(['hemis_id' => $hemis_id], compact('hemis_id', 'name', 'surname', 'patronymic', 'short_name', 'phone', 'email', 'birth_date', 'passport_number', 'passport_pin', 'picture_path'));

        $picture_path = $this->picture($response, $user);

        $user->update(compact('name', 'surname', 'patronymic', 'short_name', 'picture_path'));

        if ($response['type'] == 'student') {
            $this->student($response, $user);

            $redirect = 'student.dashboard';
        } else {
            $role = $this->employee($response, $user);

            $redirect = 'employee.' . $role . '.dashboard';
        }

        return compact('user', 'redirect');
    }

    public function student(array $response, $user)
    {
        $level = str_replace('-kurs', '', $response['data']['level']['name']);
        $address = $response['data']['address'];

        $student = Student::updateOrCreate(['user_id' => $user->id], [
            'faculty_id' => $this->faculty($response),
            'direction_id' => $this->direction($response),
            'group_id' => $this->group($response),
            'address' => $address,
            'level' => $level,
        ]);

        $hemis = new Hemis(config('oauth.token'));
        $items = $hemis->student($user->hemis_id, $response['passport_pin']);

        $user->update([
            'gender_id' => $this->gender($items),
            'nation_id' => $this->nation($response),
        ]);

        $user->syncRoles(['student']);
    }

    public function employee(array $response, $user)
    {
        $employee = Employee::firstOrCreate(
            ['user_id' => $user->id]);

        $hemis = new Hemis(config('oauth.token'));
        $items = $hemis->employee($user->hemis_id, $response['passport_pin'], $response['passport_number']);

        $user->update([
            'gender_id' => $this->gender($items),
            'nation_id' => $this->nation($response),
        ]);

        foreach ($items as $item) {
            $this->department($item, $employee);
        }

        $arr = Arr::pluck($response['roles'], 'code');
        $roles = Role::whereIn('name', $arr)->pluck('name')->toArray();

        if ($user->hasRole('talent')) {
            $roles[] = 'talent';
        }

        $user->syncRoles($roles);

        return $arr[0];
    }

    public function mkdir($name)
    {
        if (!is_dir($name)) {
            return mkdir($name);
        }
    }

    public function picture(array $response, $user)
    {
        $this->mkdir(storage_path('app/public/profile'));

        $not_change = explode(',', env('NOT_CHANGE_USER_IMAGE'));

        if(in_array($user->hemis_id, $not_change)) {
            return $user->picture_path;
        }

        if ($user->picture_path) {
            Storage::disk('public')->delete($user->picture_path);
        }

        $picture = file_get_contents($response['picture']);
        $picture_path = 'profile/image_' . now()->format('d-m-Y') . '_' . uniqid(true) . '.jpg';

        Storage::disk('public')->put($picture_path, $picture);

        return $picture_path;
    }

    public function nation(array $response)
    {
        $nation = Nation::firstOrCreate(['name' => 'O‘zbek']);

        return $nation->id;
    }

    public function gender(array $response)
    {
        $gender = Gender::where('code', $response[0]['gender']['code'])->first();

        return $gender->id;
    }

    public function faculty(array $response)
    {
        $faculty = Department::firstOrCreate(
            ['code' => $response['data']['faculty']['code']],
            [
                'name' => $response['data']['faculty']['name'],
                'structure_type' => $response['data']['faculty']['structureType']['name'],
                'structure_code' => $response['data']['faculty']['structureType']['code'],
            ]);

        return $faculty->id;
    }

    public function direction(array $response)
    {
        $direction = Direction::firstOrCreate(['code' => $response['data']['specialty']['code']], ['name' => $response['data']['specialty']['name']]);

        return $direction->id;
    }

    public function group(array $response)
    {
        $group = Group::firstOrCreate(['name' => $response['data']['group']['name']]);

        return $group->id;
    }

    public function specialty(array $response)
    {
        $name = (empty($response['specialty'])) ? "Mavjud emas" : $response['specialty'];
        $specialty = Specialty::firstOrCreate(['name' => ucfirst($name)]);

        return $specialty->id;
    }

    public function department(array $response, $employee)
    {
        $role = $this->role($response['employee_type']['name'], $response['staff_position']['name']);

        if (!$role) {return;}

        if ($role == 'teacher') {
            $employee->update(['specialty_id' => $this->specialty($response)]);
        }

        $department = Department::firstOrCreate(
            ['code' => $response['department']['code']],
            ['name' => $response['department']['name']]
        );

        $role_id = Role::where('name', $role)->first()->id;

        if ($employee->departments()->where('department_id', $department->id)->where('role_id', $role_id)->exists()) {return;}

        $employee->departments()->attach($department->id, [
            'role_id' => $role_id,

            'employee_type' => $response['employee_type']['name'],
            'employee_code' => $response['employee_type']['code'],

            'staff_code' => $response['staff_position']['code'],
            'staff_position' => $response['staff_position']['name'],
        ]);

        if($role == 'teacher' and $department->faculty()->exists()){
            $employee->departments()->attach($department->faculty->id, [
                'role_id' => $role_id,

                'employee_type' => $response['employee_type']['name'],
                'employee_code' => $response['employee_type']['code'],

                'staff_code' => $response['staff_position']['code'],
                'staff_position' => $response['staff_position']['name'],
            ]);
        }
    }

    public function role($employee_type, $staff_position)
    {
        $keys = [
            'teacher' => ['o‘qituvchi', 'dotsent'],
            'dean' => ['dekan'],
            'inspeksiya' => ['inspeksiya'],
        ];

        foreach ($keys as $key => $value) {
            foreach ($value as $val) {
                if (mb_stripos($staff_position, $val) !== false or mb_stripos($employee_type, $val) !== false) {
                    return $key;
                }
            }
        }

    }
}
