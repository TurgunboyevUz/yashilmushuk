<?php
namespace App\Service;

use App\Enums\CriteriaEnum;
use App\Enums\StructureType;
use App\Models\Auth\Department;
use App\Models\Auth\Faculty;
use App\Models\Auth\Student;
use App\Models\Pivot\DepartmentEmployee;
use Illuminate\Support\Facades\DB;
use Spatie\Permission\Models\Role;

class Rating
{
    public $user;
    public $role;

    public $get;
    public $type;

    public const STUDENT = 'student';
    public const TEACHER = 'teacher';

    public const ALL        = 'all';
    public const FACULTY    = 'faculty';
    public const DEPARTMENT = 'department';
    public const GROUP      = 'group';
    public const ATTACHED   = 'attached';

    public function __construct($user, $role = 'teacher')
    {
        $this->user = $user;
        $this->role = $role;
    }

    public function getRating($get = self::ALL, $type = self::STUDENT)
    {
        $this->get  = $get;
        $this->type = $type;

        return $this;
    }

    public function take($count = 3)
    {
        if ($this->get == self::ALL) {
            if ($this->type == self::STUDENT) {
                return $this->institute_students($count);
            }

            if ($this->type == self::TEACHER) {
                return $this->institute_teachers($count);
            }
        }

        if ($this->get == self::FACULTY) {
            if ($this->type == self::STUDENT) {
                return $this->faculty_students($count);
            }

            if ($this->type == self::TEACHER) {
                return $this->faculty_teachers($count);
            }
        }

        if ($this->get == self::DEPARTMENT) {
            return $this->department($count);
        }

        if ($this->get == self::GROUP) {
            return $this->group($count);
        }

        if ($this->get == self::ATTACHED) {
            return $this->attached_students($count);
        }
    }

    public function attached_students($count = Rating::ALL)
    {
        $students = $this->user->employee->students()->with([
            'user.student_files', 'employee', 'faculty', 'direction', 'group',

            'user.articles'          => fn($q)          => $q->select('user_id', 'criteria_id', DB::raw('COUNT(*) as count'))->groupBy('user_id', 'criteria_id'),
            'user.scholarships'      => fn($q)      => $q->select('user_id', 'criteria_id', DB::raw('COUNT(*) as count'))->groupBy('user_id', 'criteria_id'),
            'user.inventions'        => fn($q)        => $q->select('user_id', 'criteria_id', DB::raw('COUNT(*) as count'))->groupBy('user_id', 'criteria_id'),
            'user.startups'          => fn($q)          => $q->select('user_id', 'type', DB::raw('COUNT(*) as count'))->groupBy('user_id', 'type'),
            'user.grand_economies'   => fn($q)   => $q->select('user_id', 'criteria_id', DB::raw('COUNT(*) as count'))->groupBy('user_id', 'criteria_id'),
            'user.olympics'          => fn($q)          => $q->select('user_id', 'criteria_id', DB::raw('COUNT(*) as count'))->groupBy('user_id', 'criteria_id'),
            'user.lang_certificates' => fn($q) => $q->select('user_id', 'lang', DB::raw('COUNT(*) as count'))->groupBy('user_id', 'lang'),
            'user.achievements'      => fn($q)      => $q->select('user_id', DB::raw('COUNT(*) as count'))->groupBy('user_id'),
        ])->get();

        $students = $students->sortByDesc(function ($student) {
            return $student->user->student_files->sum('student_score');
        });

        $map = $students->map(function ($student) {
            return [
                'fio'          => $student->user->short_fio(),
                'picture_path' => $student->user->picture_path(),

                'level'        => $student->level,
                'group'        => $student->group->name,

                'teacher'      => $student->employee?->user->short_fio() ?? "Biriktirilmagan",
                'faculty'      => $student->faculty->name,
                'direction'    => $student->direction->name,
                'total_score'  => $student->user->student_files->sum('student_score'),

                'articles'     => [
                    'scopus' => $student->user->articles->where('criteria_id', CriteriaEnum::ARTICLE_SCOPUS->value)->first()->count ?? 0,
                    'local'  => $student->user->articles->where('criteria_id', CriteriaEnum::ARTICLE_LOCAL->value)->first()->count ?? 0,
                    'global' => $student->user->articles->where('criteria_id', CriteriaEnum::ARTICLE_GLOBAL->value)->first()->count ?? 0,
                    'thesis' => ($student->user->articles->where('criteria_id', CriteriaEnum::ARTICLE_THESIS_GLOBAL->value)->first()->count ?? 0) + ($student->user->articles->where('criteria_id', CriteriaEnum::ARTICLE_THESIS_LOCAL->value)->first()->count ?? 0),
                ],

                'scholarships' => [
                    'institute' => $student->user->scholarships->where('criteria_id', CriteriaEnum::SCHOLARSHIP_INSTITUTE->value)->first()->count ?? 0,
                    'region'    => $student->user->scholarships->where('criteria_id', CriteriaEnum::SCHOLARSHIP_REGION->value)->first()->count ?? 0,
                    'republic'  => $student->user->scholarships->where('criteria_id', CriteriaEnum::SCHOLARSHIP_REPUBLIC->value)->first()->count ?? 0,
                ],

                'inventions'   => [
                    'invention' => $student->user->inventions->where('criteria_id', CriteriaEnum::INVENTION_INV->value)->first()->count ?? 0,
                    'dgu'       => $student->user->inventions->where('criteria_id', CriteriaEnum::INVENTION_DGU->value)->first()->count ?? 0,
                    'model'     => $student->user->inventions->where('criteria_id', CriteriaEnum::INVENTION_MODEL->value)->first()->count ?? 0,
                ],

                'startups'     => [
                    'startup' => $student->user->startups->where('type', 'startup')->first()->count ?? 0,
                    'contest' => $student->user->startups->where('type', 'contest')->first()->count ?? 0,
                ],

                'grands'       => [
                    'grand'   => $student->user->grand_economies->where('criteria_id', CriteriaEnum::GRAND->value)->first()->count ?? 0,
                    'economy' => $student->user->grand_economies->where('criteria_id', CriteriaEnum::ECONOMY->value)->first()->count ?? 0,
                ],

                'olympics'     => [
                    'institute' => $student->user->olympics->where('criteria_id', CriteriaEnum::OLYMPIC_INSTITUTE->value)->first()->count ?? 0,
                    'region'    => $student->user->olympics->where('criteria_id', CriteriaEnum::OLYMPIC_REGION->value)->first()->count ?? 0,
                    'republic'  => $student->user->olympics->where('criteria_id', CriteriaEnum::OLYMPIC_REPUBLIC->value)->first()->count ?? 0,
                ],

                'lang'         => [
                    'ru' => $student->user->lang_certificates->where('lang', 'ru')->first()->count ?? 0,
                    'en' => $student->user->lang_certificates->where('lang', 'en')->first()->count ?? 0,
                    'de' => $student->user->lang_certificates->where('lang', 'de')->first()->count ?? 0,
                ],

                'achievements' => $student->user->achievements->first()->count ?? 0,
            ];
        });

        return $count == Rating::ALL ? $map : $map->take($count);
    }

