<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AuthorizationController extends Controller
{
    public function adminLoginForm()
    {
        return view('admin.auth.admin_login', ['url' => route('admin.login'), 'title' => 'Admin']);
    }

    public function adminLogin(Request $request)
    {
        $request->validate([
            'email' => 'required|email',
            'password' => 'required',
        ]);
        if (Auth::guard('admin')->attempt(['email' => $request->email, 'password' => $request->password])) {
                return redirect()->route('admin.dashboard');
        } else {
            \Session::flash('danger', 'Invalid Credentials!');
            return redirect()->route('admin.login');
        }
    }

    public function adminLogout()
    {
        Auth::guard('admin')->logout(); 
        return redirect('admin');
    }
    
    public function showProfile()
    {
       $admin = Auth::guard('admin')->user()->name; // Retrieve authenticated admin data
        //  return $admin->name;
         return view('admin.layouts.app', ['admin' => $admin]);
    }


}
