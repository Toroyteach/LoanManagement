<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\MonthlySavings;
use App\LoanApplication;
use App\Notifications\MonthlyContributionNotification;
use Illuminate\Support\Facades\Notification;
use Carbon\Carbon;
use Illuminate\Support\Facades\Http;
use App\SmsTextsSent;

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
                
                        $text = "Dear $user->user->name Please ensure you make your monthly Contribution payment";

                        $this->sendSms($user->user_id, $text);
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
        
        $loanApplications = LoanApplication::select(['loan_amount', 'loan_type', 'accumulated_amount', 'created_at', 'date_last_amount_paid', 'last_month_amount_paid', 'created_by', 'duration_count', 'duration'])->where('repaid_status', '!=', 1)->where('status_id', '=', 8)->with('created_by')->get();

        foreach($loanApplications as $key => $loanItem){

            $dateCreated = Carbon::parse($loanItem->created_at)->addMonths($loanItem->duration_count);

            //dd($dateCreated);
            
            if($dateCreated->isToday()){

                if($loanItem->duration_count <= $loanItem->duration){

                    //check which type of loan it was to get if on reducing or normal
                    if($loanItem->loan_type != 'instantloan'){ //the rest is on reducing

                        $accumulatedAmount = $this->getOnReducingBalance($loanItem->loan_amount);
                        $loanItem->balance_amount = $accumulatedAmount - $loanItem->loan_amount;
                        $loanItem->increment('accumulated_amount', $accumulatedAmount);
                        $loanItem->increment('duration_count', 1);
                        $loanItem->save();

                    } else {

                        $startDate = Carbon::createFromFormat('Y-m-d', $dateCreated); //first day of last month when interest was calculated last
                        $endDate = Carbon::now(); //today
                
                        $check = Carbon::parse($loanItem->date_last_amount_paid)->between($startDate, $endDate);
    
                        if($check){
                        
                            //made a paymanet to help reduce loan amount
                            $accumulatedAmount = $this->getOnReducingBalance($loanItem->accumulated_amount, $loanItem->last_month_amount_paid);
    
                            $loanItem->accumulated_amount = $accumulatedAmount;
                            $loanItem->balance_amount = $accumulatedAmount - $loanItem->loan_amount;
                            $loanItem->increment('duration_count', 1);
                            $loanItem->save();
    
                        } else {
    
                            //nothing paid back in last month
                            $accumulatedAmount = $this->getOnReducingBalance($loanItem->accumulated_amount);
                            $loanItem->accumulated_amount = $accumulatedAmount;
                            $loanItem->balance_amount = $accumulatedAmount - $loanItem->loan_amount;
                            $loanItem->increment('duration_count', 1);
                            $loanItem->save();
    
                        }
    
                        \Log::info("member loan interest was calculated for the member ".$loanItem->created_by->name);
    
                        if($loanItem->duration_count == $loanItem->duration){
    
                            \Log::info("This member is on his last month of loan pay ".$loanItem->created_by->name);
    
                        }
                    }

                } else {

                    //member defaulted the loan

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

    public function sendSms($id, $message)
    {

        $usernameSMS = env('SMS_USERNAME', 'null');
        $passwordSMS = env('SMS_PASSWORD', 'null');
        $senderIdSMS = env('SMS_SENDERID', 'null');

        $memberNumber = User::select(['number', 'id', 'name'])->findOrFail($id);

        $response = Http::asForm()->post('http://smskenya.brainsoft.co.ke/sendsms.jsp', [
            'user' => $usernameSMS,
            'password' => $passwordSMS,
            'mobiles' => $memberNumber->number,
            'sms' =>  $message,
            'unicode' => 0,
            'senderid' => $senderIdSMS,
        ]);

        if($response->ok()){

            $xml = simplexml_load_string($response->getBody(),'SimpleXMLElement',LIBXML_NOCDATA);

            // json
            $json = json_encode($xml);

            $array = json_decode($json, true);

            $collection = collect($array);

            if($collection['sms']['mobile-no'] == $memberNumber->number){

                SmsTextsSent::create([
                    'smsclientid' => $collection['sms']['smsclientid'],
                    'description' => " Auth code sent to ".$memberNumber->name,
                    'user_id' => $memberNumber->id,
                    'messageid' => $collection['sms']['messageid'],
                    'type' => " Auth code"
                ]);

                \Log::info("SMS (".$message.") code sent to ".$memberNumber->name);

            }

        } else {

            \Log::info(" Failed to send Code to ".$memberNumber->name);
            \Log::error(now());

        }

    }

}
