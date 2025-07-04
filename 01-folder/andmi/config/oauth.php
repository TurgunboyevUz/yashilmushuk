<?php

return [
    'employee' => [
        'clientId' => env('OAUTH_CLIENT_ID'),
        'clientSecret' => env('OAUTH_CLIENT_SECRET'),
        'redirectUri' => env('OAUTH_EMPLOYEE_REDIRECT_URI'),
        'urlAuthorize' => env('OAUTH_EMPLOYEE_URL').'oauth/authorize',
        'urlAccessToken' => env('OAUTH_EMPLOYEE_URL').'oauth/access-token',
        'urlResourceOwnerDetails' => env('OAUTH_EMPLOYEE_URL').'oauth/api/user', //?fields=id,uuid,employee_id_number,type,roles,name,login,email,picture,firstname,surname,patronymic,birth_date,university_id,phone
    ],

    'student' => [
        'clientId' => env('OAUTH_CLIENT_ID'),
        'clientSecret' => env('OAUTH_CLIENT_SECRET'),
        'redirectUri' => env('OAUTH_STUDENT_REDIRECT_URI'),
        'urlAuthorize' => env('OAUTH_STUDENT_URL').'oauth/authorize',
        'urlAccessToken' => env('OAUTH_STUDENT_URL').'oauth/access-token',
        'urlResourceOwnerDetails' => env('OAUTH_STUDENT_URL').'oauth/api/user',
    ],

    'token' => env('BACKEND_API_TOKEN'),
];
