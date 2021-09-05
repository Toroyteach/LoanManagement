<?php

namespace App\Observers;

use App\TwoStepAuthTable;
use jeremykenedy\laravel2step\App\Models\TwoStepAuth;
use App\User;
use Illuminate\Support\Facades\Http;
use App\SmsTextsSent;

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
            $message = "Please use the following code to authenticate your account ".$twoStepAuthTable->authCode;

            $this->sendSms($twoStepAuthTable->userId, $message);
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

            if(array_key_exists('authCode', $changes)){

                $message = "Please use the following code to authenticate your account ".$twoStepAuthTable->authCode;

                $this->sendSms($twoStepAuthTable->userId, $message);

            }

            //dd('didnt send');
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
