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
        $schedule->call('App\Http\Controllers\CronController@currency')->daily();
        $schedule->call('App\Http\Controllers\CronController@ical_sync')->everyFiveMinutes();
        $schedule->call('App\Http\Controllers\CronController@expire')->hourly();
    //    $schedule->call('App\Http\Controllers\CronController@travel_credit')->daily();
        $schedule->call('App\Http\Controllers\CronController@review_remainder')->daily();
        $schedule->call('App\Http\Controllers\CronController@host_remainder_pending_reservaions')->everyMinute();
        $schedule->command('backup:run')->monthly();
        $schedule->command('backup:run --only-db')->daily();
        $schedule->command('backup:clean')->monthly();
        $schedule->command('queue:work --tries=3 --once')->cron('* * * * *');
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