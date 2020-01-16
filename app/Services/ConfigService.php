<?php

namespace App\Services;

use Illuminate\Filesystem\Filesystem;

class ConfigService
{
    public $files;

    public $configDirectory;

    public function __construct(Filesystem $files)
    {
        $this->files = $files;
        $this->setUpConfig();
    }

    public function setUpConfig()
    {
        $home = posix_getpwuid(fileowner(__FILE__))['dir'].'/.config/sumday';

        if (! $this->files->isDirectory($home)) {
            $this->files->makeDirectory($home);
        }

        if (! $this->files->exists("$home/config.json")) {
            $this->files->put("$home/config.json", $this->defaultConfig());
        }
    }

    public function hasToken()
    {
        if (! is_null($this->get()->token)) {
            return true;
        }

        return false;
    }

    public function get()
    {
        $home = posix_getpwuid(fileowner(__FILE__))['dir'].'/.config/sumday';

        return json_decode($this->files->get("$home/config.json"));
    }

    public function put($content)
    {
        $home = posix_getpwuid(fileowner(__FILE__))['dir'].'/.config/sumday';

        return $this->files->put("$home/config.json", json_encode($content, JSON_PRETTY_PRINT));
    }

    public function defaultConfig()
    {
        return json_encode([
            'clients' => [],
            'projects' => [],
            'token' => null
        ], JSON_PRETTY_PRINT);
    }

    public function addPathToClient($client)
    {
        $dir = getcwd();
        $paths = (array) $this->get()->clients;

        $paths = collect(array_merge([
           $dir => $client
        ], $paths))->unique();

        $content = $this->get();
        $content->clients = $paths->toArray();

        $this->put($content);
    }

    public function addPathToProjetcs($project)
    {
        $dir = getcwd();
        $paths = (array) $this->get()->projects;

        $paths = collect(array_merge([
           $dir => $project
        ], $paths))->unique();

        $content = $this->get();
        $content->projects = $paths->toArray();

        $this->put($content);
    }

    public function setToken($token)
    {
        $content = $this->get();

        $content->token = $token;

        $this->put($content);
    }
}
