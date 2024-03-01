<?php

namespace App\Http\Controllers\Admin;

use App\Models\Banner;
use Illuminate\Http\Request;
use Yajra\DataTables\DataTables;
use App\Http\Controllers\Controller;
use App\Http\Requests\BannerRequest;
use Illuminate\Support\Facades\Session;

class BannerController extends Controller{
    public function index(Request $request){
        $data['menu'] = 'Banners';

        if ($request->ajax()) {
            return Datatables::of(Banner::all())
                ->addIndexColumn()
                ->editColumn('created_at', function($row){
                    return $row['created_at']->format('Y-m-d h:i:s');
                })
                ->editColumn('status', function($row){
                    $row['table_name'] = 'categories';
                    return view('admin.common.status-buttons', $row);
                })
                ->addColumn('action', function($row){
                    $row['section_name'] = 'banner';
                    $row['section_title'] = 'Banner';
                    return view('admin.common.action-buttons', $row);
                })
                ->make(true);
        }

        return view('admin.banner.index', $data);
    }

    public function create(){
        $data['menu'] = 'Banners';
        return view("admin.banner.create",$data);
    }
    
    public function store(BannerRequest $request){
        $input = $request->all();
        $input['image'] = $request->has('image') ? $this->fileMove($request->file('image'),'banner') : null;
        Banner::create($input);
        Session::flash('success', 'Banner has been inserted successfully!');
        return redirect()->route('banner.index');
    }

    

    public function edit(string $id){
        $data['menu'] = 'Banners';
        $data['banner'] = Banner::where('id',$id)->first();        
        return view('admin.banner.edit',$data);
    }

    public function update(BannerRequest $request, string $id){
        $input = $request->all();
        $banner = Banner::findorFail($id);

        if($file = $request->file('image')){
            if (!empty($banner['image']) && file_exists($banner['image'])) {
                unlink($banner['image']);
            }
            $input['image'] = $this->fileMove($file,'banner');
        }
 
        $banner->update($input);

        Session::flash('success','Banner has been updated successfully!');
        return redirect()->route('banner.index');
    }

    public function destroy(string $id){
        $banner = Banner::findOrFail($id);
        if(!empty($banner)){
            if (!empty($banner['image']) && file_exists($banner['image'])) {
                unlink($banner['image']);
            }
            $banner->delete();
            return 1;
        }else{
            return 0;
        }
    }
}
