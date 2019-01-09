<?php

namespace App\Console\Commands;

use App\Jobs\ProcessNmapLog;
use Illuminate\Console\Command;

class ProcessNmapLogCommand extends Command
{
    protected $signature = 'nmap:process';
    protected $description = 'Process the nmap log to the database';

    public function __construct()
    {
        parent::__construct();
    }

    public function handle()
    {
        ProcessNmapLog::dispatch();
    }
}
