<?php

namespace App\Console;

use Illuminate\Console\Scheduling\Schedule;
use Illuminate\Foundation\Console\Kernel as ConsoleKernel;

class Kernel extends ConsoleKernel
{
    /**
     * Define the application's command schedule.
     */
    protected function schedule(Schedule $schedule): void
    {
        // $schedule->command('process:getRecentDOM')->everyDay();
        // $schedule->command('process:getAllDOMs');
        // $schedule->command('process:getExoneracoesDiario');
        // $schedule->command('process:getDiariosTCM');
        // $schedule->command('process:getInfoDiarioTCM');
        // $schedule->command('process:getParecerContasPrefeitura');
        $schedule->command('process:getRecentDiarioTCM')->dailyAt('08:20');

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
