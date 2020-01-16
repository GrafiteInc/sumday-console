<?php

namespace Tests\Feature;

use Tests\TestCase;

class ConfigCommandTest extends TestCase
{
    public function testConfigCommand()
    {
        $this->artisan('config')
             ->expectsOutput('You must enter either a client or a project CLI code.')
             ->assertExitCode(0);
    }

    public function testConfigClientCommand()
    {
        $this->artisan('config', [
            '--client' => 'foo-bar'
        ])
        ->expectsOutput('This directory is now paired with the client.')
        ->assertExitCode(0);
    }
}
