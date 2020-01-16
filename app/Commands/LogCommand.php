<?php

namespace App\Commands;

use App\Services\ApiService;
use App\Services\ConfigService;
use LaravelZero\Framework\Commands\Command;

class LogCommand extends Command
{
    /**
     * The signature of the command.
     *
     * @var string
     */
    protected $signature = 'log
                            {hours : The hours you worked (8:30, 3.5)}
                            {note : Any notes you wish to add to the hour log}
                            {--date= : The date of your hours}';

    /**
     * The description of the command.
     *
     * @var string
     */
    protected $description = 'Log your hours on Sumday';

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle()
    {
        $clientPaths = (array) app(ConfigService::class)->get()->clients;
        $projectPaths = (array) app(ConfigService::class)->get()->projects;

        $allPaths = array_merge($clientPaths, $projectPaths);

        if (!isset($allPaths[getcwd()])) {
            $this->warn('You must connect this path to a client or project');
            return;
        }

        $log = app(ApiService::class)->log([
            'client' => $allPaths[getcwd()],
            'hours' => $this->argument('hours'),
            'notes' => $this->argument('note'),
            'date' => $this->option('date') ?? null,
        ]);

        $this->info($log->hours.' hours logged for: '.$log->client->name);
    }
}
