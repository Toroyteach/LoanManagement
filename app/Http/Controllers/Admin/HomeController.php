<?php

namespace App\Http\Controllers\Admin;
use App\LoanApplication;
use App\MonthlySavings;
use App\SaccoAccount;
use App\UserAccount;
use App\SaccoFile;
use Illuminate\Http\Request;
use Webpatser\Uuid\Uuid;
use App\Notifications\MonthlyContributionNotification;
use Illuminate\Support\Facades\Notification;
use Carbon\Carbon;
use App\User; 
use App\TwoStepAuthTable;
use Illuminate\Support\Facades\Http;
use App\Http\Controllers\Controller;
use App\CreateGuarantorLoanRequest;
use Mail;
use App\SmsTextsSent;

class HomeController extends Controller
{
    public function index()
    {
        return redirect()->route('admin.loan-applications.index');
    }


    public function dashboard()
    {
        //get and send loan details
        if(\Auth::user()->getIsMemberAttribute()){

            $approved_loan = LoanApplication::select(['loan_amount', 'status_id'])->where('created_by_id', \Auth::user()->id)->whereIn('status_id', [8, 10])->sum('loan_amount');// approved loan
            $loan_pending = LoanApplication::select(['loan_amount'])->where('created_by_id', \Auth::user()->id)->where('repaid_status', 0)->where('status_id', '=' , 8)->sum('loan_amount'); //loan book
            $amount_paid = LoanApplication::select(['repaid_amount'])->where('created_by_id', \Auth::user()->id)->sum('repaid_amount'); //amount paid back for user
            $user = 'user';
                    //logic to return data for the chart js of loan and loan types for user
            $line = json_encode($this->getLineGraphData('user', \Auth::user()->id), JSON_UNESCAPED_SLASHES );
            $pie = json_encode($this->getPieChartData('user', \Auth::user()->id), JSON_UNESCAPED_SLASHES );
            $savings = MonthlySavings::select(['total_contributed'])->where('user_id', \Auth::user()->id)->first(); //monthly savings

        } else {

            $approved_loan = LoanApplication::select(['loan_amount', 'status_id'])->whereIn('status_id', [8, 10])->sum('loan_amount');
            $loan_pending = LoanApplication::select(['loan_amount'])->where('repaid_status', '=', 0)->where('status_id', '=' , 8)->sum('loan_amount');//loan which havent been paid back //loan book
            $amount_paid = LoanApplication::sum('repaid_amount');// amount paied back for all
            $user = 'admin';
                    //logic to return data for the chart js of loan and loan types for admin
            $line = json_encode($this->getLineGraphData('Admin', \Auth::user()->id), JSON_UNESCAPED_SLASHES );
            $pie = json_encode($this->getPieChartData('Admin', \Auth::user()->id), JSON_UNESCAPED_SLASHES );
            $savings = SaccoAccount::sum('deposit_bal'); //total amount in sacco

        }

        $membersTopLoans = $this->getTopMembersLoans();


        $members = array();
        $membersActiveLoans = array();
        $membersAquiredLoans = array();

        foreach($membersTopLoans as $key => $value){

            array_push($members , $value['name']);
            array_push($membersActiveLoans , $value[0]['current']);
            array_push($membersAquiredLoans , $value['sum(loan_amount)']);

        }

        $members_json = json_encode($members, JSON_UNESCAPED_SLASHES);
        $membersActiveLoans_json = json_encode($membersActiveLoans, JSON_UNESCAPED_SLASHES);
        $membersAquiredLoans_json = json_encode($membersAquiredLoans, JSON_UNESCAPED_SLASHES);

        return view('admin.dashboard', compact('savings', 'user', 'loan_pending', 'amount_paid', 'line', 'pie', 'approved_loan', 'members_json', 'membersActiveLoans_json', 'membersAquiredLoans_json'));
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
        $loanTypeKey = array('emergency', 'education', 'development', 'instantloan');

        if($userType == 'Admin'){
            for ($x = 0; $x <= 3; $x++) {
                $loanTypeValues[$x] = LoanApplication::select(['loan_amount', 'status_id', 'loan_type'])->where('loan_type', $loanTypeKey[$x])->whereIn('status_id', [8, 10])->sum('loan_amount');
            }
        } else {
            for ($x = 0; $x <= 3; $x++) {
                $loanTypeValues[$x] = LoanApplication::select(['loan_amount', 'status_id', 'loan_type'])->where('loan_type', $loanTypeKey[$x])->where('created_by_id', $id)->whereIn('status_id', [8, 10])->sum('loan_amount');
            }
        }

        return $loanTypeValues;
    }

    public function getLineGraphData($userType, $id)
    {
        $monthlyValues = array();

        if($userType == 'Admin'){
            for ($x = 0; $x < 12; $x++) {
                $monthlyValues[$x] = LoanApplication::select(['loan_amount', 'status_id', 'created_at'])->whereMonth('created_at', $x+1)->whereIn('status_id', [8, 10])->sum('loan_amount');
            }
        } else {
            for ($x = 0; $x < 12; $x++) {
                $monthlyValues[$x] = LoanApplication::select(['loan_amount', 'status_id', 'created_at', 'created_by_id'])->whereMonth('created_at', $x+1)->where('created_by_id', $id)->whereIn('status_id', [8, 10])->sum('loan_amount');
            }
        }
        
        return $monthlyValues;

    }

    public function notifications()
    {
        $notifications = auth()->user()->notifications;

        return view('admin.notifications.notification', compact('notifications'));
    }

    public function markNotification(Request $request)
    {
        
        auth()->user()
            ->unreadNotifications
            ->when($request->input('id'), function ($query) use ($request) {
                return $query->where('id', $request->input('id'));
            })
            ->markAsRead();

            return response()->json(['success'=>'request submitted successfully', 'status' => true]);
    }

    public function requestGurantor(Request $request)
    {
        
        $gurantorRequest = CreateGuarantorLoanRequest::where('user_id', auth()->user()->id)->where('id', $request->loan_id)->firstOrFail();

        $gurantorRequest->request_status = $request->choice;

        if($gurantorRequest->isDirty('request_status')){

            auth()->user()->unreadNotifications->when($request->input('id'), function ($query) use ($request) {
                return $query->where('id', $request->input('id'));
            })->markAsRead();

            $gurantorRequest->save();

            return response()->json(['success'=>'request submitted successfully', 'status' => true]);

        }

        return response()->json(['success'=>'request has failed', 'status' => false]);
    }

    public function getTopMembersLoans()
    {

        $usersLoan = User::join('loan_applications', 'loan_applications.created_by_id', '=', 'users.id')
        ->selectRaw('users.id, users.name, sum(loan_amount), loan_applications.status_id')
        ->groupBy('users.id', 'users.name', 'loan_applications.status_id')
        ->whereIn('loan_applications.status_id', [8, 10])
        ->orderByDesc('sum(loan_amount)')
        ->limit(10)
        ->get(['users.id', 'users.name', 'loan_applications.loan_amount']);

        $dataResults = $usersLoan->toArray();

        foreach($dataResults as $key => $user){

            $memberCurrentLoan = LoanApplication::where('created_by_id', $user['id'])
            ->where('repaid_status', 0)
            ->where('status_id', ([ 8, 11]))
            ->sum('loan_amount');

            array_push($dataResults[$key], ['current' => '-'.$memberCurrentLoan]);

        }

        return $dataResults;
    }
}
