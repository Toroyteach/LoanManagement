<?php

namespace App\Observers;

use App\CreateGuarantorLoanRequest;
use App\Notifications\LoanGuarantorsNotification;
use Illuminate\Support\Facades\Notification;
use App\User;
use Illuminate\Support\Facades\Http;

class CreateGuarantorRequestObserver
{

    protected $url = 'http://smskenya.brainsoft.co.ke/sendsms.jsp';
    /**
     * Handle the create guarantor loan request "created" event.
     *
     * @param  \App\CreateGuarantorLoanRequest  $createGuarantorLoanRequest
     * @return void
     */
    public function created(CreateGuarantorLoanRequest $createGuarantorLoanRequest)
    {
        //send gurantor notification request
        $member = User::findOrFail($createGuarantorLoanRequest->user_id);// to be notified
        $requestorName = $createGuarantorLoanRequest->request->user->name;// initiating the request

        $user = [
            'id' => $createGuarantorLoanRequest->id,
            'description' => 'A member '.$requestorName.' has requested you to become there guarantor.',
            'name' => $member->name
        ];

        //dd($user->user_id);

        //$member->notify(new LoanGuarantorsNotification($user));

        //Http::fake();

        if($this->smsEnabled()){
        
            $message = "Dear Member. '.$requestorName.' a member has requested you to be there gurantor. Please note if you do not act in 24hrs it will be assumed you accepted. Contact your administrator or log in to the website to reject";
            //'sms' =>  'Dear Member. '.$requestorName.' a member has requested you to be there gurantor. Please note if you do not act in 24hrs it will be assumed you accepted. Contact your administrator or log in to the website to reject',

            $this->sendSms($member->id, $message);

        }
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
                    'description' => $memberNumber->name.' requested to be gurantor',
                    'user_id' => $memberNumber->id,
                    'messageid' => $collection['sms']['messageid'],
                    'type' => " Gurantor Request"
                ]);

                \Log::info("SMS (".$message.") code sent to ".$memberNumber->name);

            }

        } else {

            \Log::info(" Failed to send guaranto request to ".$memberNumber->name);
            \Log::error(now());

        }

    }

}
