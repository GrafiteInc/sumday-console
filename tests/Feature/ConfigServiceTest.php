<?php

namespace Tests\Feature;

use Tests\TestCase;
use org\bovigo\vfs\vfsStream;
use App\Services\ConfigService;
use Illuminate\Filesystem\Filesystem;

class ConfigServiceTest extends TestCase
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

        $this->service = new ConfigService($files, $configPath);
    }

    public function testHasToken()
    {
        $this->assertFalse($this->service->hasToken());
    }

    public function testDefaultConfig()
    {
        $this->assertEquals(json_encode([
            'clients' => [],
            'projects' => [],
            'token' => null
        ], JSON_PRETTY_PRINT), $this->service->defaultConfig());
    }

    public function testAddPathToClient()
    {
        $this->service->addPathToClient('foo-bar');

        $values = array_values((array) $this->service->get()->clients);
        $this->assertContains('foo-bar', $values);

    }

    public function testSetToken()
    {
        $this->service->setToken('foo-bar');

        $token = $this->service->get()->token;

        $this->assertEquals('foo-bar', $token);
    }
}
