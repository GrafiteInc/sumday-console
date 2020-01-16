<?php

namespace App\Services;

use Exception;
use Unirest\Request\Body;
use App\Services\ApiClient;
use App\Services\ConfigService;

class ApiService
{
    public $client;

    public $config;

    public function __construct(ApiClient $client, ConfigService $config)
    {
        $this->client = $client;
        $this->config = $config;
    }

    public function login($email, $password)
    {
        return $this->client->login($email, $password);
    }

    public function getClients()
    {
        $this->validateToken();

        return $this->client->get('clients');
    }

    public function getProjects()
    {
        $this->validateToken();

        return $this->client->get('projects');
    }

    public function log($payload)
    {
        $this->validateToken();

        $body = Body::json($payload);

        return $this->client->post('hours/store', $body);
    }

    public function validateToken()
    {
        if ($this->config->hasToken()) {
            $this->client->setHeaders([
                'Authorization' => 'bearer '.$this->config->get()->token
            ]);
        } else {
            throw new Exception("Please login to access Sumday", 1);
        }
    }
}
