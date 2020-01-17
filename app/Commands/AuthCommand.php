<?php

namespace App\Commands;

use App\Services\ApiClient;
use Illuminate\Support\Carbon;
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
                            {token : Your API token from Sumday}';

    /**
     * The description of the command.
     *
     * @var string
     */
    protected $description = 'Set your authentication token in Sumday Console';

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle()
    {
        app(ConfigService::class)->setToken($this->argument('token'));

        $this->info('You\'ve added your token.');
    }
}
