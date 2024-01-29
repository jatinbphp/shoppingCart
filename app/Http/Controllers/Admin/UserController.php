<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use DataTables;
use App\Models\User;


class UserController extends Controller
{
    public function index(Request $request)
    {
        $data['menu'] = 'Users';
        if ($request->ajax()) {

            $user = User::all()->where('role', 'user');
            return Datatables::of($user)
                ->addIndexColumn()
                ->make(true);
        }

        return view('admin.user.index', $data);
    }

    public function create()
    {
        $data['menu'] = 'Users';
        return view("admin.user.create",$data);
    }

    public function store(Request $request)
    {
        $this->validate($request, [
            'name' => 'required',
            'email' => 'required|email|unique:users',
            'password' => 'confirmed|min:6',
            'phone' =>'required|numeric',
            'image' => 'required|mimes:jpeg,jpg,png,bmp',
            'status' => 'required',
        ]);

        $input = $request->all();
        $input['role'] = 'user';

        if($file = $request->file('image')){
            $input['image'] = $this->fileMove($file,'users');
        }

        User::create($input);

        \Session::flash('success', 'User has been inserted successfully!');
        return redirect()->route('users.index');
    }

    public function show($id)
    {
        //
    }

    public function edit($id)
    {
        $data['menu'] = "User";
        $data['users'] = User::where('id',$id)->first();
        return view('admin.user.edit',$data);
    }

    public function update(Request $request, $id)
    {
        $this->validate($request, [
            'name' => 'required',
            'email' => 'required|email|unique:users,email,'.$id.',id',
            'password' => 'nullable|confirmed|min:6',
            'phone' =>'required|numeric',
            'image' => 'mimes:jpeg,jpg,png,bmp',
            'status' => 'required',
        ]);

        if(empty($request['password'])){
            unset($request['password']);
        }

        $input = $request->all();

        $user = User::findorFail($id);

        if($file = $request->file('image')){
            if (!empty($user['image'])) {
                unlink($user['image']);
            }
            $input['image'] = $this->fileMove($file,'users');
        }

        $user->update($input);

        \Session::flash('success','User has been updated successfully!');
        return redirect()->route('users.index');
    }

    public function destroy($id)
    {
        $users = User::findOrFail($id);
        if(!empty($users)){
            if (!empty($users['image']) && file_exists($users['image'])) {
                unlink($users['image']);
            }
            $users->delete();
            return 1;
        }else{
            return 0;
        }
    }

    public function assign(Request $request){
        $customer = User::findorFail($request['id']);
        $customer['status'] = "active";
        $customer->update($request->all());
    }

    public function unassign(Request $request){
        $customer = User::findorFail($request['id']);
        $customer['status'] = "inactive";
        $customer->update($request->all());
    }
}
