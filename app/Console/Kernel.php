<?php

namespace App\Console;

use Illuminate\Console\Scheduling\Schedule;
use Illuminate\Foundation\Console\Kernel as ConsoleKernel;

class Kernel extends ConsoleKernel
{
    /**
     * Define the application's command schedule.
     * 
     
     *
     * @param  \Illuminate\Console\Scheduling\Schedule  $schedule
     * @return void
     */
    protected $commands = [

        Commands\Revision::class,
       
        //
    ];

    protected function schedule(Schedule $schedule)
    {
        // $schedule->command('control:diario')->dailyAt('07:00')->timezone('America/Bogota');
        // $schedule->command('revision:diaria')->dailyAt('14:58')->timezone('America/Bogota');
        $schedule->command('control:diario')->everyMinute()->timezone('America/Bogota');
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
