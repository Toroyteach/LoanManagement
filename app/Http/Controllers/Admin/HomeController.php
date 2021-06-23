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

        } else {

            $loan = LoanApplication::sum('loan_amount');

        }
        return view('admin.loanApplications.dashboard', compact('loan'));
    }
}
