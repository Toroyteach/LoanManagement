<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\MassDestroyLoanApplicationRequest;
use App\Http\Requests\StoreLoanApplicationRequest;
use App\Http\Requests\UpdateLoanApplicationRequest;
use App\LoanApplication;
use App\LoanFile;
use App\UsersAccount;
use App\Role;
use App\Services\AuditLogService;
use App\Status;
use App\User;
use Gate;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;
use Illuminate\Support\Str;
use Carbon\Carbon;
use App\Services\FirebaseService;
use App\MonthlySavings;
use App\Imports\LoanFilesImport;
use App\Imports\MonthlyFilesImport;
use App\LoanFileUpload;
use App\MonthlyFile;
use Maatwebsite\Excel\Facades\Excel;
use DataTables;
use DB;

class LoanApplicationsController extends Controller
{
    public function index()
    {
        abort_if(Gate::denies('loan_application_access'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $statusId = [1, 2, 3, 5, 6];
        $loanApplications = LoanApplication::with('status', 'accountant')->whereIn('status_id', $statusId)->orderBy('updated_at', 'ASC')->get();
        $defaultStatus    = Status::find(1);
        $user             = auth()->user();

        if($user->getIsMemberAttribute()){

            //modify to show application details and some news for user
            abort_if(Gate::denies('loan_application_create'), Response::HTTP_FORBIDDEN, '403 Forbidden');

            return view('admin.loanApplications.userapplyloan');
        }

        return view('admin.loanApplications.index', compact('loanApplications', 'defaultStatus', 'user'));
    }

    public function create()
    {
        abort_if(Gate::denies('loan_application_create'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        return view('admin.loanApplications.create');
    }

    public function staffCreate()
    {
        abort_if(Gate::denies('loan_application_create'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        return view('admin.loanApplications.userapplyloan');
    }

    public function store(StoreLoanApplicationRequest $request)
    {

        $entryNumber = mt_rand(100000, 1000000);
        $loanApplication = LoanApplication::create([
            'loan_entry_number' => $entryNumber,
            'loan_amount' => $request->loan_amount,
            'description' => $request->description,
            'loan_type' => $request->loan_type,
            'duration' => $request->duration,
        ]);

        //create firebase calls to insert to firebase
        $random = Str::random(20);
        
        $repaymentDate = date('Y-m-d', strtotime($request->duration.' months'));

        $loanApplication->firebaseid = $random;
        $loanApplication->repayment_date = $repaymentDate;
        $loanApplication->defaulted_date = Carbon::parse($repaymentDate)->addMonths(3);
        $loanApplication->save();
        

        return redirect()->route('admin.loan-applications.index')->with('success','Loan Application Request was created successfully!');
    }

    public function edit(LoanApplication $loanApplication)
    {
        //returns view with loan to change the status to the final stage of the loan i.e rejected or approved
        abort_if(
            Gate::denies('loan_application_edit') || !in_array($loanApplication->status_id, [6,7]),
            Response::HTTP_FORBIDDEN,
            '403 Forbidden'
        );

        $statuses = Status::whereIn('id', [1, 8, 9, 10])->pluck('name', 'id');

        $loanApplication->load('status');

        //getting data from cfo to ceo to approve to send to client money(after submit goes to update method below)

        return view('admin.loanApplications.edit', compact('statuses', 'loanApplication'));
    }

    public function update(UpdateLoanApplicationRequest $request, LoanApplication $loanApplication)
    {
        //makes the status change to approved or rejected to give out also update firebase

        //when updating the paymnent status of the loan to send money to user

        //update firebase data as well

        if($request->status_id == 8){

            $data = [
                'status' => $request->status_id,
                'approved' => true,
            ];


            $loanApplication->update($request->only('status_id'));
            
            $userData = UsersAccount::where('user_id', $loanApplication->created_by_id)->firstOrFail();
            $userData->increment('total_amount', $loanApplication->loan_amount);

        } else if($request->status_id == 9){

            //rejected by accountant

            $loanApplication->update($request->only('status_id'));
            

        }

        return redirect()->route('admin.loan-applications.index')->with('success','Loan Application was updated successfully!');
    }

    public function show(LoanApplication $loanApplication)
    {
        abort_if(Gate::denies('loan_application_show'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $loanApplication->load('status', 'accountant', 'creditCommittee', 'created_by', 'logs.user', 'comments');
        $defaultStatus = Status::find(1);
        $user          = auth()->user();
        $logs          = AuditLogService::generateLogs($loanApplication);
        $remaining     = $loanApplication->loan_amount - $loanApplication->repaid_amount;
        $maximumPayable = $remaining + 5000;
        $elligibleAmount = $this->getUserElligibleAmount();

        return view('admin.loanApplications.show', compact('loanApplication', 'defaultStatus', 'user', 'logs', 'remaining', 'elligibleAmount', 'maximumPayable'));
    }

    public function destroy(LoanApplication $loanApplication)
    {
        abort_if(Gate::denies('loan_application_delete'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $loanApplication->delete();

        //no soft deletes for firebase

        return back()->with('message','Loan was deleted successfully!');;
    }

    public function massDestroy(MassDestroyLoanApplicationRequest $request)
    {
        LoanApplication::whereIn('id', request('ids'))->delete();

        return response(null, Response::HTTP_NO_CONTENT);
    }

    public function showSend(LoanApplication $loanApplication)
    {
        
        if(!auth()->user()->is_admin){

            abort_if(!auth()->user()->is_accountant, Response::HTTP_FORBIDDEN, '403 Forbidden');

        }

        //this stage should only be used to send the loan application status to the credit commiteefor further editing
        //loan status id is 3 by default

        if (in_array($loanApplication->status_id, [3, 4, 5])) {

            $role = 'Credit Committee';
            $users = Role::find(4)->users->pluck('name', 'id');

        } else {

            abort(Response::HTTP_FORBIDDEN, '403 Forbidden');

        }

        return view('admin.loanApplications.send', compact('loanApplication', 'role', 'users'));
    }

    public function send(Request $request, LoanApplication $loanApplication)
    {
        // once a loan is created this is first instance of sending to next processing which is from accountant to 
        // (accountant(proccesing,approved, rejected))
        // 1st if statement is excecuted

        // once a loan is already approved then admin sends to cfo for further processing to
        // (cfo(proccesing,approved, rejected))
        // 2nd if statement is excecuted

        //also update firebase data here
        if(!auth()->user()->is_admin){

            abort_if(!auth()->user()->is_accountant, Response::HTTP_FORBIDDEN, '403 Forbidden');

        }

        if ($loanApplication->status_id == 1) {
            
            $column = 'analyst_id'; //accountant_id
            $users  = Role::find(3)->users->pluck('id');
            $status = 2;

        } else if (in_array($loanApplication->status_id, [3,4])) {

            $column = 'cfo_id'; //creditcommittee_id
            $users  = Role::find(4)->users->pluck('id');
            $status = 5;

        } else {

            abort(Response::HTTP_FORBIDDEN, '403 Forbidden');

        }

        $request->validate([
            'user_id' => 'required|in:' . $users->implode(',')
        ]);

        $data = [
            'status' => $status,
            'approved' => false,
        ];

            $loanApplication->update([
                $column => $request->user_id,
                'status_id' => $status
            ]);
    
            return redirect()->route('admin.loan-applications.index')->with('success', 'Loan Application forwaded for analysis');

    }

    public function showAnalyze(LoanApplication $loanApplication)
    {
        //accountant and credit committee to comment on the loan status
        $user = auth()->user();

        if(!$user->is_admin){

            abort_if((!$user->is_accountant || $loanApplication->status_id != 1) && (!$user->is_creditCommittee || !in_array($loanApplication->status_id, [5, 3])),
                Response::HTTP_FORBIDDEN,'403 Forbidden'
            );


        }

        return view('admin.loanApplications.analyze', compact('loanApplication'));
    }

    public function analyze(Request $request, LoanApplication $loanApplication)
    {

        // once analyst approves or rejects a loan this is where it comes back to for further udpating

        //once the cfo has approved the loan the loan comes back here to be sent to admin for final approval to be disbursed the amount
        $user = auth()->user();

        if ($user->is_accountant && $loanApplication->status_id == 1) {

            $status = $request->has('approve') ? 3 : 4;

        } else if ($user->is_creditcommittee && in_array($loanApplication->status_id, [5, 3])) {

            $status = $request->has('approve') ? 6 : 7;

        } else {

            abort(Response::HTTP_FORBIDDEN, '403 Forbidden');

        }

        $request->validate([
            'comment_text' => 'required'
        ]);
     
        $data = [
            'status' => $status,
            'approved' => false,
        ];


            $loanApplication->comments()->create([
                'comment_text' => $request->comment_text,
                'user_id'      => $user->id
            ]);
    
            $loanApplication->update([
                'status_id' => $status
            ]);
    
            return redirect()->route('admin.loan-applications.index')->with('message', 'Loan Application forwaded for analysis');

    }

    public function activeLoans()
    {
        //return all active loans return only approvec loans
        abort_if(Gate::denies('loan_application_access'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $loanApplications = LoanApplication::with('status', 'accountant', 'creditCommittee')->where('status_id', 8)->get();
        $defaultStatus    = Status::find(1);
        $user             = auth()->user();

        return view('admin.loanApplications.activeloans', compact('loanApplications', 'defaultStatus', 'user'));
    }

    public function clearedLoans()
    {
        //return all cleared loans. check repaid status
        abort_if(Gate::denies('loan_application_access'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $loanApplications = LoanApplication::with('status', 'accountant', 'creditCommittee')->where('repaid_status', 1)->where('status_id', 10)->get();
        $defaultStatus    = Status::find(1);
        $user             = auth()->user();

        return view('admin.loanApplications.clearedloans', compact('loanApplications', 'defaultStatus', 'user'));
    }

    public function rejectedLoans()
    {
        //return all cleared loans. check repaid status
        abort_if(Gate::denies('loan_application_access'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $statusId = [4,7,9];
        $loanApplications = LoanApplication::whereIn('status_id', $statusId)->get();
        $rejectedStatus    = Status::find(1);
        $user             = auth()->user();

        return view('admin.loanApplications.rejectedloans', compact('loanApplications', 'rejectedStatus', 'user'));
    }

    public function defaultors()
    {
        //return all logice to calculate defaultors loans
        abort_if(Gate::denies('loan_application_access'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        //only checking dates more than a month after repaid date was set.
        //creats repayment date
        // get todays date
        // get repaymnet set date
        // $this add repayment plus 3 months
        //check repaymtn dat passed $this
        $loanApplications = LoanApplication::with('status', 'accountant', 'creditCommittee')->where('status_id', '=', 11)->where('repaid_status', 0)->get();
        $defaultStatus    = Status::find(1);
        $user             = auth()->user();

        return view('admin.loanApplications.defaultors', compact('loanApplications', 'defaultStatus', 'user'));
    }

    public function makeRepaymentAmount(Request $request)
    {
        //check if the paid amount is full or partial them made

        $loanItem = LoanApplication::find($request->loan_id);

        if($loanItem->loan_amount <= $request->amount){ //greater than or equal loan amount

            $newAmount = $request->amount - $loanItem->balance_amount;

            if($newAmount != 0){
                $memberAccount = UsersAccount::where('user_id', $loanItem->created_by_id)->firstOrFail();
                $memberAccount->increment('total_amount', $newAmount);
            }

            $loanItem->last_month_amount_paid = $request->amount;
            $loanItem->date_last_amount_paid = now();
            $loanItem->status_id = 10;
            $loanItem->repaid_status = 1;
            $loanItem->increment('repaid_amount', $request->amount);
            $loanItem->decrement('balance_amount', $request->amount);


            if($loanItem->isDirty()){
                
                $loanItem->save();

                return response()->json(array('response' => true, 'message' => 'Success Repayment Amount Updated Succesfully. Member has fully settled Loan and Overpayment added to Member account'), 200);

            }

            return response()->json(array('response' => false, 'message' => 'Oops! Repayment amount was not updated '), 200);

        } else { //less than loan amount

            switch($loanItem->loan_type){
                case "emergency":

                    $rate = config('loantypes.Emergency.interest');
                    $time = config('loantypes.Emergency.max_duration');
                    $interest = ($loanItem->balance_amount * ( 1 + ( $rate / 100))) - $loanItem->balance_amount;

                    break;
                case "education":
                    
                    $rate = config('loantypes.SchoolFees.interest');
                    $time = config('loantypes.SchoolFees.max_duration');
                    $interest = ($loanItem->balance_amount * ( 1 + ( $rate / 100))) - $loanItem->balance_amount;

                    break;
                case "development":

                    $rate = config('loantypes.Development.interest');
                    $time = config('loantypes.Development.max_duration');
                    $interest = ($loanItem->balance_amount * ( 1 + ( $rate / 100))) - $loanItem->balance_amount;

                    break;
                case "instantloan":

                    $rate = config('loantypes.InstantLoan.interest');
                    $time = config('loantypes.InstantLoan.max_duration');
                    $interest = ($loanItem->balance_amount * ( 1 + ( $rate / 100))) - $loanItem->balance_amount;

                    break;

                default:
                    $interest = 0.00;
            }

            $amountPaid = 100;
            $monthlyEmi = $loanItem->next_months_pay;
        
            if($amountPaid >= $monthlyEmi){

                $overpayemntOfEmi = $amountPaid - $monthlyEmi;
                $loanItem->next_months_pay = $loanItem->equated_monthly_instal - $overpayemntOfEmi;
                $cashPayment = $amountPaid - $interest;

            } else {

                $underpayemntOfEmi = $monthlyEmi - $amountPaid;
                $nextAmount = $loanItem->equated_monthly_instal + $underpayemntOfEmi;
                $loanItem->next_months_pay =  $nextAmount;
                $cashPayment = $amountPaid - $interest;
            }
            

            $loanItem->decrement('balance_amount', $cashPayment);
            $loanItem->last_month_amount_paid = $amountPaid ;
            $loanItem->date_last_amount_paid = now();
            $loanItem->increment('repaid_amount', $amountPaid);
    
            
            if($loanItem->isDirty()){

                $loanItem->save();
                
                return response()->json(array('response' => true, 'message' => 'Success Repayment Amount Updated'), 200);
    
            }
    
            return response()->json(array('response' => false, 'message' => 'Oops! Repayment amount was not updated '), 200);

        }
    }

    public function createPdf($id)
    {      
          $loan = LoanFile::findOrFail($id);

          $pathToFile = storage_path('files/uploads/loanfiles/' . $loan->title);
        
          return response()->download($pathToFile);
    }

    public function getUserElligibleAmount()
    {
        $monthlyContribution = MonthlySavings::select(['total_contributed', 'overpayment_amount'])->where('user_id', auth()->user()->id)->first();
        $a = $monthlyContribution->overpayment_amount;
        $b = $monthlyContribution->total_contributed;
        $totalMonthlyContribution = ($a + $b) * 3;
        $outStandingLoan = LoanApplication::where('repaid_status', 0)->where('created_by_id', auth()->user()->id)->sum('loan_amount');
        $eligibleAmount = $totalMonthlyContribution - $outStandingLoan;
        
        return $eligibleAmount.'.00';

    }

    public function bulkView()
    {

        return view('admin.bulk.index');
    }

    public function bulkFile(Request $request)
    {

        request()->validate([
            'file'  => 'required|mimes:xls,xlsx',
          ]);
     
           if ($files = $request->file('file')) {
                
               //store file into document folder
               $filename = $request->file('file')->getClientOriginalName();
               $file = $request->file->storeAs('file', $filename, 'bulkfiles');
    
               $path = public_path('bulkfile/uploads').'/'.$file;

               if($request->type == 'loan') {

                   Excel::import(new LoanFilesImport, $path);

                   return Response()->json([
                       "success" => true,
                       "file" => 'loan'
                   ]);

               } else {

                   Excel::import(new MonthlyFilesImport, $path);

                   return Response()->json([
                        "success" => true,
                        "file" => 'monthly'
                    ]);

               }
     
           }
     
           return Response()->json([
                   "success" => false,
             ]);

    }

    public function fetchDatatable()
    {

            $data = LoanFileUpload::all();

            return Datatables::of($data)->addIndexColumn()->make(true);

    }

    public function fetchDatatableMo()
    {

            $data = MonthlyFile::all();

            return Datatables::of($data)->addIndexColumn()->make(true);

    }

    public function updateBulkFileDetails(Request $request)
    {
        //update details from the table
        
        if($request->type == 'loan'){

            $data = LoanFileUpload::all();

            foreach($data as $key => $item){

                $loanItem = LoanApplication::where('loan_entry_number', $item->entry_number)->first();


                if($loanItem->loan_amount <= $item->amount){ //greater than or equal loan amount
        
                    $newAmount = $item->amount - $loanItem->loan_amount;

        
                    if($newAmount != 0){

                        UsersAccount::where('user_id', $loanItem->created_by_id)->increment('total_amount', $newAmount);

                    }

                    
                    $loanItemUpdate = LoanApplication::where('loan_entry_number', $item->entry_number)->get();

                    $loanItemUpdate->last_month_amount_paid = $item->amount;
                    $loanItemUpdate->date_last_amount_paid = now();
                    $loanItemUpdate->status_id = 10;
                    $loanItemUpdate->repaid_status = 1;
                    $loanItemUpdate->increment('repaid_amount', $item->amount);
                    $loanItemUpdate->decrement('balance_amount', $item->amount);
                    $loanItemUpdate->save();
                    
           
                } else { //less than loan amount
        

                    $loanItemUpdate = LoanApplication::where('loan_entry_number', $item->entry_number)->get();

                    $amountPaid = $item->amount;
                    $monthlyEmi = $loanItemUpdate->next_months_pay;
                
                    if($amountPaid >= $monthlyEmi){
        
                        $overpayemntOfEmi = $amountPaid - $monthlyEmi;
                        $loanItemUpdate->next_months_pay = $loanItemUpdate->equated_monthly_instal - $overpayemntOfEmi;
                        $cashPayment = $amountPaid - $interest;
        
                    } else {
        
                        $underpayemntOfEmi = $monthlyEmi - $amountPaid;
                        $nextAmount = $loanItemUpdate->equated_monthly_instal + $underpayemntOfEmi;
                        $loanItemUpdate->next_months_pay =  $nextAmount;
                        $cashPayment = $amountPaid - $interest;
                    }
                    
        
                    $loanItemUpdate->decrement('balance_amount', $cashPayment);
                    $loanItemUpdate->last_month_amount_paid = $amountPaid ;
                    $loanItemUpdate->date_last_amount_paid = now();
                    $loanItemUpdate->increment('repaid_amount', $amountPaid);
                    $loanItemUpdate->save();
            
                }

            }

            LoanFileUpload::truncate();

            return Response()->json([
                "success" => true,
            ]);

        } else {

            $data = MonthlyFile::all();

            foreach($data as $key => $item){
                
                //$account = MonthlySavings::where('user_id', $data->user_id)->with('user')->first();
                $idno = $item->member_number;

                $amountToAdd = $item->amount;

                $account = DB::table('monthly_savings')
                ->join('users', 'monthly_savings.user_id', '=', 'users.id')
                ->where('users.idno', '=', $idno)
                ->increment('total_contributed', $amountToAdd, [
                    'modified_at' => Carbon::now()->toDateTimeString()
                ]);
        
            }

            MonthlyFile::truncate();

            return Response()->json([
                "success" => true,
            ]);
        }
    }

    public function deleteBulkFileDetails(Request $request)
    {
        //delete details from the table
        if($request->type == 'loan'){

            LoanFileUpload::truncate();

            return Response()->json([
                "success" => true,
          ]);

        } else {

            MonthlyFile::truncate();

            return Response()->json([
                "success" => true,
            ]);

        }
    }
}
