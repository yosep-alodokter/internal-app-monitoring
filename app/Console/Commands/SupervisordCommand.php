<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;

class SupervisordCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'supervisord:restart';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Untuk restart supervisord server';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle()
    {
        $restart = shell_exec('supervisorctl restart all');

        echo $restart . PHP_EOL;

        return true;
    }
}
