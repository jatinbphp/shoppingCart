<?php

namespace App\Http\Controllers;
use App\Models\User;
use App\Models\Category;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Session;
use App\Http\Requests\UserProfileUpdateRequest;

class MyAccountController extends Controller
{
    public function __construct(Request $request){
        $this->middleware('auth');
    }

    public function profileInfo(){   
        $data['title'] = 'Profile Information';        
        $data['user_info']= Auth::user();
        $data['categories'] = Category::where('status', 'active')->where('parent_category_id', 0)->orderBy('full_name', 'ASC')->pluck('full_name', 'id');
        return view('my-account.profile-info', $data);
    }

    public function userProfileUpdate(Request $request)
    {
        $user = User::find(Auth::user()->id);
        $request->validate([
            'name' => 'required',
            'email' => 'required|email|unique:users,email,'.$user->id.',id',
            'image' => 'nullable|mimes:jpeg,jpg,png,bmp', // Allow null or valid image files
            'password' => 'nullable|confirmed',
        ]);

        $input = $request->except('password', 'password_confirmation');
        if ($request->hasFile('image')) {
            if (!empty($user->image) && file_exists(public_path($user->image))) {
                unlink(public_path($user->image));
            }
            $image = $request->file('image');
            $imageName = time().'.'.$image->extension(); 
            $image->move(public_path('uploads/users/'), $imageName); 
            $input['image'] = 'uploads/users/'.$imageName;
        }

        if ($request->filled('password')) {
            $input['password'] = Hash::make($request->password);
        } else {
            unset($input['password']);
        }

        if (!empty($input['categories_id'])) {
            $input['categories_id'] = implode(",", $input['categories_id']);
        }
        $user->update($input);

        \Session::flash('success', 'Profile has been updated successfully!');
        return redirect()->back();
    }

    public function changePassword()
    {
        $data['title'] = 'change-password';
        return view('my-account.change-password', $data);
    }

    public function passwordUpdate(Request $request)
    {
        $request->validate([
            'current_password' => 'required',
            'password' => 'required|confirmed',
        ]);
    
        $user_data = Auth::user();
        $current_password = $user_data->password;
    
        if ($request->current_password == $request->password) {
            \Session::flash('danger', 'Current password and new password cannot be the same.');
        } elseif (Hash::check($request->current_password, $current_password)) {
            $user_data->password = Hash::make($request->password);
            $user_data->save();
            \Session::flash('success', 'Password changed successfully.');
        } else {
            \Session::flash('danger', 'Current password is incorrect.');
        }
    
        return redirect()->route('change.password');
    }
    
}
