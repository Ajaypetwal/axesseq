<?php

namespace App\Console;
use Carbon\Carbon;
use DB;
use Illuminate\Console\Scheduling\Schedule;
use Illuminate\Foundation\Console\Kernel as ConsoleKernel;
use Illuminate\Support\Facades\Log;

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
        $schedule->call('App\Http\Controllers\AdminController@pushNotificationGroup')->daily();

        // $schedule->call(function () {
        //     DB::table('story')->where('created_at', '<', Carbon::now()->subHours(24))->delete();
        // }); 
        // $schedule->call('App\Http\Controllers\EventController@event_start')->daily(); 
        // $schedule->call('App\Http\Controllers\EventController@job_one_year')->daily();
        // $schedule->call('App\Http\Controllers\EventController@event_delete')->daily();
        // $schedule->call('App\Http\Controllers\EventController@event_start_fifteen_before')->daily();
      
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
