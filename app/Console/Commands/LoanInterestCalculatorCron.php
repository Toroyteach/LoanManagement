<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\LoanApplication;
use Carbon\Carbon;
use App\User;
use Illuminate\Support\Facades\Http;
use App\SmsTextsSent;

class LoanInterestCalculatorCron extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'calculateloan:cron';

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

        $this->calculateLoan();

        return 0;
    }

    public function calculateLoan(){

        $loanItems = LoanApplication::where('repaid_status', 0)->where('status_id', 8)->get();

        foreach($loanItems as $key => $loanItem){

            $today = $loanItem->next_months_pay_date;

            $date = Carbon::parse($today);

            $now = Carbon::now();

            if($date->isToday()){

                if($loanItem->balance_amount < $loanItem->equated_monthly_instal){

                    $emi = $loanItem->balance_amount;
                    $loanItem->increment('next_months_pay', $emi);
                    
                } else {

                    $rate = config('loantypes.'.$loanItem->loan_type.'.interest');
                    $interestCalculator =  number_format((float)($rate / 100), 2, '.', '');
                    $interest = $interestCalculator * $loanItem->balance_amount;
                    $expectedMonthlyPayment = $loanItem->equated_monthly_instal + $interest;
                    $loanItem->increment('next_months_pay', $expectedMonthlyPayment);
                    $loanItem->increment('loan_amount_plus_interest', $interest);

                }


                $loanItem->next_months_pay_date = $date->addMonths(1);

                $loanItem->save();

                //tell of new notice overdue of paymnet of the loan item
                if($this->smsEnabled()){

                    $message = "Dear ".$loanItem->created_by->name.". You are hearby reminded that your next loan monthly payment with Mtangazaji Sacco is now over due and your monthly amount has been carried forward to the next month.";
        
                    $this->sendSms($loanItem->created_by_id, $message);
        
                }
            }


            $diff = $date->diffInDays($now);

            if($diff <= 2){

                //notify of the upcoming notice notification
                if($this->smsEnabled()){

                    $message = "Dear ".$loanItem->created_by->name.". You are hearby reminded that your next loan monthly payment with Mtangazaji Sacco is almost due. Please make plans to pay to avoind any inconveniences";
        
                    $this->sendSms($loanItem->created_by_id, $message);
        
                }

            }

        }

    }

    public function smsEnabled()
    {
        $sms = env("SMS_ENABLED"); 
        
        //dd($sms);
        
        if($sms == 1){
            
            return true;
            
        } else {
            
            return false;
        }
        
        
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
                    'description' => " Payment sms notification sent to ".$memberNumber->name,
                    'user_id' => $memberNumber->id,
                    'messageid' => $collection['sms']['messageid'],
                    'type' => "Loan Notification"
                ]);

                \Log::info("Pyament notification was sent to ".$memberNumber->name);

            }

        } else {

            \Log::info(" Failed to send notification to ".$memberNumber->name);
            \Log::error(now());

        }

    }


}
