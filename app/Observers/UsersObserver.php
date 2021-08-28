<?php

namespace App\Observers;

use App\Users;

class UsersObserver
{
    /**
     * Handle the users "created" event.
     *
     * @param  \App\Users  $users
     * @return void
     */
    public function created(Users $users)
    {
        //

        // UsersAccount::create([
        //     'total_amount' => 0.00,
        //     'user_id' => $user->id,
        // ]);

        // //add/deposit on the sacco account
        // SaccoAccount::create([
        //     'opening_bal' =>  0.00,
        //     'deposit_bal' =>  $request->amount,
        //     'created_by' =>   \Auth::user()->id,
        //     'user_id' =>  $user->id,
        // ]);

        // MonthlySavings::create([
        //     'total_contributed' =>  0.00,
        //     'monthly_amount' =>  $request->monthly_amount,
        //     'created_by' =>   \Auth::user()->id,
        //     'user_id' =>  $user->id,
        //     'next_payment_date' => Carbon::createFromFormat('Y-m-d H:i:s', $user->created_at)->firstOfMonth()->addDays(4)->addMonths(1)->format('Y-m-d'),
        //     'overpayment_amount' => 0.00,
        // ]);

        // NextKin::create([
        //     'name' => $request->kinname,
        //     'phone' => $request->kinphone,
        //     'relationship' => $request->kinrelationship,
        //     'user_id' => $user->id,
        // ]);

    }

    /**
     * Handle the users "updated" event.
     *
     * @param  \App\Users  $users
     * @return void
     */
    public function updated(Users $users)
    {
        //
    }

    /**
     * Handle the users "deleted" event.
     *
     * @param  \App\Users  $users
     * @return void
     */
    public function deleted(Users $users)
    {
        //
    }

    /**
     * Handle the users "restored" event.
     *
     * @param  \App\Users  $users
     * @return void
     */
    public function restored(Users $users)
    {
        //
    }

    /**
     * Handle the users "force deleted" event.
     *
     * @param  \App\Users  $users
     * @return void
     */
    public function forceDeleted(Users $users)
    {
        //
    }
}
