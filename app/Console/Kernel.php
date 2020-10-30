<?php

namespace App\Console;

use Illuminate\Console\Scheduling\Schedule;
use Illuminate\Foundation\Console\Kernel as ConsoleKernel;
use App\Scripts\php\RssScript;
use App\Theme;

class Kernel extends ConsoleKernel
{
    /**
     * The Artisan commands provided by your application.
     *
     * @var array
     */
    protected $commands = [
        //
    ];

    /**
     * Define the application's command schedule.
     *
     * @param  \Illuminate\Console\Scheduling\Schedule  $schedule
     * @return void
     */
    protected function schedule(Schedule $schedule)
    {
        $schedule->call(function(){
            (new RssScript)->RssToDB();
        })->cron('* * * * *')->name('rsstodb')->withoutOverlapping(); //->withoutOverlapping(180); // ->cron('0 */4 * * *'); // run job every 4 hour

        // $schedule->call(function() use($rssScript){
        //     $rssScript->repairCompleteAll();
        // })->weekly();
    }

    /**
     * Register the commands for the application.
     *
     * @return void
     */
    protected function commands()
    {
        $this->load(__DIR__.'/Commands');

        require base_path('routes/console.php');
    }
}
