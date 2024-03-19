<?php

namespace App\Http\Controllers;
use App\Models\User;
use App\Models\UserAddresses;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Session;
use App\Http\Requests\UserAddressesRequest;

class AddressController extends Controller
{
    public function __construct(Request $request){
        $this->middleware('auth');
    }

    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $data['title'] = 'My Addresses';
        $data['addresses'] = UserAddresses::where('user_id', Auth::user()->id)->get();
        return view('my-addresses.index', $data);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $data['title'] = 'Add Address';
        return view('my-addresses.create', $data);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(UserAddressesRequest $request)
    {
        $input = $request->all();
        $input['user_id'] = Auth::user()->id;
        UserAddresses::create($input);

        \Session::flash('success', 'Address has been inserted successfully!');
        return redirect()->route('addresses.index');
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit($id)
    {
        $data['title'] = 'Edit Address';
        $data['address'] = UserAddresses::where('id', $id)->where('user_id', Auth::user()->id)->firstOrFail();
        return view('my-addresses.edit', $data);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UserAddressesRequest $request, string $id)
    {
        $input = $request->all();
        $address = UserAddresses::findorFail($id);
        $address->update($input);

        \Session::flash('success','Address has been updated successfully!');
        return redirect()->route('addresses.index');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $address = UserAddresses::findOrFail($id);
        if(!empty($address)){
            $address->delete();
            return 1;
        }else{
            return 0;
        }
    }
}
