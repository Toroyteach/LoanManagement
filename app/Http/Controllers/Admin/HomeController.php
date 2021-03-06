<?php

namespace App\Http\Controllers\Admin;
use App\LoanApplication;
use App\LoanGuarantor;
use App\LoanFile;
use App\MonthlySavings;
use App\UsersAccount;
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
use App\CreateLoanRequest;
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

            $approved_loan = LoanApplication::select(['loan_amount_plus_interest', 'status_id'])->where('created_by_id', \Auth::user()->id)->where('status_id', 10)->sum('loan_amount_plus_interest');//(approved loan with paid back loan as well)
            $loan_pending = LoanApplication::select(['loan_amount', 'balance_amount'])->where('created_by_id', \Auth::user()->id)->where('repaid_status', 0)->where('status_id', '=' , 8)->sum('balance_amount'); //(approved loan that hasent been paid back)

            $savings = MonthlySavings::select(['total_contributed', 'overpayment_amount', 'monthly_amount'])->where('user_id', \Auth::user()->id)->first(); //monthly savings
            $amount_paid = $savings['overpayment_amount'] + $savings['total_contributed']; // accumulates the users account(overpayment) and 

            $user = 'user';
                    //logic to return data for the chart js of loan and loan types for user
            $line = json_encode($this->getLineGraphData('user', \Auth::user()->id), JSON_UNESCAPED_SLASHES );
            $pie = json_encode($this->getPieChartData('user', \Auth::user()->id), JSON_UNESCAPED_SLASHES );

        } else {

            $approved_loan = LoanApplication::select(['loan_amount_plus_interest', 'status_id'])->where('status_id', 10)->sum('loan_amount_plus_interest');//(approved loan with paid back loan as well)
            $loan_pending = LoanApplication::select(['balance_amount'])->where('repaid_status', '=', 0)->where('status_id', '=' , 8)->sum('balance_amount');//(approved loan that hasent been paid back) //loan book
            $totalMonthlyContributionA = MonthlySavings::select(['total_contributed', 'overpayment_amount'])->sum('overpayment_amount');
            $totalMonthlyContributionB = MonthlySavings::select(['total_contributed', 'overpayment_amount'])->sum('total_contributed');

            $savings = ($totalMonthlyContributionA + $totalMonthlyContributionB) - $loan_pending;
            $amount_paid = $totalMonthlyContributionA + $totalMonthlyContributionB;

            $user = 'Admin';
                    //logic to return data for the chart js of loan and loan types for admin
            $line = json_encode($this->getLineGraphData('Admin', \Auth::user()->id), JSON_UNESCAPED_SLASHES );
            $pie = json_encode($this->getPieChartData('Admin', \Auth::user()->id), JSON_UNESCAPED_SLASHES );

        }

        $membersTopLoans = $this->getTopMembersLoans();


        $members = array();
        $membersActiveLoans = array();
        $membersAquiredLoans = array();

        foreach($membersTopLoans as $key => $value){

            array_push($members , $value['name']);
            array_push($membersActiveLoans , $value[0]['current']);
            array_push($membersAquiredLoans , $value['sum(loan_amount_plus_interest)']);

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
        $loanTypeKey = array('Emergency', 'SchoolFees', 'Development', 'InstantLoan');

        if($userType == 'Admin'){
            for ($x = 0; $x <= 3; $x++) {
                $loanTypeValues[$x] = LoanApplication::select(['loan_amount_plus_interest', 'status_id', 'loan_type'])->where('loan_type', $loanTypeKey[$x])->whereIn('status_id', [8, 10])->sum('loan_amount_plus_interest');
            }
        } else {
            for ($x = 0; $x <= 3; $x++) {
                $loanTypeValues[$x] = LoanApplication::select(['loan_amount_plus_interest', 'status_id', 'loan_type'])->where('loan_type', $loanTypeKey[$x])->where('created_by_id', $id)->whereIn('status_id', [8, 10])->sum('loan_amount_plus_interest');
            }
        }

        return $loanTypeValues;
    }

    public function getLineGraphData($userType, $id)
    {
        $monthlyValues = array();

        if($userType == 'Admin'){
            for ($x = 0; $x < 12; $x++) {
                $monthlyValues[$x] = LoanApplication::select(['loan_amount_plus_interest', 'status_id', 'created_at'])->whereMonth('created_at', $x+1)->whereIn('status_id', [8, 10])->sum('loan_amount_plus_interest');
            }
        } else {
            for ($x = 0; $x < 12; $x++) {
                $monthlyValues[$x] = LoanApplication::select(['loan_amount_plus_interest', 'status_id', 'created_at', 'created_by_id'])->whereMonth('created_at', $x+1)->where('created_by_id', $id)->whereIn('status_id', [8, 10])->sum('loan_amount_plus_interest');
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

    public function getTopMembersLoans()
    {

        $usersLoan = User::join('loan_applications', 'loan_applications.created_by_id', '=', 'users.id')
        ->selectRaw('users.id, users.name, sum(loan_amount_plus_interest), loan_applications.status_id')
        ->groupBy('users.id', 'users.name', 'loan_applications.status_id')
        ->whereIn('loan_applications.status_id', [8, 10])
        ->orderByDesc('sum(loan_amount_plus_interest)')
        ->limit(10)
        ->get(['users.id', 'users.name', 'loan_applications.loan_amount_plus_interest']);

        $dataResults = $usersLoan->toArray();

        foreach($dataResults as $key => $user){

            $memberCurrentLoan = LoanApplication::where('created_by_id', $user['id'])
            ->where('repaid_status', 0)
            ->whereIn('status_id', [8, 10])
            ->sum('balance_amount');

            array_push($dataResults[$key], ['current' => '-'.$memberCurrentLoan]);

        }

        return $dataResults;
    }

    public function requestGurantor(Request $request)
    {
        
        $gurantorRequest = CreateGuarantorLoanRequest::where('user_id', auth()->user()->id)->where('id', $request->loan_id)->firstOrFail();

        $failed = false;

        $gurantorRequest->request_status = $request->choice;

        if($gurantorRequest->isDirty('request_status')){

            $notice = auth()->user()->unreadNotifications()->where('id', $request->requestid)->first();
            $notice->markAsRead();

            $gurantorRequest->save();

        }

        $loanRequestedFor = CreateGuarantorLoanRequest::where('request_id', $request->loanitemid)->get();

        $totalGurantors = $loanRequestedFor->count();

        $acceptedGurantors = 0;

        foreach($loanRequestedFor as $loanItem){

            $status = $loanItem->request_status;

            if($status == 'Accepted'){

                $acceptedGurantors++;

            }

        }


        if($acceptedGurantors == $totalGurantors){
            //approve the loan automatically
            $resultStatus = $this->submitFinalForm($request->loanitemid);

        }

        if($failed){

            return response()->json(['success'=>'request has failed', 'status' => false]);
        }

        return response()->json(['success'=>'request submitted successfully', 'status' => true]);

    }

    public function submitFinalForm($requestId)
    {
        //after a rthird gurantor has been accepted the loan should be approved from there.

        $loanDetails = CreateLoanRequest::findOrFail($requestId);

        $entryNumber = mt_rand(100000, 1000000);
        //$defaluted = Carbon::
        $nextMonthsPay = $this->getFirstMonthsPayInterest($loanDetails->loan_amount, config('loantypes.'.$loanDetails->loan_type.'.interest'));
        $loanDuration = config('loantypes.'.$loanDetails->loan_type.'.max_duration');
        //dd('ready to submit form', $entryNumber, $this->amount, $this->description, $this->loan_type, $this->duration);
        $loanApplication = LoanApplication::create([
            'loan_entry_number' => $entryNumber,
            'loan_amount' => $loanDetails->loan_amount,
            'description' => $loanDetails->description,
            'loan_type' => $loanDetails->loan_type,
            'duration' => $loanDetails->duration,
            'defaulted_date' => Carbon::now()->addMonths($loanDetails->duration + 3),
            'repayment_date' => date('Y-m-d', strtotime($loanDuration.' months')),
            'equated_monthly_instal' => $loanDetails->emi,
            'next_months_pay' => $loanDetails->emi + $nextMonthsPay,
            'next_months_pay_date' => Carbon::now()->addMonths(1),
            'balance_amount' => $loanDetails->total_plus_interest,
            'loan_amount_plus_interest' => $loanDetails->total_plus_interest,
            'created_by_id' => $loanDetails->user->id,
            'accumulated_amount' => $loanDetails->loan_amount - $loanDetails->emi
        ]);

        $gurantors = CreateGuarantorLoanRequest::where('request_id', $requestId)->get();

        foreach($gurantors as $key => $guarantor){
            LoanGuarantor::create([
                'user_id' => $guarantor->user_id,
                'loan_application_id' => $loanApplication->id,
                'value' => $guarantor->request_status,
            ]);
        }

        //get files from request files to the new loan files
        foreach($loanDetails->files as $file){
            LoanFile::create([
                'title' => $file->title,
                'loan_application_id' => $loanApplication->id
            ]);
        }

            //deleted record from loan request
        $requestDetails = CreateLoanRequest::findOrFail($requestId);
        $requestDetails->delete();

    }

    public function getFirstMonthsPayInterest($principal, $rate)
    {

       $result = $principal * ($rate / 100);
       return  number_format((float)$result, 2, '.', '');
    }
}
