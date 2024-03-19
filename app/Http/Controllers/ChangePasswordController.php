<?php

namespace App\Http\Controllers;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Session;

class ChangePasswordController extends Controller
{
    public function __construct(Request $request){
        $this->middleware('auth');
    }

    public function index(){
        $data['title'] = 'Change Password';
        return view('my-account.change-password', $data);
    }

    public function update(Request $request){
        $request->validate([
            'current_password' => 'required',
            'password' => 'required|confirmed',
        ]);
    
        $user_data = Auth::user();
        $current_password = $user_data->password;
    
        if ($request->current_password == $request->password) {
            \Session::flash('danger', 'There cannot be a similarity between your current password and your new password.');
        } elseif (Hash::check($request->current_password, $current_password)) {
            $user_data->password = Hash::make($request->password);
            $user_data->save();
            \Session::flash('success', 'You have successfully changed your password.');
        } else {
            \Session::flash('danger', 'The password you are currently using is incorrect.');
        }
    
        return redirect()->route('change.password');
    }
}
