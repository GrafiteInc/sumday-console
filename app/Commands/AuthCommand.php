<?php

namespace App\Commands;

use App\Services\ApiClient;
use App\Services\ApiService;
use App\Services\ConfigService;
use LaravelZero\Framework\Commands\Command;

class AuthCommand extends Command
{
    /**
     * The signature of the command.
     *
     * @var string
     */
    protected $signature = 'auth
                            {email : Your email for Sumday }
                            {--reset : If you wish to reset your access token}';

    /**
     * The description of the command.
     *
     * @var string
     */
    protected $description = 'Authenticate the CLI with Sumday.';

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle()
    {
        $password = $this->secret('Please enter your password');

        $authentication = app(ApiService::class)->login($this->argument('email'), $password);

        app(ConfigService::class)->setToken($authentication->access_token);

        $this->info('You\'ve successfully logged in.');
    }
}
