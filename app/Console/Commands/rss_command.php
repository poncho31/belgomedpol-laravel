<?php

namespace App\Console\Commands;

use App\Scripts\php\RssScript;
use Illuminate\Console\Command;

class rss_command extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'rss {action?}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Command description';

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
        // ssh -p 65002 u655423024@45.87.81.51
        dump("Begin : ".date('Y-m-d H:i:s'));
        return (new RssScript())->RssToDB();
        dump("End : ".date('Y-m-d H:i:s'));
    }
}
