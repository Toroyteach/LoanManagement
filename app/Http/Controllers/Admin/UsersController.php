<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\MassDestroyUserRequest;
use App\Http\Requests\StoreUserRequest;
use App\Http\Requests\FirstTimeLoginRequest;
use App\Http\Requests\UpdateUserRequest;
use App\Http\Requests\UpdateUserProfileRequest;
use App\Http\Requests\AdminUpdateRequest;
use App\Role;
use App\User;
use App\UsersAccount;
use App\SaccoAccount;
use App\MonthlySavings;
use App\Services\AuditLogService;
use Gate;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;
use Kreait\Firebase\Auth;
use Image;
use Illuminate\Support\Str;
use App\SaccoFile;
use App\LoanApplication;
use App\LoanGuarantor;
use App\Traits\UploadAble;
use App\NextKin;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;
use Carbon\Carbon;
use PDF;
use App\Services\FirebaseService;
use App\Action\StoreUserAction;
use Validator;
use Mail;
use Illuminate\Support\Facades\Hash;
use App\UserBulk;

class UsersController extends Controller
{

    public function __construct()
    {
        $this->middleware('auth');
    }

    public function index()
    {
        abort_if(Gate::denies('user_access'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $users = User::all();

        return view('admin.users.index', compact('users'));
        //dd('bulk add users');
        // $bulkUsers = UserBulk::all();

        // $start = microtime(true);

        // foreach($bulkUsers as $key => $item){

        //     $user = User::create([
        //         'firstname' => trim($item->fristname),
        //         'middlename' => trim($item->middlename),
        //         'lastname' => trim($item->lastname),
        //         'nationalid' => trim($item->nationalid),
        //         'number' => trim($item->number),
        //         'idno' => trim($item->memberno),
        //         'email' => strtolower(trim($item->fristname)).''.strtolower(trim($item->lastname)).'@mtangazajisacco.co.ke',
        //         'password' => 'password',
        //         'name' => trim($item->fristname).' '.trim($item->lastname),
        //     ]);

        //     $user->roles()->sync(1);
        //     $user->save();

        //     UsersAccount::create([
        //         'total_amount' => 0.00,
        //         'user_id' => $user->id,
        //     ]);

        //     //add/deposit on the sacco account
        //     SaccoAccount::create([
        //         'opening_bal' =>  0.00,
        //         'deposit_bal' =>  0.00, //registration amount
        //         'created_by' =>   2, //staff who created the account
        //         'user_id' =>  $user->id,
        //     ]);

        //     MonthlySavings::create([
        //         'total_contributed' =>  0.00,
        //         'monthly_amount' =>  1000.00,
        //         'created_by' =>   \Auth::user()->id,
        //         'user_id' =>  $user->id,
        //         'next_payment_date' => Carbon::createFromFormat('Y-m-d H:i:s', $user->created_at)->firstOfMonth()->addDays(4)->addMonths(1)->format('Y-m-d'),
        //         'overpayment_amount' => 0.00,
        //     ]);
        // }

        // $time_elapsed_secs = microtime(true) - $start;

        // dd('done', $time_elapsed_secs);
    }

    public function create()
    {
        abort_if(Gate::denies('user_create'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $roles = Role::all()->pluck('title', 'id');

        return view('admin.users.create', compact('roles'));
    }

    public function store(StoreUserRequest $request, StoreUserAction $action)
    {
        
        $this->validate(request(), [
            'number' => 
                array(
                    'required',
                    'regex:/(254)[0-9]{9}/'
                )
        ]);


        $user = User::create($request->validated());
        UsersAccount::create([
            'total_amount' => 0.00,
            'user_id' => $user->id,
        ]);

        //add/deposit on the sacco account
        SaccoAccount::create([
            'opening_bal' =>  0.00,
            'deposit_bal' =>  $request->amount, //registration amount
            'created_by' =>   \Auth::user()->id, //staff who created the account
            'user_id' =>  $user->id,
        ]);

        MonthlySavings::create([
            'total_contributed' =>  0.00,
            'monthly_amount' =>  $request->monthly_amount,
            'created_by' =>   \Auth::user()->id,
            'user_id' =>  $user->id,
            'next_payment_date' => Carbon::createFromFormat('Y-m-d H:i:s', $user->created_at)->firstOfMonth()->addDays(4)->addMonths(1)->format('Y-m-d'),
            'overpayment_amount' => 0.00,
        ]);


        //dynamic adding of multiple next of kins
        foreach($request->input('kin') as $key => $value) {

            NextKin::create([
                'name' => $value['name'],
                'phone' => $value['number'],
                'relationship' => $value['type'],
                'user_id' => $user->id,
            ]);   

        }

        $uid = Str::random(20);

        $user->name = $request->firstname.' '.$request->lastname;
        $user->middlename = $request->middlename;
        $user->save();
        $user->roles()->sync($request->input('roles', []));


        if ($request->has('avatar')) {
            $filename = time() . '_' . $request->file('avatar')->getClientOriginalName();
            $request->file('avatar')->storeAs('profileavatar', $filename, 'uploads');
            $user->avatar = $filename;
    		$user->save();
        }

        return redirect()->route('admin.users.index')->with('success','User created successfully!');

    }

    public function firstTimeLoginUpdate(FirstTimeLoginRequest $request)
    {

        //fill in the new details of the user
        $user = User::find(\Auth::user()->id);
        $user->update($request->all());

        //dynamic adding of multiple next of kins
        foreach($request->input('kin') as $key => $value) {

            NextKin::create([
                'name' => $value['name'],
                'phone' => $value['number'],
                'relationship' => $value['type'],
                'user_id' => $user->id,
            ]);   

        }

        if ($request->has('avatar')) {
            $filename = time() . '_' . $request->file('avatar')->getClientOriginalName();
            $request->file('avatar')->storeAs('profileavatar', $filename, 'uploads');
            $user->avatar = $filename;
        }
        
        $user->save();

        //send the verification link to the new email provided
        $user->sendEmailVerificationNotification();

        //redirect home.
        \Auth::logout();
        return redirect('/login');
    }

    public function getUserFillProfile()
    {
        return view('admin.users.resetInfo.update');
    }

    public function completeDetails()
    {
        return view('admin.users.resetInfo.index');
    }

    public function edit(User $user)
    {
        abort_if(Gate::denies('user_edit'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $roles = Role::all()->pluck('title', 'id');

        $user->load('roles');

        return view('admin.users.edit', compact('roles', 'user'));
    }

    public function update(UpdateUserRequest $request, User $user)
    {

            $user->update($request->all());
            $user->roles()->sync($request->input('roles', []));

            if ($request->has('avatar')) {
                $filename = time() . '_' . $request->file('avatar')->getClientOriginalName();
                $request->file('avatar')->storeAs('profileavatar', $filename, 'uploads');
                $user->avatar = $filename;
                $user->save();
            }

            return redirect()->route('admin.users.index')->with('success','User updated successfully!');

    }

    public function updateAdminProfile(AdminUpdateRequest $request, User $user)
    {

        $user->update($request->validated());

        // if ($request->has('avatar')) {

        //     $this->validate($request, [
        //         'avatar' => 'required|image|mimes:jpeg,png,jpg,gif,svg|max:2048'
        //     ]);

        //     $filename = time() . '_' . $request->file('avatar')->getClientOriginalName();

        //     $request->file('avatar')->storeAs('profileavatar', $filename, 'uploads');

        //     $user->avatar = $filename;
            
    	// 	$user->save();
        // }

        return redirect()->back()->with('success','User updated successfully!');

    }

    public function getAdminProfile(User $user)
    {

        return view('auth.adminedit', compact('user'));
    }

    public function updateAdminProfileImage(Request $request)
    {

        //updating the profile image of the admin

        $filename = time() . '_' . $request->file('file')->getClientOriginalName();

        $imageUpload = User::find(\Auth::user()->id);

        $request->file('file')->storeAs('profileavatar', $filename, 'uploads');
        
        $imageUpload->avatar = $filename;

        $imageUpload->save();

        return response()->json(['success'=>$imageName]);

    }

    public function updateUserProfile(UpdateUserProfileRequest $request, User $user)
    {
        //updates from users control
        $user->update($request->validated());

        
        //no need to update firbase data since they arent recorded by firebase

        return redirect()->back()->with('message','User updated successfully!');
    }

    public function getUserProfile(User $user)
    {

        return view('auth.profile', compact('user'));
    }

    public function show(User $user)
    {
        abort_if(Gate::denies('user_show'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $user->load('roles');
        $currentLoanAmount = LoanApplication::where('created_by_id', $user->id)->where('repaid_status', 0)->where('status_id', 8)->first();
        $userAccount = UsersAccount::where('user_id', $user->id)->first();
        $loanApplications = LoanApplication::with('status', 'accountant', 'creditCommittee')->where('created_by_id', $user->id)->get();
        $kins = NextKin::where('user_id', $user->id)->get();

        $gurantors = LoanGuarantor::where('user_id', $user->id)->get();

        return view('admin.users.show', compact('user', 'currentLoanAmount', 'loanApplications', 'kins', 'gurantors'));
    }

    public function disableUser($id)
    {
        abort_if(Gate::denies('user_disable'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $user = User::find($id);
        $status = $user->status;

            if($status == 1){

                    $user->update(['status' => 0]);
                
                    return back()->with('success', 'User has been disabled');   

            } else {
                    
                    $user->update(['status' => 1]);

                    //send an email if the account was recently created to the user with the email and password details
                    $email = $this->sendEmailDetailsToMember($id);
                    
                    if($email){

                        return back()->with('success', 'User has been Re-enable');

                    }
                    
                    return back()->with('error', 'Sorry could not Re-enable user');

                
            }

    }

    public function getUser()
    {

        abort_if(Gate::denies('view_self_user'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $user = User::findorFail(\Auth::user()->id);
        $currentLoanAmount = LoanApplication::where('created_by_id', $user->id)->where('status_id', '=', '8')->where('repaid_status', 0)->sum('loan_amount');
        $totalmonthlysavings = MonthlySavings::where('user_id', $user->id)->sum('total_contributed');
        $loanApplications = LoanApplication::with('status', 'accountant', 'creditCommittee')->where('created_by_id', $user->id)->get();
        $kins = NextKin::where('user_id', $user->id)->get();

        return view('admin.users.usershow', compact('user', 'currentLoanAmount', 'totalmonthlysavings', 'loanApplications', 'kins'));
    }

    public function createPdf($id) //prepares pdf files for donwloading monthly contribution and loan statements
    {

        //$loanApplication = LoanApplication::where('loan_entry_number', 393964)->with('logs')->first();
        $userLogs = AuditLogService::generateLoanStatementLogs();

        //dd($userLogs);

        $user = User::find(\Auth::user()->id);

        $pdfDetails = [
            'saccoName' => env('APP_NAME'),
            'saccoAddress' => 'P.O BOX 303456-00100',
            'saccoEmail' => 'Mtangazajisacco@gmail.com',
            'saccoTel' => '0726616120',
            'memberName' => $user->name,
            'memberPhone' => $user->number,
            'memberIdno' => $user->nationalid,
            'memberEmail' => $user->email,
            'memberNo' => $user->idno,
            'saccoUrl' => env('APP_URL'),
            'printedOn' => Carbon::now()->toFormattedDateString()
        ];

        if($id == 'monthly'){

            $type = 'monthly';

            $monthlystatement = MonthlySavings::where('user_id', $user->id)->first();
            $loanstatements = null;
      
            // download PDF file with download method
            if(!empty($monthlystatement)){
    
                $userLogs = AuditLogService::generateMonthlyStatementLogs();

                if(count($userLogs) < 1){
                    
                    return back()->with('error', 'No values to prepare Statement of Account');
                    
                }

                $pdf = PDF::loadView('admin.pdf.monthlypdf', compact('userLogs', 'pdfDetails'));//,compact('type', 'user', 'loanstatements', 'monthlystatement'))->setPaper('a4', 'landscape');
    
                return $pdf->stream($id.'_statement.pdf');
            }
    
            return back()->with('error', 'No values to prepare Statement of Account');

        } else if($id == 'loan'){

            $type = 'loan';

            $loanstatements = LoanApplication::where('created_by_id', $user->id)->whereIn('status_id', [8, 10])->with('status')->get();
      
            // download PDF file with download method
            if(count($loanstatements) >= 1 ){
    
                $userLogs = AuditLogService::generateLoanStatementLogs();
                $pdf = PDF::loadView('admin.pdf.loanpdf',compact('userLogs', 'pdfDetails'));
    
                return $pdf->stream($id.'_statement.pdf');
            }
    
            return back()->with('error', 'No values to prepare Statement of Account');

        }

    }

    public function memberStatements()
    {
        $gurantors = LoanGuarantor::where('user_id', \Auth::user()->id)->get();

        return view('admin.users.userstatements', compact('gurantors'));
    }

    public function memberLoans()
    {
        $loanApplications = LoanApplication::with('status', 'accountant', 'creditCommittee')->where('created_by_id', \Auth::user()->id)->get();

        return view('admin.users.userloans', compact('loanApplications'));
    }

    public function memberForms()
    {
        $files = SaccoFile::get();

        return view('admin.users.userforms', compact('files'));
    }

    public function download($uuid)
    {
        
        $book = SaccoFIle::where('uuid', $uuid)->firstOrFail();
        $pathToFile = storage_path('app/files/' . $book->cover);
        return response()->download($pathToFile);
    }

    public function destroy(User $user)
    {
        abort_if(Gate::denies('user_delete'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $user->delete();

        return back()->with('success', 'User was deleted successfully');;

    }

    public function massDestroy(MassDestroyUserRequest $request)
    {
        abort_if(Gate::denies('user_delete'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        User::whereIn('id', request('ids'))->delete();

        return response(null, Response::HTTP_NO_CONTENT);
    }

    protected function updateMonthlyContribution(Request $request)
    {
        //ajax request to update database on users monthly contribution
        abort_if(Gate::denies('update_monthly_contribution'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        //handle logic to update monthly amount

        $account = MonthlySavings::where('user_id', $request->user_id)->with('user')->first();

        if(empty($account->modified_at)){

            $amountToAdd = $request->amount;

            $account->update(['total_contributed' => $account->total_contributed + $amountToAdd]);
            $account->update(['modified_at' => Carbon::now()->toDateTimeString()]);

            return response()->json(array('response' => true, 'message' => 'Success '.$account->user->firstname.' was credited '.$request->amount.' for this month'), 200);

        }else if(date('m',strtotime($account->modified_at )) == date('m')){

            return response()->json(array('response' => false, 'failure' => 'Sorry cannot credit '.$account->user->firstname.' He was already credited'), 200);

        }

        $amountToAdd = $request->amount;
        $account->update(['total_contributed' => $account->total_contributed + $amountToAdd]);
        $account->update(['modified_at' => Carbon::now()->toDateTimeString()]);

        return response()->json(array('response' => true, 'message' => 'Success '.$account->user->firstname.' was credited '.$request->amount.' for this month'), 200);

    }

    protected function updateMonthlyContributionAmount(Request $request)
    {
        abort_if(Gate::denies('update_monthly_contribution_amount'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        //this request should be made pending

        $account = MonthlySavings::where('user_id', $request->user_id)->with('user')->first();

        $account->update(['monthly_amount' => $request->amount]);

        return response()->json(array('response' => true, 'message' => 'Success Amount Updated '), 200);
    }

    public function uploadOne(UploadedFile $file, $folder = null, $disk = 'public', $filename = null)
    {
        $name = !is_null($filename) ? $filename : Str::random(25);

        return $file->storeAs($folder, $name . "." . $file->getClientOriginalExtension(), $disk );
    }

    public function sendEmailDetailsToMember($id)
    {
            $user = User::findOrFail($id);

            $characters = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
            $randomString = '';
          
            for ($i = 0; $i < 8; $i++) {
                $index = rand(0, strlen($characters) - 1);
                $randomString .= $characters[$index];
            }
          
            $pass = Hash::make($randomString);
            $user->update(['password'=> $pass]);

            $data = [
                'name' => $user->name,
                'subject' => "Account Credentials",
                'email' => $user->email,
                'password' => $randomString,
                'content' => "Please use the email ".$user->email." and password ".$randomString." to log into your account",
              ];
      
            Mail::send('emails.emaildetails', $data, function($message) use ($data) {
                $message->to($data['email'])
                ->subject($data['subject']);
              });

            return true;
    }

}
