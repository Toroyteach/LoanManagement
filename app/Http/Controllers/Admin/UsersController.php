<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\MassDestroyUserRequest;
use App\Http\Requests\StoreUserRequest;
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
    }

    public function create()
    {
        abort_if(Gate::denies('user_create'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $roles = Role::all()->pluck('title', 'id');

        return view('admin.users.create', compact('roles'));
    }

    public function store(StoreUserRequest $request, StoreUserAction $action)
    {
        //dd($request->validated());
        
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
        //$user->firebaseid = $uid;
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
        //dd('arrived');


        $filename = time() . '_' . $request->file('file')->getClientOriginalName();

        $imageUpload = User::find(\Auth::user()->id);

        $request->file('file')->storeAs('profileavatar', $filename, 'uploads');
        
        $imageUpload->avatar = $filename;

        $imageUpload->save();

        return response()->json(['success'=>$imageName]);

    }

    public function updateUserProfile(UpdateUserProfileRequest $request, User $user)
    {
        //dd($request->validated());
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
        $currentLoanAmount = LoanApplication::where('created_by_id', $user->id)->where('repaid_status', 0)->first();
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

        //if(!empty($user->firebaseid)){

            if($status == 1){

                //$firebaseDisable = $service->disableUser($user->firebaseid);

                //if( $firebaseDisable){

                    $user->update(['status' => 0]);
                
                    return back()->with('success', 'User has been disabled');   
                //}

                //return back()->with('error', 'Sorry could not Disable this user');   

            } else {

                //$firebaseEnable = $service->enableUser($user->firebaseid);

                //if( $firebaseEnable){
                    
                    $user->update(['status' => 1]);

                    //send an email if the account was recently created to the user with the email and password details
                    $email = $this->sendEmailDetailsToMember($id);
                    
                    if($email){

                        return back()->with('success', 'User has been Re-enable');

                    }
                    
                    return back()->with('error', 'Sorry could not Re-enable user');
                //}

                
            }

        //}

        //return back()->with('error', 'Sorry Can not Disable this user');

    }

    public function getUser()
    {

        abort_if(Gate::denies('view_self_user'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $user = User::findorFail(\Auth::user()->id);
        $currentLoanAmount = LoanApplication::where('created_by_id', $user->id)->where('status_id', '=', '8')->where('repaid_status', 0)->sum('loan_amount');
        $totalmonthlysavings = MonthlySavings::where('user_id', $user->id)->sum('total_contributed');
        $loanApplications = LoanApplication::with('status', 'accountant', 'creditCommittee')->where('created_by_id', $user->id)->get();
        $kins = NextKin::where('user_id', $user->id)->get();


        //$files = SaccoFile::get();

        //dd($currentLoanAmount);

        return view('admin.users.usershow', compact('user', 'currentLoanAmount', 'totalmonthlysavings', 'loanApplications', 'kins'));
    }

    public function createPdf($id)
    {

        $user = \Auth::user();

        if($id == 'monthly'){

            $type = 'monthly';

        } else if($id == 'loan'){

            $type = 'loan';

        }

        // share data to view
        $loanstatements = LoanApplication::where('created_by_id', $user->id)->with('status')->get();
        $monthlystatement = MonthlySavings::where('user_id', $user->id)->first();
        //dd($loanstatements);
        //dd($loanstatements, $monthlystatement, $user);
  
        // download PDF file with download method
        if($user and ($monthlystatement or $loanstatements)){

            //view()->share('employee',$data);
            $pdf = PDF::loadView('admin.pdf.pdf_view',compact('type', 'user', 'loanstatements', 'monthlystatement'))->setPaper('a4', 'landscape');

            return $pdf->stream($id.'_statement.pdf');
        }

        return back()->with('error', 'No values to prepare Statement of Account');
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

        // if(!$user->firebaseid){
        //     return redirect()->back()->with('error','Failed to Delete user Firebase details missing');
        // }

        //$updatedUser = $service->deleteUser($user->firebaseid);

        //if($updatedUser){

            $user->delete();
            return back()->with('success', 'User was deleted successfully');;

        //}


        //return back()->with('error', 'sorry could not delete this user');
    }

    public function massDestroy(MassDestroyUserRequest $request)
    {
        abort_if(Gate::denies('user_delete'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        User::whereIn('id', request('ids'))->delete();

        return response(null, Response::HTTP_NO_CONTENT);
    }

    public function createUser($user)
    {
        // $auth = app('firebase.auth');
        // $auth->createUser($user);
        // return $auth;
    }

    protected function checkUserDetails($params)
    {

        // $auth = app('firebase.auth');

        // try {

        //     $user = $auth->getUserByPhoneNumber('+'.$params);

        // } catch (\Kreait\Firebase\Exception\Auth\UserNotFound $e) {

        //     //echo $e->getMessage();
        //     return true;

        // }

    }

    protected function updateMonthlyContribution(Request $request)
    {
        //ajax request to update database on users monthly contribution
        //dd($request->all());
        abort_if(Gate::denies('update_monthly_contribution'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        //handle logic to update monthly amount

        $account = MonthlySavings::where('user_id', $request->user_id)->with('user')->first();

        if(empty($account->modified_at)){
            //dd('update first time');
            $amountToAdd = $request->amount;

            $account->update(['total_contributed' => $account->total_contributed + $amountToAdd]);
            $account->update(['modified_at' => Carbon::now()->toDateTimeString()]);

            return response()->json(array('response' => true, 'message' => 'Success '.$account->user->firstname.' was credited '.$request->amount.' for this month'), 200);

        }else if(date('m',strtotime($account->modified_at )) == date('m')){

            return response()->json(array('response' => false, 'failure' => 'Sorry cannot credit '.$account->user->firstname.' He was already credited'), 200);

        }
        //dd('credited');
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
        //dd($file, $folder, $disk, $filename, $name);

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
