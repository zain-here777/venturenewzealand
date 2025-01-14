<?php

namespace App\Console;

use Illuminate\Console\Scheduling\Schedule;
use Illuminate\Foundation\Console\Kernel as ConsoleKernel;

class Kernel extends ConsoleKernel
{
    /**
     * The Artisan commands provided by your application.
     *
     * @var array
     */
    protected $commands = [
        Commands\fetchCityWeather::class,
        Commands\productDiscountNotification::class,
        Commands\UpdateBookingStatusCron::class,
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
        $schedule->command('fetchCityWeather:fetch')->hourly();
        $schedule->command('productDiscountNotification:run')->dailyAt('00:05');
        $schedule->command('queue:work --stop-when-empty')->daily()->withoutOverlapping(15 * 60);
        $schedule->command('updatebookingstatus:cron')->everyMinute();
    }

    /**
     * Register the commands for the application.
     *
     * @return void
     */
    protected function commands()
    {
        $this->load(__DIR__.'/Commands');

        require_once base_path('routes/console.php');
    }
}
