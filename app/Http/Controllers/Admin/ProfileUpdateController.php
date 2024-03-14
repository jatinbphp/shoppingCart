<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Admin;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class ProfileUpdateController extends Controller
{
    public function __construct(){
        $this->middleware('auth');
    }

    public function index()
    {
        //
    }

    public function create()
    {
        //
    }

    public function store(Request $request)
    {
        //
    }

    public function show($id)
    {
        //
    }

    public function edit($id)
    {
        $data['menu']="Edit Profile";
        $data['user'] = Admin::findorFail($id);
        return view('admin.user.profile_edit',$data);
    }

    public function update(Request $request, $id)
    {
        $this->validate($request, [
            'name' => 'required',
            'email' => 'required|email|unique:users,email,'.$id.',id',
            'image' => 'mimes:jpeg,jpg,png,bmp',
            'password' => 'confirmed',
        ]);

        if(empty($request['password'])){
            unset($request['password']);
        }

        $input = $request->all();
        $input['password']= Hash::make($request->password);
        $admin = Admin::findorFail($id);
        if($file = $request->file('image')){
            if (!empty($admin['image'])) {
                unlink($admin['image']);
            }
            $input['image'] = $this->fileMove($file,'admin');
        }
        $admin->update($input);
        \Session::flash('success','Profile has been updated successfully!');
        return redirect('admin/profile_update/'.$id."/edit");
    }

    public function destroy($id)
    {
        //
    }
}
