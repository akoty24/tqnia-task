<?php

namespace App\Console;

use App\Jobs\ForceDeleteOldPosts;
use Illuminate\Console\Scheduling\Schedule;
use Illuminate\Foundation\Console\Kernel as ConsoleKernel;

class Kernel extends ConsoleKernel
{
    /**
     * Define the application's command schedule.
     */
   
        // $schedule->command('inspire')->hourly();
        protected function schedule(Schedule $schedule)
         {
              $schedule->job(new ForceDeleteOldPosts)->daily();
          }
    

    /**
     * Register the commands for the application.
     */
    protected function commands(): void
    {
        $this->load(__DIR__.'/Commands');

        require base_path('routes/console.php');
    }
}
