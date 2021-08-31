<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\MonthlySavings;
use App\LoanApplication;
use App\Notifications\MonthlyContributionNotification;
use Illuminate\Support\Facades\Notification;
use Carbon\Carbon;
use Illuminate\Support\Facades\Http;

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
        $this->getMonthlySavingsNotification();
        
        $this->getDefaultors();

        $this->calculateLoanInterest();

        $this->info('MonthlyContribution:Cron Command Run successfully!');
    }

    public function getMonthlySavingsNotification()
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
                            'description' => 'Dear Member please ensure you make your monthly Contribution payment',
                            'name' => $user->user->name
                        ];

                        //dd($user->user_id);

                        $user->user->notify(new MonthlyContributionNotification($message));

                        $memberNumber = $user->user;
                
                        //Http::fake();
                        
                        $response = Http::asForm()->post($this->url, [
                            'user' => env('SMS_USERNAME', 'null'),
                            'password' => env('SMS_PASSWORD', 'null'),
                            'mobiles' => $memberNumber->number,
                            'sms' =>  'Dear Member you are reminder to make your monthly contribution before on coming deadline',
                            'unicode' => 0,
                            'senderid' => env('SMS_SENDERID', 'null'),
                        ]);
                
                        if($response->ok()){
                
                            \Log::info("SMS monthly notification sent to ".$memberNumber->name);
                
                        } else {
                
                            \Log::info(" Failed to send SMS monthly notification sent to ".$memberNumber->name);
                            \Log::error(now());
                
                        }

                        \Log::info($key." Monthly notification sent to this user ".$user->user->name);
                    }
            

            }

        }
    }

    public function getDefaultors()
    {

        $now = Carbon::now();

        $defaultors = LoanApplication::select(['id', 'created_by_id', 'status_id'])->where('repaid_status', '!=', 1)->whereDate('defaulted_date', '<=', $now)->with('created_by')->get();


        foreach($defaultors as $key => $defaultor)
        {
            $defaultor->status_id = 11;
            $defaultor->save();
            \Log::info('this member has defaulted the loan '.$defaultor->created_by->names);
        }
    }

    public function calculateLoanInterest()
    {
        
        $loanApplications = LoanApplication::select(['created_at', 'date_last_amount_paid', 'created_by', 'duration_count', 'duration'])->where('repaid_status', '!=', 1)->where('status_id', '=', 8)->with('created_by')->get();

        foreach($loanApplications as $key => $loanItem){

            $dateCreated = Carbon::parse($loanItem->created_at)->addMonths($loanItem->remaining_duration);

            //dd($dateCreated);
            
            if($dateCreated->isToday()){

                if($loanItem->duration_count <= $loanItem->duration){

                    $startDate = Carbon::createFromFormat('Y-m-d', '2021-07-20'); //first day of last month when interest was calculated last
                    $endDate = Carbon::createFromFormat('Y-m-d', '2021-08-20'); //today
            
                    $check = Carbon::parse($loanItem->date_last_amount_paid)->between($startDate, $endDate);

                    if($check){
                    
                        //made a paymanet to help reduce loan amount
                        $accumulatedAmount = $this->getOnReducingBalance($loanItem->accumulated_amount, $loanItem->last_month_amount_paid);

                        $loanItem->accumulated_amount = $accumulatedAmount;
                        $loanItem->increment('duration_count', 1);
                        $loanItem->save();

                    }

                    //nothing paid back in last month
                    $accumulatedAmount = $this->getOnReducingBalance($loanItem->accumulated_amount);

                    \Log::info("member loan interest was calculated for the member ".$loanItem->created_by->name);

                    if($loanItem->duration_count == $loanItem->duration){

                        \Log::info("This member is on his last month of loan pay ".$loanItem->created_by->name);

                    }

                }
            }

        }


    }

    public function getOnReducingBalance($principleAmount, $amountRePaid = 0)
    {
        
        $principal = $principleAmount;
        $rate = 0.01;
        //$time = $duration;
        $amounpaid = $amountRePaid;

        $accumulatedAmount = (($principal * $rate) + $principal) - $amounpaid;

        return $accumulatedAmount;
    }

}