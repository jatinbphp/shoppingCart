<?php

namespace App\Http\Controllers\Admin;

use App\Models\Setting;
use App\Models\Category;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Requests\SettingsRequest;
use Illuminate\Support\Facades\Session;

class SettingController extends Controller{
  
    public function edit(string $id){
        $data['menu'] = 'Settings';
        $data['settings'] = Setting::find($id);
        $data['categories'] = Category::where('status', 'active')->orderBy('name', 'ASC')->pluck('name','id');   
        return view('admin.setting.edit',$data);
    }

    public function update(SettingsRequest $request, string $id){
        $input = $request->all();
        $input['header_menu'] = !empty($request->header_menu) ? implode(',', $request->header_menu) : '';
        $input['footer_menu'] = !empty($request->footer_menu) ? implode(',', $request->footer_menu) : '';        
        $setting = Setting::find($id);
        $setting->updateOrCreate(['id' => $id], $input);
        Session::flash('success','Settings has been updated successfully!');
        return redirect('admin/settings/'.$id."/edit");
    }
}
