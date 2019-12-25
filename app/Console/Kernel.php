<?php

namespace App\Console;

use Illuminate\Console\Scheduling\Schedule;
use Illuminate\Foundation\Console\Kernel as ConsoleKernel;
use App\SupremeCoCrawler;
use App\BroadwayCrawler;
use App\SuningCrawler;
use App\CitylinkCrawler;
use App\HobbydigiCrawler;
use App\DailyAlert;

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
        // $schedule->command('inspire')
        //          ->hourly();
        $schedule->call(new SupremeCoCrawler)->dailyAt('01:00');
        $schedule->call(new SuningCrawler)->dailyAt('01:30');
        $schedule->call(new BroadwayCrawler)->dailyAt('02:00');
        $schedule->call(new CitylinkCrawler)->dailyAt('03:00');
        $schedule->call(new HobbydigiCrawler)->dailyAt('04:00');
        // $schedule->call(new DailyAlert);//->dailyAt('03:00');
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
