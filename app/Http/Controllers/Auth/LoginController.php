<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Providers\RouteServiceProvider;
use Illuminate\Foundation\Auth\AuthenticatesUsers;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use Illuminate\Validation\ValidationException;

class LoginController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Login Controller
    |--------------------------------------------------------------------------
    |
    | This controller handles authenticating users for the application and
    | redirecting them to your home screen. The controller uses a trait
    | to conveniently provide its functionality to your applications.
    |
    */

    use AuthenticatesUsers;

    /**
     * Where to redirect users after login.
     *
     * @var string
     */
    protected $redirectTo = RouteServiceProvider::HOME;

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('guest')->except('logout');
    }

    public function authenticate(Request $request)
    {
        $credentials = $request->validate([
            'email' => ['required', 'email'],
            'password' => ['required'],
            'idno' => ['required'],
        ]);

        if (Auth::attempt(['email' => $request->email, 'password' => $request->password, 'idno' => $request->idno])) {
            $request->session()->regenerate();

            return redirect()->intended('dashboard');
        }

        return back()->withErrors([
            'email' => 'The provided credentials do not match our records.',
        ]);
    }

    public function login(Request $request)
    {
        //dd($request->all());
        if ($this->guard()->validate($this->credentials($request))) {
            //IF USER EXISTS, FIND USER USING EMAIL FROM REQUEST
            $user = \App\User::where('email', $request->email)->first();
            //CHECK STATUS OF USER (HERE, 1 = ACTIVE & 0 = INACTIVE)
            if ($user->status === 0) {
                //THROW ERROR WITH CUSTOM MESSAGE
                throw ValidationException::withMessages([$this->username() => __('User account has been deactivated. Please Contact the Administrator.')]);
            }
        }

        if (Auth::attempt(['email' => $request->email, 'password' => $request->password, 'idno' => $request->idno]))
        {
            // Updated this line
            return $this->sendLoginResponse($request);

            // OR this one
            // return $this->authenticated($request, auth()->user());
        }
        else
        {
            return $this->sendFailedLoginResponse($request, 'auth.failed_status');
        }
    }
}
