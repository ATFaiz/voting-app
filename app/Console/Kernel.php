<?php

namespace App\Console;

use Illuminate\Console\Scheduling\Schedule;
use Illuminate\Foundation\Console\Kernel as ConsoleKernel;
use Carbon\Carbon;
use App\Console\Commands\SendConstituencyVoteNotification;


class Kernel extends ConsoleKernel
{
       
    /**
     * Define the application's command schedule.
     *
     * @param  \Illuminate\Console\Scheduling\Schedule  $schedule
     * @return void
     */
    protected function schedule(Schedule $schedule)
    {
       
        $schedule->call(function () {
            $this->call('send:constituency-vote-notification');
        })->when(function () {
            return Carbon::now()->lte(Carbon::create(2023, 3, 30, 8, 00));
        });
    }

    /**
     * Register the commands for the application.
     *
     * @return void
     */
    protected function commands()
    
    {
        $this->load(__DIR__.'/Commands');
    
        $this->load(__DIR__.'/../console');
    
        require base_path('routes/console.php');
    
        
    }
    
}
