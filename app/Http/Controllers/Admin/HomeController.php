<?php

namespace App\Http\Controllers\Admin;
use App\LoanApplication;
use App\MonthlySavings;
use App\SaccoAccount;
use App\SaccoFile;
use Illuminate\Http\Request;
use Webpatser\Uuid\Uuid;
use Carbon\Carbon;

class HomeController
{
    public function index()
    {
        return redirect()->route('admin.loan-applications.index');
    }

    public function dashboard()
    {

        $daysInCurrentMonth = cal_days_in_month(CAL_GREGORIAN, Carbon::now()->format('m'), Carbon::now()->format('Y'));
        //dd($daysInCurrentMonth);
        $days = json_encode((range(1, $daysInCurrentMonth)));


        //get and send loan details
        if(\Auth::user()->getIsUserAttribute()){

            $approved_loan = LoanApplication::where('created_by_id', \Auth::user()->id)->where('status_id', '=' , 8)->sum('loan_amount');// approved loan
            //dd($approved_loan);
            $loan_pending = LoanApplication::where('created_by_id', \Auth::user()->id)->where('repaid_status', 0)->where('status_id', '=' , 8)->sum('loan_amount');// 
            $amount_paid = LoanApplication::where('created_by_id', \Auth::user()->id)->sum('repaid_amount');
            $user = 'user';
                    //logic to return data for the chart js of loan and loan types for user
            $line = json_encode($this->getLineGraphData('user', $days, \Auth::user()->id), JSON_UNESCAPED_SLASHES );
            $pie = json_encode($this->getPieChartData('user', \Auth::user()->id), JSON_UNESCAPED_SLASHES );
            $savings = MonthlySavings::where('user_id', \Auth::user()->id)->first('total_contributed'); //monthly savings
            //dd($line);

        } else {

            $approved_loan = LoanApplication::where('status_id', '=' , 8)->sum('loan_amount');
            //dd($approved_loan);
            $loan_pending = LoanApplication::where('repaid_status', '=', 0)->where('status_id', '=' , 8)->sum('loan_amount');//loan which havent been paid back
            $amount_paid = LoanApplication::sum('repaid_amount');// amount paied back
            $user = 'admin';
                    //logic to return data for the chart js of loan and loan types for admin
            $line = json_encode($this->getLineGraphData('Admin', $days, \Auth::user()->id), JSON_UNESCAPED_SLASHES );
            $pie = json_encode($this->getPieChartData('Admin', \Auth::user()->id), JSON_UNESCAPED_SLASHES );
            $savings = SaccoAccount::sum('deposit_bal'); //total amount in sacco
            //dd($savings);

        }

        return view('admin.loanApplications.dashboard', compact('savings', 'user', 'loan_pending', 'amount_paid', 'line', 'pie', 'approved_loan', 'days'));
    }

    public function createfile()
    {
        return view('admin.files.create');
    }

    public function createArrayDays($days)
    {
        $days = array(range(1, $days));
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

    public function getLineGraphData($userType, $days, $id)
    {
        $monthlyValues = array();
        $dateToAdd = Carbon::now();
        //dd($dateToAdd->toDateTime()->addDays('1'));
        //dd(LoanApplication::whereMonth('created_at', date('m'))->whereDate('created_at', $dateToAdd->addDays('1'))->where('status_id', '=' , 8)->sum('loan_amount'));

        if($userType == 'Admin'){
            for ($x = 0; $x <= 12; $x++) {
                $monthlyValues[$x] = LoanApplication::whereMonth('created_at', $x+1)->sum('loan_amount');
            }
        } else {
            for ($x = 0; $x <= 12; $x++) {
                $monthlyValues[$x] = LoanApplication::whereMonth('created_at', $x+1)->where('created_by_id', $id)->where('status_id', '=' , 8)->sum('loan_amount');
            }
        }

        //  dd($monthlyValues);
        
        return $monthlyValues;
    }
}