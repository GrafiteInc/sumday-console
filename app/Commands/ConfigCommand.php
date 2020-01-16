<?php

namespace App\Commands;

use App\Services\ConfigService;
use Illuminate\Console\Scheduling\Schedule;
use LaravelZero\Framework\Commands\Command;

class ConfigCommand extends Command
{
    /**
     * The signature of the command.
     *
     * @var string
     */
    protected $signature = 'config
                            {--client= : The client CLI code }
                            {--project= : The project CLI code }';

    /**
     * The description of the command.
     *
     * @var string
     */
    protected $description = 'Config a directory for a client or project';

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle()
    {
        if (is_null($this->option('client')) && is_null($this->option('project'))) {
            $this->warn('You must enter either a client or a project CLI code.');
            return;
        }

        if (!is_null($this->option('client'))) {
            app(ConfigService::class)->addPathToClient($this->option('client'));
            $this->info('This directory is now paired with the client.');
        }

        if (!is_null($this->option('projects'))) {
            app(ConfigService::class)->addPathToProject($this->option('project'));
            $this->info('This directory is now paired with the project.');
        }
    }

    /**
     * Define the command's schedule.
     *
     * @param  \Illuminate\Console\Scheduling\Schedule $schedule
     * @return void
     */
    public function schedule(Schedule $schedule)
    {
        // $schedule->command(static::class)->everyMinute();
    }
}
