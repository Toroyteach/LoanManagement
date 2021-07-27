<?php

namespace App\Http\Controllers\Admin;
use App\LoanApplication;
use App\MonthlySavings;
use App\SaccoAccount;
use App\SaccoFile;
use Illuminate\Http\Request;
use Webpatser\Uuid\Uuid;

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

            $approved_loan = LoanApplication::where('created_by_id', \Auth::user()->id)->where('status_id', '=' , 8)->sum('loan_amount');// approved loan
            //dd($approved_loan);
            $loan_pending = LoanApplication::where('created_by_id', \Auth::user()->id)->where('repaid_status', 0)->where('status_id', '=' , 8)->sum('loan_amount');// 
            $amount_paid = LoanApplication::where('created_by_id', \Auth::user()->id)->sum('repaid_amount');
            $user = 'user';
                    //logic to return data for the chart js of loan and loan types for user
            $line = json_encode($this->getLineGraphData('user', \Auth::user()->id), JSON_UNESCAPED_SLASHES );
            $pie = json_encode($this->getPieChartData('user', \Auth::user()->id), JSON_UNESCAPED_SLASHES );
            $savings = MonthlySavings::where('user_id', \Auth::user()->id)->first('total_contributed'); //monthly savings
            //dd($line);

        } else {

            $approved_loan = LoanApplication::where('status_id', '=' , 8)->sum('loan_amount');
            $loan_pending = LoanApplication::where('repaid_status', '=', 0)->where('status_id', '=' , 8)->sum('loan_amount');//loan which havent been paid back
            $amount_paid = LoanApplication::sum('repaid_amount');// amount paied back
            $user = 'admin';
                    //logic to return data for the chart js of loan and loan types for admin
            $line = json_encode($this->getLineGraphData('Admin', \Auth::user()->id), JSON_UNESCAPED_SLASHES );
            $pie = json_encode($this->getPieChartData('Admin', \Auth::user()->id), JSON_UNESCAPED_SLASHES );
            $savings = SaccoAccount::sum('deposit_bal'); //total amount in sacco

        }

        //dd($pie, $line);

        return view('admin.loanApplications.dashboard', compact('savings', 'user', 'loan_pending', 'amount_paid', 'line', 'pie', 'approved_loan'));
    }

    public function createfile()
    {
        return view('admin.files.create');
    }

    public function store(Request $request)
    {
        $book = $request->all();
        $book['uuid'] = (string)Uuid::generate();
        if ($request->hasFile('cover')) {
            $book['cover'] = $request->cover->getClientOriginalName();
            $request->cover->storeAs('files', $book['cover']);
        }
        SaccoFile::create($book);
        return redirect()->back()->with('message','File was created successfully!');;
    }

    public function getPieChartData($userType, $id)
    {
        $loanTypeValues = array();
        $loanTypeKey = array('Emergency', 'SchoolFees', 'Development', 'TopUp');

        if($userType == 'Admin'){
            for ($x = 0; $x <= 3; $x++) {
                $loanTypeValues[$x] = LoanApplication::where('loan_type', $loanTypeKey[$x])->where('status_id', '=' , 8)->sum('loan_amount');
            }
        } else {
            for ($x = 0; $x <= 3; $x++) {
                $loanTypeValues[$x] = LoanApplication::where('loan_type', $loanTypeKey[$x])->where('created_by_id', $id)->where('status_id', '=' , 8)->sum('loan_amount');
            }
        }

        return $loanTypeValues;
    }

    public function getLineGraphData($userType, $id)
    {
        $monthlyValues = array();

        if($userType == 'Admin'){
            for ($x = 0; $x < 11; $x++) {
                $monthlyValues[$x] = LoanApplication::whereMonth('created_at', $x+1)->where('status_id', '=' , 8)->sum('loan_amount');
            }
        } else {
            for ($x = 0; $x < 11; $x++) {
                $monthlyValues[$x] = LoanApplication::whereMonth('created_at', $x+1)->where('created_by_id', $id)->where('status_id', '=' , 8)->sum('loan_amount');
            }
        }

        //dd($monthlyValues);
        
        return $monthlyValues;

        // $monthlyValues = array();
        // $dateToAdd = Carbon::now();
        // $time = strtotime("2010.12.11");
        // $d = new DateTime('first day of this month');
        // $id = 1;
        // dd(date("d/m/Y", strtotime('today'.' + '.$id.' days')));
        // dd(LoanApplication::whereDate('created_at', date("d/m/Y", strtotime('today'.' + 1 days')))->where('status_id', '=' , 8)->sum('loan_amount'));

        // if($userType == 'Admin'){
        //     for ($x = 0; $days <= 31; $x++) {
        //         $monthlyValues[$x] = LoanApplication::whereDate('created_at',  date('Y-m-d', strtotime("2021-07-24". ' + 1 days')))->sum('loan_amount');
        //     }
        // } else {
        //     for ($x = 0; $days <= 12; $x++) {
        //         $monthlyValues[$x] = LoanApplication::whereMonth('created_at', $x+1)->where('created_by_id', $id)->where('status_id', '=' , 8)->sum('loan_amount');
        //     }
        // }

        //   dd($monthlyValues);
        
        // return $monthlyValues;
    }
}
