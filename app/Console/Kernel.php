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
        $rssScript = new RssScript();
        $theme = new Theme();
        
        $schedule->call(function() use($theme){
            // $theme->testConstructorRegex();
            // $theme->testRegex();
            // $theme->insertTheme();
        })->everyMinute();

        $schedule->call(function() use($rssScript){
            $rssScript->RssToDB();
            // $rssScript->getPoliticianCitationsByArticle('dimitri', 'fourny');
        })->everyMinute();


        $schedule->call(function() use($rssScript){
            $rssScript->repairCompleteAll();
        })->weekly();
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
