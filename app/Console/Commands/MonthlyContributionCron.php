<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\MonthlySavings;
use App\Notifications\MonthlyContributionNotification;
use Illuminate\Support\Facades\Notification;

class MonthlyContributionCron extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'monthlycontribution:cron';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Command description';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle()
    {
        if(in_array(date('j'), [1, 3, 5])){

            $usersNotify = MonthlySavings::whereRaw('MONTH(next_payment_date) = '.Carbon::now()->month)->with('user')->get();

            if($usersNotify->count() < 1){
                
                \Log::info("No users to send notification this month");

            } else {

                //\Log::info("users present to send notification");

                //  dd($usersNotify);


                foreach ($usersNotify as $key => $user) 
                    {

                        $message = [
                            'id' => $user->user_id,
                            'description' => 'Dear Member please ensure you make your monthly payment',
                            'name' => $user->user->name
                        ];

                        //dd($user->user_id);

                        $user->user->notify(new MonthlyContributionNotification($message));

                        //$newUser->notify(new MonthlyContributionNotification($message));
                        \Log::info($key." Monthly notification sent to this user ".$user->user->name);
                    }
            
                //notify users that payment is almost due
                //Notification::send($usersNotify->user, new MonthlyContributionNotification());
            }

        }

        $this->info('MonthlyContribution:Cron Command Run successfully!');
    }

}