    public function institute_students($count = Rating::ALL)
    {
        $students = Student::with(['user.student_files', 'employee', 'faculty', 'direction', 'group'])->get();

        $students = $students->sortByDesc(function ($student) {
            return $student->user->student_files->sum('student_score');
        });

        $map = $students->map(function ($student) {
            return [
                'fio'          => $student->user->short_fio(),
                'picture_path' => $student->user->picture_path(),

                'level'        => $student->level,
                'group'        => $student->group->name,

                'teacher'      => $student->employee?->user->short_fio() ?? "Biriktirilmagan",
                'faculty'      => $student->faculty->name,
                'direction'    => $student->direction->name,
                'total_score'  => $student->user->student_files->sum('student_score'),
            ];
        });

        return $count == Rating::ALL ? $map : $map->take($count);
    }

    public function institute_teachers($count = Rating::ALL)
    {
        $role     = Role::where('name', 'teacher')->first();
        $teachers = DepartmentEmployee::where('role_id', $role->id)->with(['employee.user.teacher_files', 'employee.students', 'employee.departments', 'employee.specialty'])->get();

        $teachers = $teachers->sortByDesc(function ($teacher) {
            return $teacher->employee->user->teacher_files->sum('teacher_score');
        });

        $teachers = $teachers->unique(function ($teacher) {
            return $teacher->employee_id . '-' . $teacher->role_id;
        });

        $map = $teachers->map(function ($teacher) use ($role) {
            $faculty    = $teacher->employee->departments->where('structure_code', StructureType::FACULTY->value)->where('pivot.role_id', $role->id)->first();
            $department = $teacher->employee->departments->where('structure_code', StructureType::DEPARTMENT->value)->where('pivot.role_id', $role->id)->first();

            return [
                'fio'            => $teacher->employee->user->short_fio(),
                'picture_path'   => $teacher->employee->user->picture_path(),
                'faculty'        => $faculty->name,
                'department'     => $department->name,
                'staff_position' => $department->pivot->staff_position,
                'specialty'      => $teacher->employee->specialty->name,
                'student_count'  => $teacher->employee->students->count(),
                'total_score'    => $teacher->employee->user->teacher_files->sum('teacher_score'),
            ];
        });

        return $count == Rating::ALL ? $map : $map->take($count);
    }

    public function faculty_students($count = Rating::ALL)
    {
        if ($this->role == 'student') {
            $department = $this->user->student->faculty;
        } else {
            $department = $this->user->employee->department($this->role, StructureType::FACULTY->value);
        }

        $students = Student::where('faculty_id', $department->id)->with(['user.student_files', 'employee', 'faculty', 'direction', 'group'])->get();

        $students = $students->sortByDesc(function ($student) {
            return $student->user->student_files->sum('student_score');
        });

        $map = $students->map(function ($student) {
            return [
                'fio'          => $student->user->short_fio(),
                'picture_path' => $student->user->picture_path(),

                'level'        => $student->level,
                'group'        => $student->group->name,

                'teacher'      => $student->employee?->user->short_fio() ?? "Biriktirilmagan",
                'faculty'      => $student->faculty->name,
                'direction'    => $student->direction->name,
                'total_score'  => $student->user->student_files->sum('student_score'),
            ];
        });

        return $count == Rating::ALL ? $map : $map->take($count);
    }

