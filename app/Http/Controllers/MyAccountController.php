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
}
