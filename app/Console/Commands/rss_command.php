<?php

namespace App\Console\Commands;

use App\Scripts\php\RssScript;
use Illuminate\Console\Command;
use phpseclib\Net\SSH1;
use phpseclib\Net\SSH2;
use Spatie\Ssh\Ssh;

class rss_command extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'rss {action?} {param1?}';

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
        // cd public_html/politicus
        if($this->argument('action') == 'ssh'){
//            $process = Ssh::create('user', 'example.com')->execute('your favorite command');
            $ssh = new SSH2('45.87.81.51', '65002');

            $ssh->login(env('SSH_USER'), env('SSH_PASS'));

            while($var = $ssh->exec('cd public_html/politicus && php artisan rss')){
                dump($var);
            }
        }
        else{
            dump("Begin : ".date('Y-m-d H:i:s'));
            echo (new RssScript())->RssToDB($this->argument('action'));
            dump("End : ".date('Y-m-d H:i:s'));
        }
    }
}
