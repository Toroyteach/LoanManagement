<?php

namespace App\Observers;

use App\LoanApplication;
use App\Notifications\NewApplicationNotification;
use App\Notifications\SentForAnalysisNotification;
use App\Notifications\StatusChangeNotification;
use App\Notifications\SubmittedAnalysisNotification;
use App\Role;
use App\Status;
use App\User;
use Illuminate\Support\Facades\Notification;
use App\SmsTextsSent;
use Illuminate\Support\Facades\Http;

class LoanApplicationObserver
{
    /**
     * Handle the loan application "creating" event.
     *
     * @param  \App\LoanApplication  $loanApplication
     * @return void
     */
    public function creating(LoanApplication $loanApplication)
    {
        //makes all loans by default processing upon creation

        $processingStatus = Status::whereName('Processing')->first();

        $loanApplication->status()->associate($processingStatus);
    }

    /**
     * Handle the loan application "created" event.
     *
     * @param  \App\LoanApplication  $loanApplication
     * @return void
     */
    public function created(LoanApplication $loanApplication)
    {
        //send mail to accountant upon creation of the loan

        $admins = Role::find(3)->users; //find all accountants
        
        $user = User::where('id', $loanApplication->created_by->id)->get(); //find user owner

        $email = collect($admins)->merge($user);

        Notification::send($email, new NewApplicationNotification($loanApplication));
    }

    /**
     * Handle the loan application "updated" event.
     *
     * @param  \App\LoanApplication  $loanApplication
     * @return void
     */
    public function updated(LoanApplication $loanApplication)
    {
        if ($loanApplication->isDirty('status_id')) {

            if (in_array($loanApplication->status_id, [1, 5])) {

                if ($loanApplication->status_id == 1) {

                    //chooses user as account who created the loan

                    $user = $loanApplication->accountant;

                } else {

                    //chooses user as credit committee who is supposed to give opinion

                    $user = $loanApplication->creditCommittee;

                }

                Notification::send($user, new SentForAnalysisNotification($loanApplication));

            } elseif (in_array($loanApplication->status_id, [3, 4, 6, 7])) {

                //sends notification to admin accountant and credit committee that loan was rejected or any other analysis
                $users = Role::find(1)->users;

                if(in_array($loanApplication->status_id, [3, 4])){

                    if($loanApplication->status_id == 3){

                        $emails = collect($users)->merge(Role::find(4)->users)->merge(Role::find(3)->users);
                        
                    } else {

                        $emails = collect($users)->merge(Role::find(3)->users);
                    }

                } else if(in_array($loanApplication->status_id, [6, 7])){

                   $emails = collect($users)->merge(Role::find(4)->users)->merge(Role::find(3)->users);
                    //only accountant and admin should be notified that the credoit committee rejected the

                }

                Notification::send($emails, new SubmittedAnalysisNotification($loanApplication));

            } elseif (in_array($loanApplication->status_id, [8, 9])) {

                //notification for either rejected or the final approved
                $loanApplication->created_by->notify(new StatusChangeNotification($loanApplication));//user
                $loanApplication->accountant->notify(new StatusChangeNotification($loanApplication));
                $loanApplication->creditCommittee->notify(new StatusChangeNotification($loanApplication));

                if($this->smsEnabled()){

                    $message = "Dear ".$loanApplication->created_by->name.". Your loan application was ".$loanApplication->status->name;
                    
                    $this->sendSms($loanApplication->created_by_id, $message);
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
                    'description' => " Loan Status notification sent to ".$memberNumber->name,
                    'user_id' => $memberNumber->id,
                    'messageid' => $collection['sms']['messageid'],
                    'type' => " Loan Status"
                ]);

                \Log::info("SMS (".$message.")code sent to ".$memberNumber->name);

            }

        } else {

            \Log::info(" Failed to send loan status to ".$memberNumber->name);
            \Log::error(now());

        }

    }
}
