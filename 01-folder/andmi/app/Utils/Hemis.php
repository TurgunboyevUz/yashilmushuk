<?php

namespace App\Utils;

use Illuminate\Support\Arr;

class Hemis
{
    public $token;

    public $base_uri = 'https://student.andmiedu.uz/rest/v1/';

    public $response;

    public function __construct($token = null)
    {
        $this->token = $token;
    }

    public function get($method, $query = [])
    {
        $client = new Client;
        $response = $client->base_uri($this->base_uri)->query($query)->token($this->token)->get($method);

        $this->response = $response;

        return $this;
    }

    public function post($method, $data = [])
    {
        $client = new Client;
        $client->base_uri($this->base_uri)->data($data);

        if ($this->token) {
            $client->token($this->token);
        }

        $response = $client->post($method);

        $this->response = $response;

        return $this;
    }

    public function code()
    {
        return $this->response->code;
    }

    public function body()
    {
        return $this->response->body;
    }

    public function json($key = null, $default = null)
    {
        if ($this->code() !== 200) {
            return;
        }

        $json = json_decode($this->body(), true);

        if (is_null($key)) {
            return $default ?? $json;
        }

        return Arr::get($json, $key, $default);
    }

    public function employee($hemis_id, $passport_pin, $passport_number)
    {
        $response = $this->get('data/employee-list', [
            'type' => 'all',
            'search' => $hemis_id,
            'passport_pin' => $passport_pin,
            'passport_number' => $passport_number,
        ]);

        $arr = [];
        $items = $response->json('data.items', []);

        foreach ($items as $item) {
            if ($item['employee_id_number'] != $hemis_id) {
                continue;
            }

            $arr[] = [
                'gender' => $item['gender'],
                'specialty' => $item['specialty'],
                'department' => $item['department'],
                'staff_position' => $item['staffPosition'],
                'employee_type' => $item['employeeType'],
            ];
        }

        return $arr;
    }

    public function student($hemis_id, $passport_pin)
    {
        $response = $this->get('data/student-info', [
            'student_id_number' => $hemis_id,
            'pnfl' => $passport_pin,
        ]);

        $arr = [
            [
                'gender' => $response->json('data.gender'),
            ],
        ];

        return $arr;
    }
}
