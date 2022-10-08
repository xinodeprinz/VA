<?php

namespace App\Console;

use App\Models\User;
use Illuminate\Console\Scheduling\Schedule;
use Illuminate\Foundation\Console\Kernel as ConsoleKernel;

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
        // $schedule->command('inspire')->hourly();
        $schedule->call(function () {
            $users = User::all();
            foreach ($users as $user) {
                // For the plan
                if ($user->plan()->exists()) {
                    if ($user->expires_in > 1) {
                        $user->expires_in -= 1;
                    } else {
                        $user->plan_id = 0;
                        $user->expires_in = 0;
                    }
                }

                // For adverts
                if ($user->is_advert) {
                    if ($user->advert_expires_in > 1) {
                        $user->advert_expires_in -= 1;
                    } else {
                        $user->advert_expires_in = 0;
                        $user->is_advert = 0;
                    }
                }

                // For daily withdrawal
                if ($user->has_withdrawn) {
                    $user->has_withdrawn = 0;
                }

                // For daily ads clicking
                if ($user->has_clicked_ads) {
                    $user->has_clicked_ads = 0;
                }

                $user->update();
            }
        })->everyMinute()->timezone('Africa/Douala');
    }

    /**
     * Register the commands for the application.
     *
     * @return void
     */
    protected function commands()
    {
        $this->load(__DIR__ . '/Commands');

        require base_path('routes/console.php');
    }
}