<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\MonthlySavings;
use App\LoanApplication;
use App\Notifications\MonthlyContributionNotification;
use App\Notifications\FailedRequestNotification;
use Illuminate\Support\Facades\Notification;
use Carbon\Carbon;
use Illuminate\Support\Facades\Http;
use App\SmsTextsSent;
use App\User;
use App\CreateGuarantorLoanRequest;
use App\CreateLoanRequest;
use App\LoanFile;
use App\LoanGuarantor;

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

        $this->checkGurantorRequest();

        $this->finalSubmitRequest();

        $this->info('MonthlyContribution:Cron Command Run successfully!');
    }

    public function getMonthlySavingsNotification()
    {
        if(in_array(date('j'), [1, 3, 5])){

            $usersNotify = MonthlySavings::whereRaw('MONTH(next_payment_date) = '. Carbon::now()->month)->with('user')->get();

            if($usersNotify->count() < 1){
                
                \Log::info("No users to send notification this Today");

            } else {

                foreach ($usersNotify as $key => $user) {

                        $message = [
                            'id' => $user->user_id,
                            'description' => 'Dear Member please ensure you make your monthly Contribution payment',
                            'name' => $user->user->name
                        ];

                        //dd($user->user_id);

                        $user->user->notify(new MonthlyContributionNotification($message));

                        $memberNumber = $user->user;
                        
                        if($this->smsEnabled()){

                            $text = "Dear $user->user->name Please ensure you make your monthly Contribution payment";
    
                            $this->sendSms($user->user_id, $text);

                
                        }
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

    public function checkGurantorRequest()
    {
        $allLoanRequest = CreateLoanRequest::with('gurantorStatus')->get();
    
            foreach($allLoanRequest as $key => $gurantorItem){

                foreach($gurantorItem->gurantorStatus as $key => $gurantor){
                
                    $currentStatus = $gurantor->request_status;
    
                    if($currentStatus == 'Pending'){
                        
                        $checkDate = Carbon::parse($gurantor->created_at);
                        $now = Carbon::now();
                        $diff = $checkDate->diffInDays($now); 
                    
                        if($diff == 2){
                            $gurantor->request_status = 'Accepted';
                            $gurantor->save();
                        }
    
                    }
                }

            }

    }

    public function finalSubmitRequest()
    {
        $allLoanRequest = CreateLoanRequest::all();

        foreach($allLoanRequest as $key => $loanItem){

            $totalCount = CreateGuarantorLoanRequest::where('request_id', $loanItem->id)->where('request_status', '=', 'Accepted')->count();

            $loanRequestedFor = CreateGuarantorLoanRequest::where('request_id', $loanItem->id)->count();
        

            if($totalCount == $loanRequestedFor){

                $loanDetails = CreateLoanRequest::findOrFail($loanItem->id);

                $entryNumber = mt_rand(100000, 1000000);
                $nextMonthsPay = $this->getFirstMonthsPayInterest($loanDetails->loan_amount, config('loantypes.'.$loanDetails->loan_type.'.interest'));
                $loanDuration = config('loantypes.'.$loanDetails->loan_type.'.max_duration');

                //dd('ready to submit form', $entryNumber, $this->amount, $this->description, $this->loan_type, $this->duration);
                $loanApplication = LoanApplication::create([
                    'loan_entry_number' => $entryNumber,
                    'loan_amount' => $loanDetails->loan_amount,
                    'description' => $loanDetails->description,
                    'loan_type' => $loanDetails->loan_type,
                    'duration' => $loanDetails->duration,
                    'defaulted_date' => Carbon::now()->addMonths($loanDetails->duration + 3),
                    'repayment_date' => date('Y-m-d', strtotime($loanDuration.' months')),
                    'equated_monthly_instal' => $loanDetails->emi,
                    'next_months_pay' => $loanDetails->emi + $nextMonthsPay,
                    'next_months_pay_date' => Carbon::now()->addMonths(1),
                    'balance_amount' => $loanDetails->total_plus_interest,
                    'loan_amount_plus_interest' => $loanDetails->total_plus_interest,
                    'created_by_id' => $loanDetails->user->id
                ]);

                $gurantors = CreateGuarantorLoanRequest::where('request_id', $loanItem->id)->get();

                foreach($gurantors as $key => $guarantor){
                    LoanGuarantor::create([
                        'user_id' => $guarantor->user_id,
                        'loan_application_id' => $loanApplication->id,
                        'value' => $guarantor->request_status,
                    ]);
                }

                //get files from request files to the new loan files
                foreach($loanDetails->files as $file){
                    LoanFile::create([
                        'title' => $file->title,
                        'loan_application_id' => $loanApplication->id
                    ]);
                }


                    //deleted record from loan request
                $requestDetails = CreateLoanRequest::where('user_id', $loanApplication->created_by_id)->first();
                $requestDetails->delete();
            } 

            $totalCountRejected = CreateGuarantorLoanRequest::where('request_id', $loanItem->id)->where('request_status', '=', 'Rejected')->count();

            if($totalCountRejected >= 3){

                //send notification of rejection

                $member = User::findOrFail($loanDetails->user->id);// to be notified
        
                $user = [
                    'id' => $loanItem->id,
                    'description' => "Dear $member->firstname. Your Loan Request with Mtangazaji Sacco was Rejected. You do not qualify minimum Gurantors that should Accept to Gurantee your Loan Request.",
                    'name' => $member->name
                ];
        
        
                $member->notify(new FailedRequestNotification($user));
        
                if($this->smsEnabled()){
                
                    $message = "Dear $member->firstname. Your Loan Request with Mtangazaji Sacco was Rejected. You do not qualify minimum Gurantors that should Accept to Gurantee your Loan Request.";
        
                    $this->sendSms($member->id, $message);
        
                }


                $loanDetails = CreateLoanRequest::findOrFail($loanItem->id);

                $loanDetails->delete();

            }
        }
    }

    public function getFirstMonthsPayInterest($principal, $rate)
    {
        $result = $principal * ($rate / 100);

       return  number_format((float)$result, 2, '.', '');
    }

    public function smsEnabled()
    {
        return env('SMS_ENABLED', 0);
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
