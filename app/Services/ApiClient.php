<?php

namespace App\Services;

use Unirest\Request;
use Unirest\Request\Body;

class ApiClient
{
    public $curl;
    public $headers;

    public function __construct()
    {
        $this->curl = new Request();
    }

    public function url($path)
    {
        return "https://sumday.io/api/$path";
    }

    public function setHeaders($headers)
    {
        $this->headers = $headers;
    }

    public function login($email, $password)
    {
        $headers = [];

        $payload = [
            'email' => $email,
            'password' => $password,
        ];

        $body = Body::form($payload);

        $response = $this->curl::post($this->url('auth/login'), $headers, $body);

        return $response->body;
    }

    public function logout()
    {
        // logout
    }

    public function post($url, $payload)
    {
        $response = $this->curl::post($this->url($url), $this->headers, $payload);

        return $response->body->data;
    }

    public function get($url)
    {
        $response = $this->curl::get($this->url($url), $this->headers);

        return collect($response->body->data);
    }
}
