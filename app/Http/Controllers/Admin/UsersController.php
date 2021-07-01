<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\MassDestroyUserRequest;
use App\Http\Requests\StoreUserRequest;
use App\Http\Requests\UpdateUserRequest;
use App\Role;
use App\User;
use App\UsersAccount;
use Gate;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;
use Kreait\Firebase\Auth;

class UsersController extends Controller
{
    // protected $auth;

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

        $user = User::create($request->all());
        UsersAccount::create([
            'total_amount' => '0.00',
            'user_id' => $user->id,
        ]);
        $user->name = $request->firstname.' '.$request->lastname;
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
        ];
        //check if you can add extra field idno. you cant

        //dd($userProperties);

        $newUser = $this->createUser($userProperties);

        if(!$newUser){
            dd('error creating new user');
        } else {
            return redirect()->route('admin.users.index');

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

        return redirect()->route('admin.users.index');
    }

    public function show(User $user)
    {
        abort_if(Gate::denies('user_show'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $user->load('roles');

        return view('admin.users.show', compact('user'));
    }

    public function destroy(User $user)
    {
        abort_if(Gate::denies('user_delete'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $user->delete();

        return back();
    }

    public function massDestroy(MassDestroyUserRequest $request)
    {
        User::whereIn('id', request('ids'))->delete();

        return response(null, Response::HTTP_NO_CONTENT);
    }

    public function createUser($user)
    {
        $auth = app('firebase.auth');
        $auth->createUser($user);
        return $auth;
    }
}
