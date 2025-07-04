<?php

namespace App\Utils;

class Client
{
    public $headers = [
        'Accept: application/json',
    ];

    public $token;

    public $cookie;

    public $data = [];

    public $query = [];

    public $base_uri;

    public function token($token)
    {
        $this->headers[] = 'Authorization: Bearer '.$token;

        return $this;
    }

    public function cookie($cookie)
    {
        $this->headers[] = 'Cookie: '.$cookie;

        return $this;
    }

    public function base_uri($base_uri)
    {
        $this->base_uri = $base_uri;

        return $this;
    }

    public function data(array $data = [])
    {
        $this->headers[] = 'Content-Type: application/json';
        $this->data = $data;

        return $this;
    }

    public function query(array $query = [])
    {
        $this->query = $query;

        return $this;
    }

    public function request($method, $type = 'GET')
    {
        $url = $this->base_uri.$method;

        if (! empty($this->query)) {
            $url .= '?'.http_build_query($this->query);
        }

        $ch = curl_init();

        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_HTTPHEADER, $this->headers);
        curl_setopt($ch, CURLOPT_CUSTOMREQUEST, $type);
        curl_setopt($ch, CURLOPT_USERAGENT, 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/100.0.4896.75 Safari/537.36');
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);

        if (! empty($this->data)) {
            curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($this->data));
        }

        return (object) [
            'body' => curl_exec($ch),
            'code' => curl_getinfo($ch, CURLINFO_HTTP_CODE),
        ];
    }

    public function get($method)
    {
        return $this->request($method);
    }

    public function post($method)
    {
        return $this->request($method, 'POST');
    }
}
