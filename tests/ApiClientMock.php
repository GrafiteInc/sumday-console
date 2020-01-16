<?php

namespace Tests;

use App\Services\ApiClient;
use Illuminate\Support\Carbon;

class ApiClientMock extends ApiClient
{
    public $curl;

    public $headers;

    public function __construct()
    {
        // nothing
    }

    public function login($email, $password)
    {
        return (object) [
            'data' => [
                'access_token' => 'foo-bar'
            ]
        ];
    }

    public function post($url, $payload)
    {
        if ($url === 'hours/store') {
            return (object) [
                'client' => 'foo-bar',
                'hours' => '2.5',
                'notes' => 'simple test',
                'date' => Carbon::parse('2020-01-16')->format('Y-m-d'),
            ];
        }
    }

    public function get($url)
    {
        if ($url === 'clients') {
            return [
                (object) [
                    'name' => 'foo',
                    'uuid' => 'ksadkas-asdasd-asdad-adsadd'
                ],
                (object) [
                    'name' => 'bar',
                    'uuid' => 'ksadkas-asdasd-asdad-adsadd'
                ]
            ];
        }

        if ($url === 'projects') {
            return [
                (object) [
                    'name' => 'foo',
                    'uuid' => 'ksadkas-asdasd-asdad-adsadd'
                ],
                (object) [
                    'name' => 'bar',
                    'uuid' => 'ksadkas-asdasd-asdad-adsadd'
                ]
            ];
        }
    }
}
