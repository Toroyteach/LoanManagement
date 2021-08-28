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
        //
        //send token to members phonenumber
        //using the sms service
        //
        \Log::info(" Auth Code Created");

        $memberNumber = User::find($twoStepAuthTable->userId);

        //Http::fake();
        
        $response = Http::asForm()->post($this->url, [
            'user' => env('SMS_USERNAME', 'null'),
            'password' => env('SMS_PASSWORD', 'null'),
            'mobiles' => $memberNumber->number,
            'sms' =>  'Please use this code to authenticate your account '.$twoStepAuthTable->authCode,
            'unicode' => 0,
            'senderid' => env('SMS_SENDERID', 'null'),
        ]);

        if($response->ok()){

            \Log::info("SMS code sent to ".$memberNumber->name);

        } else {

            \Log::info(" Failed to send Code to ".$memberNumber->name);
            \Log::error(now());

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
        //send token again to user after updating the previous one
        //using the sms service


        $changes = array_diff($twoStepAuthTable->getOriginal(), $twoStepAuthTable->getAttributes());
        if(array_key_exists('authCode', $changes) or array_key_exists('requestDate', $changes)){

            \Log::info(" Auth Code updated");

            $memberNumber = User::find($twoStepAuthTable->userId);
    
            //Http::fake();
            
            $response = Http::post($this->url, [
                'user' => env('SMS_USERNAME', 'null'),
                'password' => env('SMS_PASSWORD', 'null'),
                'mobiles' => $memberNumber->number,
                'sms' =>  'Please use this code to authenticate your account '.$twoStepAuthTable->authCode,
                'unicode' => 0,
                'senderid' => env('SMS_SENDERID', 'null'),
            ]);
    
            if($response->ok()){
    
                \Log::info("updated SMS code sent to ".$memberNumber->name);
    
            } else {
    
                \Log::info(" Failed to send updated Code to ".$memberNumber->name);
                \Log::error(now());
    
            }

        }

    }

    /**
     * Handle the two step auth table "deleted" event.
     *
     * @param  \App\TwoStepAuth  $twoStepAuthTable
     * @return void
     */
    public function deleted(TwoStepAuth $twoStepAuthTable)
    {
        //
    }

    /**
     * Handle the two step auth table "restored" event.
     *
     * @param  \App\TwoStepAuth  $twoStepAuthTable
     * @return void
     */
    public function restored(TwoStepAuth $twoStepAuthTable)
    {
        //
    }

    /**
     * Handle the two step auth table "force deleted" event.
     *
     * @param  \App\TwoStepAuth  $twoStepAuthTable
     * @return void
     */
    public function forceDeleted(TwoStepAuth $twoStepAuthTable)
    {
        //
    }
}
