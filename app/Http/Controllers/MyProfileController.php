<?php

namespace App\Http\Controllers;
use App\Models\User;
use App\Models\Category;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Session;
use App\Http\Requests\UserProfileUpdateRequest;

class MyProfileController extends Controller
{
    public function __construct(Request $request){
        $this->middleware('auth');
    }

    public function index(){   
        $data['title'] = 'Profile Information';        
        $data['user_info']= Auth::user();
        $data['categories'] = Category::where('status', 'active')->where('parent_category_id', 0)->orderBy('full_name', 'ASC')->pluck('full_name', 'id');
        return view('my-account.profile-info', $data);
    }

    public function update(Request $request){
        $user = User::find(Auth::user()->id);
        $request->validate([
            'name' => 'required',
            'email' => 'required|email|unique:users,email,'.$user->id.',id',
            'image' => 'nullable|mimes:jpeg,jpg,png,bmp', // Allow null or valid image files
            'phone' => 'required',
        ]);
        $input = $request->all();

        //category
        if (!empty($input['categories_id'])) {
            $input['categories_id'] = implode(",", $input['categories_id']);
        } else{
            $input['categories_id'] = NULL;
        }

        //image
        if ($request->hasFile('image')) {
            if (!empty($user->image) && file_exists(public_path($user->image))) {
                unlink(public_path($user->image));
            }
            $image = $request->file('image');
            $imageName = time().'.'.$image->extension(); 
            $image->move(public_path('uploads/users/'), $imageName); 
            $input['image'] = 'uploads/users/'.$imageName;
        }
        $user->update($input);

        \Session::flash('success', 'Your profile has been successfully updated.');
        return redirect()->back();
    }
}
