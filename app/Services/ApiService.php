<?php

namespace App\Services;

use Exception;
use Unirest\Request\Body;
use App\Services\ApiClient;
use App\Services\ConfigService;

class ApiService
{
    public $client;

    public function __construct(ApiClient $client, ConfigService $config)
    {
        $this->client = $client;

        if ($config->hasToken()) {
            $this->client->setHeaders([
                'Authorization' => 'bearer '.$config->get()->token
            ]);
        } else {
            throw new Exception("Please login to access Sumday", 1);
        }
    }

    public function getClients()
    {
        return $this->client->get('clients');
    }

    public function getProjects()
    {
        return $this->client->get('projects');
    }

    public function log($payload)
    {
        $body = Body::json($payload);

        return $this->client->post('hours/store', $body);
    }
}
