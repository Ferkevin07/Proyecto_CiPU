<?php

namespace App\Http\Controllers;

use Illuminate\Foundation\Auth\Access\Authorizable;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

use App\Models\Manager;

class ManagerAuthController extends Controller
{
    public function check(Request $request)
    {
        //Validate Inputs
        $request->validate([
            'email'=>'required|email|exists:managers,email',
            'password'=>'required|min:5|max:30'
         ],[
             'email.exists'=>'This email is not exists in admins table'
         ]);

         $credentials = $request->only('email','password');
 
        if (Auth::guard('manager')->attempt($credentials)) {

            //$request->session()->regenerate();
 
            return redirect()->route('manager.home');
        }else{
            return redirect()->route('manager.login')->with('fail','incorrect credentials');
        }
 
        /* return back()->withErrors([
            'username' => 'The provided credentials do not match our records.',
        ])->onlyInput('username'); */
    }
}
