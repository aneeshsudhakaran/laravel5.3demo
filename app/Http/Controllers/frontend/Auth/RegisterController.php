<?php

namespace App\Http\Controllers\frontend\Auth;

use App\Model\frontend\User;
use Illuminate\Http\Request;

use Validator;
use App\Http\Controllers\Controller;
use Illuminate\Foundation\Auth\RegistersUsers;
use Illuminate\Support\Facades\Input;
use Illuminate\Support\Facades\Session;

class RegisterController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Register Controller
    |--------------------------------------------------------------------------
    |
    | This controller handles the registration of new users as well as their
    | validation and creation. By default this controller uses a trait to
    | provide this functionality without requiring any additional code.
    |
    */

    use RegistersUsers;

    /**
     * Where to redirect users after login / registration.
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
        $this->middleware('guest');
    }

    public function getRegisterForm()
    {
        return view('frontend/auth/register');
    }	
    
    /**
     * Create a new user instance after a valid registration.
     *
     * @param  request  $request
     * @return User
     */
    protected function saveRegisterForm(Request $request)
    {
        $messages = array(
            'name.required' => 'Please enter name',
            'email.required' => 'Please enter email',
            'email.unique' => 'This email is already taken. Please input a another email',
            'password.required' => 'Please enter password',
        );

        $rules = array(
            'name' => 'required|max:255',
            'email' => 'required|email|max:255|unique:users',
            'password' => 'required|min:6|confirmed',
        );
        
        $validator = Validator::make(Input::all(), $rules, $messages);
        if ($validator->fails()) {
            return redirect('user/register')
                            ->withErrors($validator)
                            ->withInput();
        }
        
        $input = $request->all();
        $user = User::registeruser($input); 
        
        if($user->id){
            return redirect('user/login')->with('status', 'User register successfully');
        }else{
            return redirect('user/register')->with('status', 'User not register. Please try again');
        }
        
    }
}
