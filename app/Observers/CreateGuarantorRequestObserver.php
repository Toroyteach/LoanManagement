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

        $member->notify(new LoanGuarantorsNotification($user));

        //Http::fake();
        
        $response = Http::asForm()->post($this->url, [
            'user' => env('SMS_USERNAME', 'null'),
            'password' => env('SMS_PASSWORD', 'null'),
            'mobiles' => $member->number,
            'sms' =>  'Dear Member. '.$requestorName.' a member has requested you to be there gurantor. Please note if you do not act in 24hrs it will be assumed you accepted. Contact your administrator or log in to the website to reject',
            'unicode' => 0,
            'senderid' => env('SMS_SENDERID', 'null'),
        ]);

        if($response->ok()){

            \Log::info("SMS gurantor request sent to ".$member->name);

        } else {

            \Log::info(" Failed to send sms gurantor request to ".$member->name);
            \Log::error(now());

        }
    }

}
