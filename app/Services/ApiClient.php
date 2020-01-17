<?php

namespace App\Services;

use Exception;
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

    public function post($url, $payload = [])
    {
        $response = $this->curl::post($this->url($url), $this->headers, $payload);

        if ($response->code != 200) {
            throw new Exception("Your token may have been reset or we're experiencing issues. Please try again, or reset your token.", 1);
        }

        return $response->body->data;
    }

    public function get($url)
    {
        $response = $this->curl::get($this->url($url), $this->headers);

        if ($response->code != 200) {
            throw new Exception("Your token may have been reset or we're experiencing issues. Please try again, or reset your token.", 1);
        }

        return collect($response->body->data);
    }
}
