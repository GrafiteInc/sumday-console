<?php

namespace App\Services;

use Illuminate\Support\Carbon;
use Illuminate\Filesystem\Filesystem;

class ConfigService
{
    public $files;

    public $config_path;

    public function __construct(Filesystem $files, $configPath = null)
    {
        $this->files = $files;

        $this->setConfigPath($configPath);
        $this->setUpConfig();
    }

    public function setConfigPath($path = null)
    {
        if (!is_null($path)) {
            $this->config_path = $path;
            return;
        }

        $this->config_path = posix_getpwuid(fileowner(__FILE__))['dir'].'/.config/sumday';
    }

    public function setUpConfig()
    {
        if (! $this->files->isDirectory($this->config_path)) {
            $this->files->makeDirectory($this->config_path);
        }

        if (! $this->files->exists("$this->config_path/config.json")) {
            $this->files->put("$this->config_path/config.json", $this->defaultConfig());
        }
    }

    public function hasToken()
    {
        if (! is_null($this->get()->token)) {
            return true;
        }

        return false;
    }

    public function tokenHasExpired()
    {
        $expiresAt = Carbon::parse($this->get()->token_expires_at);

        if (Carbon::now()->isAfter($expiresAt)) {
            return true;
        }

        return false;
    }

    public function get()
    {
        return json_decode($this->files->get("$this->config_path/config.json"));
    }

    public function put($content)
    {
        return $this->files->put("$this->config_path/config.json", json_encode($content, JSON_PRETTY_PRINT));
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

    public function setTokenExpiresAt($time)
    {
        $content = $this->get();

        $content->token_expires_at = $time;

        $this->put($content);
    }
}
