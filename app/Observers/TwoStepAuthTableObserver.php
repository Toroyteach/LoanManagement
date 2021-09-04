<?php

namespace App\Observers;

use App\TwoStepAuthTable;
use jeremykenedy\laravel2step\App\Models\TwoStepAuth;
use App\User;
use Illuminate\Support\Facades\Http;

class TwoStepAuthTableObserver
{

    protected $url = 'http://smskenya.brainsoft.co.ke/sendsms.jsp';
    //check only updated code to observe

    /**
     * Handle the two step auth table "created" event.
     *
     * @param  \App\TwoStepAuth  $twoStepAuthTable
     * @return void
     */
    public function created(TwoStepAuth $twoStepAuthTable)
    {

        if($this->smsEnabled()){
        //
            //send token to members phonenumber
            //using the sms service
            //
            \Log::info(" Auth Code Created");

            $memberNumber = User::find($twoStepAuthTable->userId);

            $name = $memberNumber->name;
            $number = $memberNumber->number;
            $code = $twoStepAuthTable->authCode;
            $smsUsername = env('SMS_USERNAME', 'null');
            $smsPassword = env('SMS_PASSWORD', 'null');
            $smsSenderId = env('SMS_SENDERID', 'null');

            
            //dd($number, $name, $code, $smsPassword, $smsSenderId, $smsUsername);
            //Http::fake();
            
            $response = $this->sendSms($number, $name, $code, $smsPassword, $smsSenderId, $smsUsername);

            //Http::fake();

            if($response->ok()){

                \Log::info("SMS code sent to ".$memberNumber->name);

            } else {

                \Log::info(" Failed to send Code to ".$memberNumber->name);
                \Log::error(now());

            }
        }
    }

    /**
     * Handle the two step auth table "updated" event.
     *
     * @param  \App\TwoStepAuth  $twoStepAuthTable
     * @return void
     */
    public function updated(TwoStepAuth $twoStepAuthTable)
    {
        
        if($this->smsEnabled()){
        
            //send token again to user after updating the previous one
            //using the sms service

            //dd($twoStepAuthTable);

            $changes = array_diff($twoStepAuthTable->getAttributes(), $twoStepAuthTable->getOriginal());

            //dd($changes);

            if(array_key_exists('authCode', $changes) || array_key_exists('requestDate', $changes)){


                \Log::info(" Auth Code updated");

                $memberNumber = User::select(['number', 'name'])->findOrFail($twoStepAuthTable->userId);

                $name = $memberNumber->name;
                $number = $memberNumber->number;
                $code = $twoStepAuthTable->authCode;
                $smsUsername = env('SMS_USERNAME', 'null');
                $smsPassword = env('SMS_PASSWORD', 'null');
                $smsSenderId = env('SMS_SENDERID', 'null');

                
                //dd($number, $name, $code, $smsPassword, $smsSenderId, $smsUsername);
                //Http::fake();
                
                $response = $this->sendSms($number, $name, $code, $smsPassword, $smsSenderId, $smsUsername);
                
                if($response->ok()){
                    
                    \Log::info("Response logged ".$response->getBody());
                    \Log::info("updated SMS code sent to ".$name);
        
                } else {
        
                    \Log::info(" Failed to send updated Code to ".$name);
                    \Log::error(now());
        
                }

                //dd($changes);

            }

            //dd('didnt send');
        }


    }

    public function smsEnabled()
    {
        return env('SMS_ENABLED', 0);
    }

    public function sendSms($number, $name, $code, $smsPassword, $smsSenderId, $smsUsername)
    {

        $response = Http::post($this->url, [
            'user' => $smsUsername,
            'password' => $smsPassword,
            'mobiles' => $number,
            'sms' =>  'Please use this code to authenticate your account '.$code,
            'unicode' => 0,
            'senderid' => $smsSenderId,
        ]);

        return $response;

    }
}
