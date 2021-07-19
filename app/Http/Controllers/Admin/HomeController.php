<?php

namespace App\Http\Controllers\Admin;
use App\LoanApplication;
use App\UsersAccount;
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

            $loan = LoanApplication::where('created_by_id', \Auth::user()->id)->where('status_id', '>' , 7)->sum('loan_amount');
            //dd(LoanApplication::where('created_by_id', \Auth::user()->id)->sum('loan_amount'));
            $loan_pending = LoanApplication::where('created_by_id', \Auth::user()->id)->where('repaid_status', 0)->where('status_id', '>' , 7)->sum('loan_amount');
            $amount_paid = LoanApplication::where('created_by_id', \Auth::user()->id)->sum('repaid_amount');
            $user = 'user';
            //logic to return data for the chart js of loan and loan types
            $line = json_encode($this->getLineGraphData('user', \Auth::user()->id), JSON_UNESCAPED_SLASHES );
            $pie = json_encode($this->getPieChartData('user', \Auth::user()->id), JSON_UNESCAPED_SLASHES );
            $opening_balance = UsersAccount::where('user_id', \Auth::user()->id)->first('total_amount');

        } else if(\Auth::user()->getIsAdminAttribute() || \Auth::user()->getIsCfoAttribute()){

            $loan = LoanApplication::where('status_id', '>' , 7)->sum('loan_amount');
            $loan_pending = LoanApplication::where('repaid_status', '=', 0)->where('status_id', '>' , 7)->sum('loan_amount');
            $amount_paid = LoanApplication::sum('repaid_amount');
            $user = 'admin';
                    //logic to return data for the chart js of loan and loan types
            $line = json_encode($this->getLineGraphData('Admin', \Auth::user()->id), JSON_UNESCAPED_SLASHES );
            $pie = json_encode($this->getPieChartData('Admin', \Auth::user()->id), JSON_UNESCAPED_SLASHES );
            $opening_balance = SaccoAccount::sum('deposit_bal');

        } else {
            
            $loan = LoanApplication::where('created_by_id', \Auth::user()->id)->where('status_id', '>' , 7)->sum('loan_amount');
            //dd(LoanApplication::where('created_by_id', \Auth::user()->id)->sum('loan_amount'));
            $loan_pending = LoanApplication::where('created_by_id', \Auth::user()->id)->where('repaid_status', 0)->where('status_id', '>' , 7)->sum('loan_amount');
            $amount_paid = LoanApplication::sum('repaid_amount');
            $user = 'user';//other than admin or cfo or user
            //logic to return data for the chart js of loan and loan types
            $line = json_encode($this->getLineGraphData('user', \Auth::user()->id), JSON_UNESCAPED_SLASHES );
            $pie = json_encode($this->getPieChartData('user', \Auth::user()->id), JSON_UNESCAPED_SLASHES );
            $opening_balance = UsersAccount::where('user_id', \Auth::user()->id)->first();

        }

        //dd($pie, $line);

        return view('admin.loanApplications.dashboard', compact('loan', 'user', 'loan_pending', 'amount_paid', 'line', 'pie', 'opening_balance'));
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
            for ($x = 0; $x <= 12; $x++) {
                $monthlyValues[$x] = LoanApplication::whereMonth('created_at', $x)->where('status_id', '=' , 8)->sum('loan_amount');
            }
        } else {
            for ($x = 0; $x <= 12; $x++) {
                $monthlyValues[$x] = LoanApplication::whereMonth('created_at', $x)->where('created_by_id', $id)->where('status_id', '=' , 8)->sum('loan_amount');
            }
        }
        
        return $monthlyValues;
    }
}
