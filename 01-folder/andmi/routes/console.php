<?php

use Illuminate\Support\Facades\Artisan;

Artisan::command('tree', function () {
    $exclude = [
        'vendor', 'public', 'bootstrap', 'storage', 'config', 'composer.json', 'composer.lock', 'artisan', 'seeders', 'factories',
    ];

    $path = base_path();
    $tree = exec("tree --prune -I '".implode('|', $exclude)."' $path", $output);

    foreach ($output as $line) {
        $this->comment($line);
    }
});

Artisan::command('pint', function () {
    exec('./vendor/bin/pint', $output);

    foreach ($output as $line) {
        $this->comment($line);
    }
});

Artisan::command('cp-migrate', function () {
    $glob = glob(database_path('tables/*.php'));

    $map = [
        'create_users_table',
        'create_cache_table',
        'create_permission_tables',
        'create_genders_table',
        'create_education_years_table',
        'create_departments_table',
        'create_faculties_table',
        'create_specialties_table',
        'create_groups_table',
        'create_directions_table',
        'create_nations_table',
        'create_employees_table',
        'create_students_table',
        'create_department_employee_table',
        'create_categories_table',
        'create_criterias_table',
        'create_chats_table',
        'create_messages_table',
        'create_files_table',
        'create_articles_table',
        'create_achievements_table',
        'create_distinguished_scholarships_table',
        'create_grand_economies_table',
        'create_inventions_table',
        'create_lang_certificates_table',
        'create_olympics_table',
        'create_scholarships_table',
        'create_startups_table',
        'create_tasks_table',
    ];

    foreach ($map as $item) {
        $file = array_filter($glob, function ($file) use ($item) {
            return strpos(basename($file), $item) !== false;
        });

        $file = array_shift($file);

        copy($file, database_path('migrations/'.now()->format('Y_m_d_His_').$item.'.php'));

        sleep(3);
    }
});
