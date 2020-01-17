<?php

namespace Tests\Feature;

use Mockery;
use Tests\TestCase;
use Tests\ApiClientMock;
use App\Services\ApiService;
use org\bovigo\vfs\vfsStream;
use App\Services\ConfigService;
use Illuminate\Filesystem\Filesystem;

class ApiServiceTest extends TestCase
{
    public function setUp(): void
    {
        parent::setUp();

        $root = vfsStream::setup('config/sumday');
        $configPath = vfsStream::url('config/sumday');
        $file = vfsStream::newFile('config.json', 777)->setContent(json_encode([
            'clients' => [],
            'projects' => [],
            'token' => null
        ], JSON_PRETTY_PRINT));
        $root->addChild($file);

        $files = new FileSystem;

        $client = new ApiClientMock;

        $this->config = new ConfigService($files, $configPath);

        $this->service = new ApiService($client, $this->config);
    }

    public function testClients()
    {
        $this->config->setToken('foo-bar');

        $clients = $this->service->getClients();

        $this->assertEquals(2, count($clients));
    }

    public function testProjects()
    {
        $this->config->setToken('foo-bar');

        $projects = $this->service->getProjects();

        $this->assertEquals(2, count($projects));
    }

    public function testLog()
    {
        $this->config->setToken('foo-bar');

        $log = $this->service->log([
            'client' => 'foo-bar',
            'hours' => '2:30',
            'notes' => 'simple test',
            'date' => null,
        ]);

        $this->assertEquals('2020-01-16', $log->date);
        $this->assertEquals('2.5', $log->hours);
    }
}
