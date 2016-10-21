<?php

namespace App\Http\Controllers\frontend\Auth;
use App\Model\frontend\User;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Foundation\Auth\AuthenticatesUsers;

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
    protected $redirectTo = '/home';

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('guest', ['except' => 'logout']);
    }
    
    public function getLoginForm()
    {
        return view('frontend/auth/login');
    }	
    
    public function authenticate(Request $request)
    {
        
        $email = $request->input('email');
        $password = $request->input('password');
         
        if (auth()->guard('user')->attempt(['email' => $email, 'password' => $password ])) 
        {
            
            return redirect()->intended('user/dashboard');
        }
        else
        {
            return redirect()->intended('user/login')->with('status', 'Invalid Login Credentials !');
        }
    }
    
    
    public function getLogout() 
    {
        auth()->guard('user')->logout();
        return redirect()->intended('user/login');
    }
    
}
