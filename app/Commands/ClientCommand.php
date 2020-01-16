<?php

namespace App\Commands;

use App\Services\ApiService;
use Illuminate\Console\Scheduling\Schedule;
use LaravelZero\Framework\Commands\Command;

class ClientCommand extends Command
{
    /**
     * The signature of the command.
     *
     * @var string
     */
    protected $signature = 'clients';

    /**
     * The description of the command.
     *
     * @var string
     */
    protected $description = 'Get a list of your clients on Sumday';

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle()
    {
        $clients = app(ApiService::class)->getClients();

        foreach ($clients as $client) {
            $this->info($client->name.': '.$client->uuid);
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
