<?php

namespace App\Console\Commands;

use Illuminate\Http\Request;
use Illuminate\Console\Command;
use App\Http\Controllers\AdministrationController;

class test_command extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'test {action} {param1?}';

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
     * @return mixed
     */
    public function handle()
    {
        dump('TEST ' . $this->argument('action'));
        $request = new Request();
        switch ($this->argument('action')) {
            case 'GlobalSearch':
                $request->request->add(['GlobalSearch'=>$this->argument('param1')]);
                $request->setMethod('POST');
                (new AdministrationController)->search($request);
                break;
            
            default:
                # code...
                break;
        }
    }
}