    public function faculty_teachers($count = Rating::ALL)
    {
        $role       = Role::where('name', 'teacher')->first();
        $department = $this->user->employee->department($this->role, StructureType::FACULTY->value);
        $teachers   = DepartmentEmployee::where('department_id', $department->id)
            ->where('role_id', $role->id)
            ->with(['employee.user.teacher_files', 'employee.students', 'employee.departments', 'employee.specialty'])
            ->get();

        $teachers = $teachers->sortByDesc(function ($teacher) {
            return $teacher->employee->user->teacher_files->sum('teacher_score');
        });

        $teachers = $teachers->unique(function ($teacher) {
            return $teacher->employee_id . '-' . $teacher->role_id;
        });

        $map = $teachers->map(function ($teacher) use ($role) {
            return [
                'fio'            => $teacher->employee->user->short_fio(),
                'picture_path'   => $teacher->employee->user->picture_path(),

                'department'     => $teacher->employee->departments
                    ->where('structure_code', StructureType::DEPARTMENT->value)
                    ->where('pivot.role_id', $role->id)
                    ->first()->name,
                'staff_position' => $teacher->employee->departments
                    ->where('structure_code', StructureType::DEPARTMENT->value)
                    ->where('pivot.role_id', $role->id)
                    ->first()->pivot->staff_position,

                'specialty'      => $teacher->employee->specialty->name,

                'total_score'    => $teacher->employee->user->teacher_files->sum('teacher_score'),
                'student_count'  => $teacher->employee->students->count(),
            ];
        });

        return $count == Rating::ALL ? $map : $map->take($count);
    }

    public function department($count = Rating::ALL)
    {
        $role       = Role::where('name', 'teacher')->first();
        $department = $this->user->employee->department('teacher', StructureType::DEPARTMENT->value);
        $teachers   = DepartmentEmployee::where('department_id', $department->id)->with(['employee.user.teacher_files', 'employee.students', 'employee.departments', 'employee.specialty'])->get();

        $teachers = $teachers->sortByDesc(function ($teacher) {
            return $teacher->employee->user->teacher_files->sum('teacher_score');
        });

        $map = $teachers->map(function ($teacher) use ($role) {
            return [
                'fio'            => $teacher->employee->user->short_fio(),
                'picture_path'   => $teacher->employee->user->picture_path(),

                'department'     => $teacher->employee->departments
                    ->where('structure_code', StructureType::DEPARTMENT->value)
                    ->where('pivot.role_id', $role->id)
                    ->first()->name,

                'staff_position' => $teacher->employee->departments
                    ->where('structure_code', StructureType::DEPARTMENT->value)
                    ->where('pivot.role_id', $role->id)
                    ->first()->pivot->staff_position,

                'specialty'      => $teacher->employee->specialty->name,

                'total_score'    => $teacher->employee->user->teacher_files->sum('teacher_score'),
                'student_count'  => $teacher->employee->students->count(),
            ];
        });

        return $count == Rating::ALL ? $map : $map->take($count);
    }

    public function group($count = Rating::ALL)
    {
        $group    = $this->user->student->group;
        $students = $group->students()->with(['user.student_files', 'employee', 'faculty', 'direction', 'group'])->get();

        $students = $students->sortByDesc(function ($student) {
            return $student->user->student_files->sum('student_score');
        });

        $map = $students->map(function ($student) {
            return [
                'fio'          => $student->user->short_fio(),
                'picture_path' => $student->user->picture_path(),

                'level'        => $student->level,
                'group'        => $student->group->name,

                'teacher'      => $student->employee?->user->short_fio() ?? "Biriktirilmagan",
                'faculty'      => $student->faculty->name,
                'direction'    => $student->direction->name,
                'total_score'  => $student->user->student_files->sum('student_score'),
            ];
        });

        return $count == Rating::ALL ? $map : $map->take($count);
    }

    public function unsorted_group($count = Rating::ALL)
    {
        $group    = $this->user->student->group;
        $students = $group->students()->with(['user.student_files', 'employee', 'faculty', 'direction', 'group'])->get();

        $map = $students->map(function ($student) {
            return [
                'fio'          => $student->user->short_fio(),
                'picture_path' => $student->user->picture_path(),

                'level'        => $student->level,
                'group'        => $student->group->name,

                'teacher'      => $student->employee?->user->short_fio() ?? "Biriktirilmagan",
                'faculty'      => $student->faculty->name,
                'direction'    => $student->direction->name,
                'total_score'  => $student->user->student_files->sum('student_score'),
            ];
        });

        return $count == Rating::ALL ? $map : $map->take($count);
    }
}
