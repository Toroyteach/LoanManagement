<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\MassDestroyLoanApplicationRequest;
use App\Http\Requests\StoreLoanApplicationRequest;
use App\Http\Requests\UpdateLoanApplicationRequest;
use App\LoanApplication;
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

class LoanApplicationsController extends Controller
{
    public function index()
    {
        abort_if(Gate::denies('loan_application_access'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $statusId = [1, 2, 3, 5, 6];
        $loanApplications = LoanApplication::with('status', 'accountant')->whereIn('status_id', $statusId)->orderBy('updated_at', 'ASC')->get();
        $defaultStatus    = Status::find(1);
        $user             = auth()->user();
        //dd($user->getIsCfoAttribute());
        //dd($loanApplications);
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
        //dd($request->all());
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
        //dd($random);

        // $loanDetails = [
        //     'loanentrynumber' => $entryNumber,
        //     'loandescription' => $loanApplication->description,
        //     'amount' => $loanApplication->loan_amount,
        //     'created_at' => $loanApplication->created_at,
        //     'id' => $loanApplication->created_by->firebaseid,
        //     'status' => $loanApplication->status_id,
        //     'docID' => $random,
        // ];
        
        $repaymentDate = date('Y-m-d', strtotime($request->duration.' months'));

        $loanApplication->firebaseid = $random;
        $loanApplication->repayment_date = $repaymentDate;
        $loanApplication->defaulted_date = Carbon::parse($repaymentDate)->addMonths(3);
        $loanApplication->save();
        
        //$newLoan = $service->createLoan($loanDetails);

        //dd($newLoan);


       // if(!$newLoan){

            //\Log::info("Loan application was not creatd to firebase id => ".$loanApplication->firebaseid.' loan id '.$loanApplication->id);

            //return redirect()->route('admin.loan-applications.index')->with('message','Loan Application Request was created successfully!');

        //} else {

            return redirect()->route('admin.loan-applications.index')->with('success','Loan Application Request was created successfully!');

        //}
    }

    public function edit(LoanApplication $loanApplication)
    {
        //dd($loanApplication);
        //returns view with loan to change the status to the final stage of the loan i.e rejected or approved
        abort_if(
            Gate::denies('loan_application_edit') || !in_array($loanApplication->status_id, [6,7]),
            Response::HTTP_FORBIDDEN,
            '403 Forbidden'
        );

        $statuses = Status::whereIn('id', [1, 8, 9, 10])->pluck('name', 'id');

        $loanApplication->load('status');

        //dd('edit'.$loanApplication);
        //getting data from cfo to ceo to approve to send to client money(after submit goes to update method below)

        return view('admin.loanApplications.edit', compact('statuses', 'loanApplication'));
    }

    public function update(UpdateLoanApplicationRequest $request, LoanApplication $loanApplication)
    {
        //dd('give out the money');
        //makes the status change to approved or rejected to give out also update firebase

        //when updating the paymnent status of the loan to send money to user

        //dd($request, $loanApplication);
        //update firebase data as well

        if($request->status_id == 8){

            $data = [
                'status' => $request->status_id,
                'approved' => true,
            ];

            //$updateFirebaseLoan = $service->updateLoan($data, $loanApplication->firebaseid);

            //if(!$updateFirebaseLoan){

                //return redirect()->back()->with('error','Loan Application was not updated successfully!');

            //}

            $loanApplication->update($request->only('status_id'));
            
            $userData = UsersAccount::where('user_id', $loanApplication->created_by_id)->firstOrFail();
            $userData->increment('total_amount', $loanApplication->loan_amount);
            //dd('success');

        } else if($request->status_id == 9){

            //rejected by accountant
            //$data = [
                //'status' => $request->status_id,
                //'approved' => true,
            //];

            //$updateFirebaseLoan = $service->updateLoan($data, $loanApplication->firebaseid);

            //if(!$updateFirebaseLoan){

                //return redirect()->back()->with('error','Loan Application was not updated successfully!');

            //}

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
        //dd($remaining);

        return view('admin.loanApplications.show', compact('loanApplication', 'defaultStatus', 'user', 'logs', 'remaining'));
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
        
        //dd('here');
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

        //dd('send back to admin');
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

        //dd($loanApplication);

       // $updateFirebaseLoan = $service->updateLoan($data, $loanApplication->firebaseid);

        //if($updateFirebaseLoan){

            $loanApplication->update([
                $column => $request->user_id,
                'status_id' => $status
            ]);
    
            return redirect()->route('admin.loan-applications.index')->with('success', 'Loan Application forwaded for analysis');

        //}

        //return redirect()->back()->with('error', 'Loan Application was not processed successfuly');

    }

    public function showAnalyze(LoanApplication $loanApplication)
    {
        //accountant and credit committee to comment on the loan status
        //dd($loanApplication);
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
        //dd('analysis updating');
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

        //dd($data, $loanApplication->firebaseid);


       // $updateFirebaseLoan = $service->updateLoan($data, $loanApplication->firebaseid);


        //if($updateFirebaseLoan){

            $loanApplication->comments()->create([
                'comment_text' => $request->comment_text,
                'user_id'      => $user->id
            ]);
    
            $loanApplication->update([
                'status_id' => $status
            ]);
    
            return redirect()->route('admin.loan-applications.index')->with('message', 'Loan Application forwaded for analysis');

        //}

        //return redirect()->back()->with('error', 'Analysis was not submitted successfully');
    }

    public function createLoan($params)
    {
        // $newLoan = app('firebase.firestore')->database()->collection('LoanRequest')->document($params['docID']);
        // $newLoan->set([
        //     'user_id' => $params['id'],
        //     'loanentrynumber' => $params['loanentrynumber'],
        //     'description' => $params['loandescription'],
        //     'amount' => $params['amount'],
        //     'created_at' => $params['created_at'],
        //     'status' => $params['status'],
        //     'approved' => false
        // ]);
        // return $newLoan;
    }

    public function updateLoan($params)
    {
        //dd($params);
        // $loan = app('firebase.firestore')->database()->collection('LoanRequest')->document($params['docId'])
        //         ->update([
        //             ['path' => 'status', 'value' => $params['status']],
        //             ['path' => 'approved', 'value' => $params['approved']]
        //         ]);

        // return $loan; 
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
        //dd($loanApplications);

        return view('admin.loanApplications.defaultors', compact('loanApplications', 'defaultStatus', 'user'));
    }

    public function makeRepaymentAmount(Request $request)
    {

        //check if the paid amount is full or partial them made
        //notify members here or use observers to notify member of the changes

        $loanItem = LoanApplication::select(['last_month_amount_paid', 'date_last_amount_paid', 'loan_amount', 'repaid_status', 'created_by_id'])->find($request->loan_id);

        if($loanItem->loan_amount <= $request->amount){ //greater than or equal loan amount

            $newAmount = $request->amount - $loanItem->loan_amount;

            if($newAmount != 0){
                $memberAccount = UserAccount::where('user_id', $loanItem->created_by_id)->firstOrFail();
                $memberAccount->increment('total_amount', $newAmount);
            }

            $loanItem->last_month_amount_paid = $request->amount;
            $loanItem->date_last_amount_paid = now();
            $loanItem->status_id = 10;

            $loanItem->save();

            if($loanItem->isDirty() && $memberAccount->isDirty()){

                return response()->json(array('response' => true, 'message' => 'Success Repayment Amount Updated Succesfully. Memeber has fully settled Loan and Overpayment added to Member account'), 200);

            }

            return response()->json(array('response' => false, 'message' => 'Oops! Repayment amount was not updated '), 200);

        } else { //less than loan amount

    
            $loanItem->last_month_amount_paid = $request->amount;
            $loanItem->date_last_amount_paid = now();
    
            $loanItem->save();
    
            if($loanItem->isDirty() && $memberAccount->isDirty()){
    
                return response()->json(array('response' => true, 'message' => 'Success Repayment Amount Updated'), 200);
    
            }
    
            return response()->json(array('response' => false, 'message' => 'Oops! Repayment amount was not updated '), 200);

        }
    }

    public function createPdf($id)
    {      
          $loan = LoanApplication::select(['file'])->findOrFail();

          $pathToFile = storage_path('files/uploads/loanfiles/' . $book->file);
        
          return response()->download($pathToFile);
    }
}
