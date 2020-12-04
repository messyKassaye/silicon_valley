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
        Commands\TabAdvertsFileZipper::class,
        Commands\AdvertViewPayer::class,
        Commands\AdvertCompletionChecker::class,
        Commands\ImageConvertor::class,
        Commands\NewAdvertSMSSender::class,
        Commands\AdvertDateToDateSMSSender::class,
        Commands\WebSocketServer::class

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
        $schedule->command('file:zipper')
            ->everyTenMinutes();
        $schedule->command('view:payer')
            ->everyMinute();


        $schedule->command('advert:completer')
            ->everyMinute();
        $schedule->command('image:converter')
            ->everyMinute();
        /*$schedule->command('newAdvert:SMS')
            ->dailyAt('6:30');

        $schedule->command('date2dateAdvertSender:advertSender')
            ->dailyAt('9:00');*/

    }

    /**
     * Register the Closure based commands for the application.
     *
     * @return void
     */
    protected function commands()
    {
        require base_path('routes/console.php');
    }
}
