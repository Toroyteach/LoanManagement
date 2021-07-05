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

class LoanApplicationsController extends Controller
{
    public function index()
    {
        abort_if(Gate::denies('loan_application_access'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $loanApplications = LoanApplication::with('status', 'analyst', 'cfo')->get();
        $defaultStatus    = Status::find(1);
        $user             = auth()->user();

        return view('admin.loanApplications.index', compact('loanApplications', 'defaultStatus', 'user'));
    }

    public function create()
    {
        abort_if(Gate::denies('loan_application_create'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        return view('admin.loanApplications.create');
    }

    public function store(StoreLoanApplicationRequest $request)
    {
        //dd($request->all());
        $loanApplication = LoanApplication::create($request->only('loan_amount', 'description', 'loan_type', 'duration'));
        //dd($loanApplication);

        //create fiorebase calls to insert to firebase
        $random = Str::random(20);
        //dd($random);

        $loanDetails = [
            'loandescription' => $loanApplication->description,
            'amount' => $loanApplication->loan_amount,
            'created_at' => $loanApplication->created_at,
            'id' => $loanApplication->created_by_id,
            'status' => $loanApplication->status_id,
            'docID' => $random,
        ];

        $loanApplication->firebaseid = $random;
        $loanApplication->repayment_date = date('Y-m-d', strtotime($request->duration.' months'));
        $loanApplication->save();
        
        $newLoan = $this->createLoan($loanDetails);

        if(!$newLoan){
            return false;
        } else {
            return redirect()->route('admin.loan-applications.index')->with('message','Loan was created successfully!');;
        }
    }

    public function edit(LoanApplication $loanApplication)
    {
        abort_if(
            Gate::denies('loan_application_edit') || !in_array($loanApplication->status_id, [6,7]),
            Response::HTTP_FORBIDDEN,
            '403 Forbidden'
        );

        $statuses = Status::whereIn('id', [1, 8, 9])->pluck('name', 'id');

        $loanApplication->load('status');

        //dd('edit'.$loanApplication);
        //getting data from cfo to ceo to approve to send to client money(updater method below)

        return view('admin.loanApplications.edit', compact('statuses', 'loanApplication'))->with('message','Loan was updated succesfully');;
    }

    public function update(UpdateLoanApplicationRequest $request, LoanApplication $loanApplication)
    {
        //dd($request->all());
        $loanApplication->update($request->only('loan_amount', 'description', 'status_id'));
        //dd('update'.$loanApplication);

        $userData = UsersAccount::where('user_id', 43)->firstOrFail();
        $userData->increment('total_amount', $loanApplication->loan_amount);
        //dd($userData);
        //when updating the paymnent status of the loan to send money to user

        if($request->status_id == 8){

            $data = [
                'user_id' => $loanApplication->created_by_id, 
                'status' => $request->status_id,
                'approved' => true,
                'docId' => $loanApplication->firebaseid
            ];

            $updateFirebaseLoan = $this->updateLoan($data);

            if(!$updateFirebaseLoan){
                return false;
            }
            //dd('success');

        }

        return redirect()->route('admin.loan-applications.index')->with('message','Loan was updated successfully!');;
    }

    public function show(LoanApplication $loanApplication)
    {
        abort_if(Gate::denies('loan_application_show'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $loanApplication->load('status', 'analyst', 'cfo', 'created_by', 'logs.user', 'comments');
        $defaultStatus = Status::find(1);
        $user          = auth()->user();
        $logs          = AuditLogService::generateLogs($loanApplication);

        return view('admin.loanApplications.show', compact('loanApplication', 'defaultStatus', 'user', 'logs'));
    }

    public function destroy(LoanApplication $loanApplication)
    {
        abort_if(Gate::denies('loan_application_delete'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $loanApplication->delete();

        return back()->with('message','Loan was deleted successfully!');;
    }

    public function massDestroy(MassDestroyLoanApplicationRequest $request)
    {
        LoanApplication::whereIn('id', request('ids'))->delete();

        return response(null, Response::HTTP_NO_CONTENT);
    }

    public function showSend(LoanApplication $loanApplication)
    {
        abort_if(!auth()->user()->is_admin, Response::HTTP_FORBIDDEN, '403 Forbidden');

        if ($loanApplication->status_id == 1) {
            $role = 'Analyst';
            $users = Role::find(3)->users->pluck('name', 'id');
        } else if (in_array($loanApplication->status_id, [3,4])) {
            $role = 'CFO';
            $users = Role::find(4)->users->pluck('name', 'id');
        } else {
            abort(Response::HTTP_FORBIDDEN, '403 Forbidden');
        }

        return view('admin.loanApplications.send', compact('loanApplication', 'role', 'users'));
    }

    public function send(Request $request, LoanApplication $loanApplication)
    {
        abort_if(!auth()->user()->is_admin, Response::HTTP_FORBIDDEN, '403 Forbidden');

        if ($loanApplication->status_id == 1) {
            $column = 'analyst_id';
            $users  = Role::find(3)->users->pluck('id');
            $status = 2;
        } else if (in_array($loanApplication->status_id, [3,4])) {
            $column = 'cfo_id';
            $users  = Role::find(4)->users->pluck('id');
            $status = 5;
        } else {
            abort(Response::HTTP_FORBIDDEN, '403 Forbidden');
        }

        $request->validate([
            'user_id' => 'required|in:' . $users->implode(',')
        ]);

        $loanApplication->update([
            $column => $request->user_id,
            'status_id' => $status
        ]);

        return redirect()->route('admin.loan-applications.index')->with('message', 'Loan application has been sent for analysis');
    }

    public function showAnalyze(LoanApplication $loanApplication)
    {
        $user = auth()->user();

        abort_if(
            (!$user->is_analyst || $loanApplication->status_id != 2) && (!$user->is_cfo || $loanApplication->status_id != 5),
            Response::HTTP_FORBIDDEN,
            '403 Forbidden'
        );

        return view('admin.loanApplications.analyze', compact('loanApplication'));
    }

    public function analyze(Request $request, LoanApplication $loanApplication)
    {
        $user = auth()->user();

        if ($user->is_analyst && $loanApplication->status_id == 2) {
            $status = $request->has('approve') ? 3 : 4;
        } else if ($user->is_cfo && $loanApplication->status_id == 5) {
            $status = $request->has('approve') ? 6 : 7;
        } else {
            abort(Response::HTTP_FORBIDDEN, '403 Forbidden');
        }

        $request->validate([
            'comment_text' => 'required'
        ]);

        $loanApplication->comments()->create([
            'comment_text' => $request->comment_text,
            'user_id'      => $user->id
        ]);

        $loanApplication->update([
            'status_id' => $status
        ]);

        return redirect()->route('admin.loan-applications.index')->with('message', 'Analysis has been submitted');
    }

    public function createLoan($params)
    {
        $newLoan = app('firebase.firestore')->database()->collection('LoanRequest')->document($params['docID']);
        $newLoan->set([
            'user_id' => $params['id'],
            'description' => $params['loandescription'],
            'amount' => $params['amount'],
            'created_at' => $params['created_at'],
            'status' => $params['status'],
            'approved' => false
        ]);
        return $newLoan;
    }

    public function updateLoan($params)
    {
        //dd($params);
        $loan = app('firebase.firestore')->database()->collection('LoanRequest')->document($params['docId'])
                ->update([
                    ['path' => 'status', 'value' => $params['status']],
                    ['path' => 'approved', 'value' => $params['approved']]
                ]);

        return $loan; 
    }

    public function activeLoans()
    {
        //return all active loans return only approvec loans
        abort_if(Gate::denies('loan_application_access'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $loanApplications = LoanApplication::with('status', 'analyst', 'cfo')->where('status_id', 8)->get();
        $defaultStatus    = Status::find(1);
        $user             = auth()->user();

        return view('admin.loanApplications.activeloans', compact('loanApplications', 'defaultStatus', 'user'));
    }

    public function clearedLoans()
    {
        //return all cleared loans. check repaid status
        abort_if(Gate::denies('loan_application_access'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $loanApplications = LoanApplication::with('status', 'analyst', 'cfo')->where('repaid_status', 1)->get();
        $defaultStatus    = Status::find(1);
        $user             = auth()->user();

        return view('admin.loanApplications.clearedloans', compact('loanApplications', 'defaultStatus', 'user'));
    }

    public function defaultors()
    {
        //return all logice to calculate defaultors loans
        abort_if(Gate::denies('loan_application_access'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        //only checking dates more than a month after repaid date was set.
        //creats repayment date
        $now = Carbon::create(2021, 06, 30, 11, 59, 59, 'CAT')->addMonths(3);
        // get todays date
        // get repaymnet set date
        // $this add repayment plus 3 months
        //check repaymtn dat passed $this
        $loanApplications = LoanApplication::with('status', 'analyst', 'cfo')->where('status_id', '>', 8)->where('repaid_status', 0)->whereDate('repayment_date', '<=', $now)->get();
        $defaultStatus    = Status::find(1);
        $user             = auth()->user();
        //dd($loanApplications);

        return view('admin.loanApplications.defaultors', compact('loanApplications', 'defaultStatus', 'user'));
    }
}
