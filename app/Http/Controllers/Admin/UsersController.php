<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\MassDestroyUserRequest;
use App\Http\Requests\StoreUserRequest;
use App\Http\Requests\UpdateUserRequest;
use App\Role;
use App\User;
use App\UsersAccount;
use App\Services\AuditLogService;
use Gate;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;
use Kreait\Firebase\Auth;
use Image;
use Illuminate\Support\Str;
use App\SaccoFile;
use App\LoanApplication;
use App\Traits\UploadAble;
use App\NextKin;

class UsersController extends Controller
{
    // protected $auth;
    use uploadAble;

    // public function __construct(Auth $auth)
    // {
    //     $this->auth = $auth;
    // }

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

    public function store(StoreUserRequest $request)
    {
        $this->validate(request(), [
            'number' => 
                array(
                    'required',
                    'regex:/(254)[0-9]{9}/'
                )
        ]);
        //dd($request->all());
        //created users account table as well

        if(!$this->checkUserDetails($request->number)){
            return redirect()->back()->with('error','Failed to create user Firebase details conflict');
        }

        //get next of kin information


        $user = User::create($request->all());
        UsersAccount::create([
            'total_amount' => $request->amount,
            'user_id' => $user->id,
        ]);

        $nextKin = [
            'name' => $request->kinname,
            'phone' => $request->kinphone,
            'relationship' => $request->kinrelationship,
            'user_id' => $user->id,
        ];

        NextKin::create($nextKin);

        $uid = Str::random(20);

        $user->name = $request->firstname.' '.$request->lastname;
        $user->firebaseid = $uid;
        $user->save();
        $user->roles()->sync($request->input('roles', []));

            	// Handle the user upload of avatar
    	if($request->hasFile('avatar')){
            
    		$avatar = $request->file('avatar');
    		$filename = time() . '.' . $avatar->getClientOriginalExtension();
    		//Image::make($avatar)->resize(300, 300)->save( public_path('/uploads/avatars/' . $filename ) );
        
            $avatar->move(public_path('images'), $filename);

    		$user->avatar = $filename;
    		$user->save();
    	}
        
        //dd('user created');
        //create base64 username/email and password 

        //create fiorebase calls to insert to firebase
        $userProperties = [
            'email' => $user->email,
            'emailVerified' => false,
            'phoneNumber' => '+'.$request->number,
            'password' => $request->password,
            'displayName' => $user->firstname.' '.$user->lastname,
            'photoUrl' => '',
            'disabled' => false,
            'uid' => $uid,
        ];
        //check if you can add extra field idno. you cant

        //dd($userProperties);

        $newUser = $this->createUser($userProperties);

        if(!$newUser){
            //dd('error creating new user');
        } else {
            return redirect()->route('admin.users.index')->with('message','User created successfully!');

        }

        // return redirect()->route('admin.users.index');
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
        //update firebase data

        return redirect()->route('admin.users.index')->with('message','User updated successfully!');
    }

    public function show(User $user)
    {
        abort_if(Gate::denies('user_show'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $user->load('roles');
        $currentLoanAmount = LoanApplication::where('created_by_id', $user->id)->where('repaid_status', 0)->first();
        $userAccount = UsersAccount::where('user_id', $user->id)->first();
        //$logs        = AuditLogService::generateLogs($userAccount);

        return view('admin.users.show', compact('user', 'currentLoanAmount'));
    }

    public function getUser()
    {
        abort_if(Gate::denies('view_self_user'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $user = User::findorFail(\Auth::user()->id);
        $currentLoanAmount = LoanApplication::where('created_by_id', $user->id)->where('repaid_status', 0)->first();


        $files = SaccoFile::get();

        //dd($currentLoanAmount);

        return view('admin.users.usershow', compact('user', 'files', 'currentLoanAmount'));
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

        if(!$user->firebaseid){
            return redirect()->back()->with('error','Failed to Delete user Firebase details missing');
        }

        $auth = app('firebase.auth');
        $auth->deleteUser($user->firebaseid);
        $user->delete();

        //call firebase method to remove user from firestore

        return back();
    }

    public function massDestroy(MassDestroyUserRequest $request)
    {
        abort_if(Gate::denies('user_delete'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        User::whereIn('id', request('ids'))->delete();

        return response(null, Response::HTTP_NO_CONTENT);
    }

    public function createUser($user)
    {
        $auth = app('firebase.auth');
        $auth->createUser($user);
        return $auth;
    }

    protected function checkUserDetails($params)
    {

        $auth = app('firebase.auth');

        try {

            $user = $auth->getUserByPhoneNumber('+'.$params);

        } catch (\Kreait\Firebase\Exception\Auth\UserNotFound $e) {

            //echo $e->getMessage();
            return true;

        }

    }

    protected function updateMonthlyContribution(Request $request)
    {

        abort_if(Gate::denies('update_monthly_contribution'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        //handle logic to update monthly amount
        $thisMonth = \Carbon\Carbon::now()->format('M');

        $amount = UsersAccount::where('user_id', $request->user_id)->with('user')->first();

        if(date('m',strtotime($amount->user->joinedsacco )) == date('m')){

            return response()->json(array('response' => false, 'failure' => 'Sorry cannot credit '.$amount->user->firstname.' this month He just joined this month'), 200);

        } else if(date('m',strtotime($amount->updated_at )) == date('m')){
                
            return response()->json(array('response' => false, 'failure' => 'Sorry cannot credit '.$amount->user->firstname.' He was already credited'), 200);
        }
        dd('credited');
        $amountToAdd = $request->amount;
        $amount->update(['total_amount' => $amount->total_amount + $amountToAdd]);

        return response()->json(array('response' => true, 'message' => 'Success '.$amount->user->firstname.' was credited '.$request->amount), 200);

    }

}
