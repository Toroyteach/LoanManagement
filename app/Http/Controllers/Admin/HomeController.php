<?php

namespace App\Http\Controllers\Admin;
use App\LoanApplication;

class HomeController
{
    public function index()
    {
        return redirect()->route('admin.loan-applications.index');
    }

    public function dashboard()
    {
        //get and send loan details
        if(\Auth::user()->getIsUserAttribute()){

            $loan = LoanApplication::where('created_by_id', \Auth::user()->id)->sum('loan_amount');
            //dd(LoanApplication::where('created_by_id', \Auth::user()->id)->sum('loan_amount'));
            $loan_pending = LoanApplication::where('created_by_id', \Auth::user()->id)->where('repaid_status', 0)->sum('loan_amount');
            $amount_paid = LoanApplication::sum('repaid_amount');
            $user = 'user';

        } else {

            $loan = LoanApplication::sum('loan_amount');
            $loan_pending = LoanApplication::where('repaid_status', '=', 0)->sum('loan_amount');
            $amount_paid = LoanApplication::sum('repaid_amount');


            $user = 'admin';

        }

        return view('admin.loanApplications.dashboard', compact('loan', 'user', 'loan_pending', 'amount_paid'));
    }
}
