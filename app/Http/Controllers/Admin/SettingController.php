<?php

namespace App\Http\Controllers\Admin;

use App\Models\Setting;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Requests\SettingsRequest;
use Illuminate\Support\Facades\Session;

class SettingController extends Controller{
  
    public function edit(string $id){
        $data['menu'] = 'Settings';
        $data['settings'] = Setting::find($id);     
        return view('admin.setting.edit',$data);
    }

    public function update(SettingsRequest $request, string $id){
        $input      = $request->all();
        $setting    = Setting::find($id);
        $setting->updateOrCreate(['id' => $id], $input);
        Session::flash('success','Settings has been updated successfully!');
        return redirect('admin/settings/'.$id."/edit");
    }
}
