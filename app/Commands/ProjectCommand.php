<?php

namespace App\Commands;

use App\Services\ApiService;
use LaravelZero\Framework\Commands\Command;

class ProjectCommand extends Command
{
    /**
     * The signature of the command.
     *
     * @var string
     */
    protected $signature = 'projects';

    /**
     * The description of the command.
     *
     * @var string
     */
    protected $description = 'Get a list of your projects on Sumday';

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle()
    {
        $projects = app(ApiService::class)->getProjects();

        foreach ($projects as $project) {
            $this->info($project->name.': '.$project->uuid);
        }
    }
}
