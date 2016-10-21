<?php

namespace App\Http\Middleware;

use Closure;

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class CheckUser
{
    public function handle($request, Closure $next)
    {
        
        if(!empty(auth()->guard('user')->id()))
        {
            $data = DB::table('users')
                    ->select('users.id')
                    ->where('users.id',auth()->guard('user')->id())
                    ->get();
            
            if (!$data[0]->id  )
            {
                return redirect()->intended('user/login/')->with('status', 'You do not have access to user admin side');
            }
            return $next($request);
        }
        else 
        {
            return redirect()->intended('user/login/')->with('status', 'Please Login to access user admin area');
        }
    }
}
