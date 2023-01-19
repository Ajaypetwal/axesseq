<?php

namespace App\Console\Commands;
use Illuminate\Support\Facades\DB;
use Illuminate\Console\Command;
use Carbon\Carbon;
use Illuminate\Support\Facades\Log;
class DeleteRecords extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'delete-records';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Command description';

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle()
    {        
        Log::emergency("Cron job scheduled");
      //  DB::table('role')->where('created_at', '<=', Carbon::now()->subDay())->delete();
       // DB::table('roles')->where('created_at', '>=', Carbon::now()->subDay())->delete();      
    }
}
