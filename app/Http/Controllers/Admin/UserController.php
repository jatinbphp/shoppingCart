<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use DataTables;
use App\Models\User;
use App\Models\UserAddresses;
use App\Models\Category;
use App\Http\Requests\UserRequest;

class UserController extends Controller
{
    public function index(Request $request)
    {
        $data['menu'] = 'Users';

        if ($request->ajax()) {
            $user = User::all()->where('role', 'user');
            return Datatables::of($user)
                ->addIndexColumn()
                ->editColumn('image', function($row){
                    if (!empty($row['image']) && file_exists($row['image'])) {
                        return url($row['image']);
                    } else {
                        return url('assets/admin/dist/img/no-image.png');
                    }
                })
                ->editColumn('created_at', function($row){
                    return $row['created_at']->format('Y-m-d h:i:s');
                })
                ->editColumn('status', function($row){
                    $row['table_name'] = 'users';
                    return view('admin.common.status-buttons', $row);
                })
                ->addColumn('action', function($row){
                    $row['section_name'] = 'users';
                    $row['section_title'] = 'User';
                    return view('admin.common.action-buttons', $row);
                })
                ->make(true);
        }

        return view('admin.user.index', $data);
    }

    public function create()
    {
        $data['menu'] = 'Users';
        $data['user_addresses'] = [];
        $data['categories'] = Category::where('status', 'active')->where('parent_category_id', 0)->orderBy('full_name', 'ASC')->pluck('full_name', 'id');
        return view("admin.user.create",$data);
    }

    public function store(UserRequest $request)
    {
        $input = $request->all();
        $input['role'] = 'user';
        if($file = $request->file('image')){
            $input['image'] = $this->fileMove($file,'users');
        }
        if (!empty($input['categories_id'])) {
            $input['categories_id'] = implode(",", $input['categories_id']);
        }
        $user = User::create($input);

        /*// addresses
        if(!empty($input['addresses'])){
            $this->addUpdateAddresses($input, $user->id);
        }*/

        \Session::flash('success', 'User has been inserted successfully! Please add user addresses.');
        return redirect()->route('users.edit', ['user' => $user->id]);
    }

    public function show($id)
    {
        $user = User::findOrFail($id);
        return view('admin.common.show_modal', [
            'section_info' => $user->toArray(),
            'type' => 'User',
            'required_columns' => ['id', 'image', 'name', 'email', 'role', 'phone', 'status', 'created_at']
        ]);
    }

    public function edit($id)
    {
        $data['menu'] = 'Users';
        $data['users'] = User::findorFail($id);
        $data['user_addresses'] = UserAddresses::where('user_id',$id)->get();
        $data['categories'] = Category::where('status', 'active')->where('parent_category_id', 0)->orderBy('full_name', 'ASC')->pluck('full_name', 'id');
        return view('admin.user.edit',$data);
    }

    public function update(UserRequest $request, $id)
    {
        if(empty($request['password'])){
            unset($request['password']);
        }
        $input = $request->all();
        if (!empty($input['categories_id'])) {
            $input['categories_id'] = implode(",", $input['categories_id']);
        }
        $user = User::findorFail($id);

        if($file = $request->file('image')){
            if (!empty($user['image'])) {
                @unlink($user['image']);
            }
            $input['image'] = $this->fileMove($file,'users');
        }

        $user->update($input);

        // addresses
        if(!empty($input['addresses'])){
            $this->addUpdateAddresses($input, $id);
        }

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

    public function addUpdateAddresses($input, $user_id)
    {
        $address_ids = [];
        if(!empty($input['addresses']['old'])){
            foreach ($input['addresses']['old'] as $key => $value) {
                $addressOld = UserAddresses::where('id',$key)->where('user_id',$user_id)->first();
                $inputAddress = [
                    'user_id' => $user_id,
                ];
                foreach ($value as $innerKey => $innerValue) {
                    $inputAddress[$innerKey] = $innerValue;
                }
                $addressOld->update($inputAddress);
                $address_ids[] = $addressOld->id;
            }

            if(count($address_ids)>0){
                UserAddresses::whereNotIn('id', $address_ids)->where('user_id', $user_id)->delete();
            }
        }
        
        if(!empty($input['addresses']['new'])){
            foreach ($input['addresses']['new'] as $key => $value) {
                $inputAddress = [
                    'user_id' => $user_id,
                ];
                foreach ($value as $innerKey => $innerValue) {
                    $inputAddress[$innerKey] = $innerValue;
                }
                $addressNew = UserAddresses::create($inputAddress);
            }
        }
    }

    public function addAddresses(Request $request){   
        if ($request->ajax()) {
            $data = $request->all();
            return view('admin.user.addresses', $data);
        }
    }
}
