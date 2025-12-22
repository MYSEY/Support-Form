<?php

namespace App\Console;

use App\Models\Ticket;
use Carbon\Carbon;
use Illuminate\Console\Scheduling\Schedule;
use Illuminate\Foundation\Console\Kernel as ConsoleKernel;

class Kernel extends ConsoleKernel
{
    /**
     * Define the application's command schedule.
     */
    protected function schedule(Schedule $schedule): void
    {
        // $schedule->command('inspire')->hourly();
        $schedule->call(function() {
            Ticket::where("trackid","2509050032")->where('status', '6')
            ->whereDate('updated_at', '<=', Carbon::now()->subDays(3))
            ->update([
                'status' => '7'
            ]);
        })->dailyAt('09:25');

        // $schedule->command('table:update-data')->dailyAt('15:50');
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
