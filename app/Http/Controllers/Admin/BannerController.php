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

        $input['image'] = null;
        if($request->has('image') && !empty($request->file('image'))){
            foreach($request->file('image') as $key => $value){
                $input['image'][$key] = $this->fileMove($request->file('image')[$key],'banner');
            }
        }

        $input['image'] = json_encode($input['image'], JSON_UNESCAPED_SLASHES | JSON_UNESCAPED_UNICODE);
        Banner::create($input);
        Session::flash('success', 'Banner has been inserted successfully!');
        return redirect()->route('banner.index');
    }

    

    public function edit(string $id){
        $data['menu']            = 'Banners';
        $data['banner']          = Banner::where('id',$id)->first();
        $data['banner']['image'] = json_decode($data['banner']['image'], true, JSON_UNESCAPED_SLASHES);
        return view('admin.banner.edit',$data);
    }

    public function update(BannerRequest $request, string $id){
        $input = $request->all();
        $banner = Banner::findorFail($id);

        if(!empty($input["hidden_image"]) && !$request->has('image')){
            $input['image'] = json_encode($input['hidden_image'], JSON_UNESCAPED_SLASHES | JSON_UNESCAPED_UNICODE);
        }
        
        if($request->has('image') && !empty($request->file('image'))){
            foreach($request->file('image') as $key => $value){
                $banners[$key] = $this->fileMove($request->file('image')[$key],'banner');
            }
            $input['image'] = json_encode($banners, JSON_UNESCAPED_SLASHES | JSON_UNESCAPED_UNICODE);
        }

        if(!empty($banners) && !empty($input["hidden_image"]) && is_array($banners) && is_array($input["hidden_image"])){
            $new_banners = array_merge(array_values($banners), array_values($input["hidden_image"]));
            $input['image'] = json_encode($new_banners, JSON_UNESCAPED_SLASHES | JSON_UNESCAPED_UNICODE);
        }

        $banner->update($input);
        Session::flash('success','Banner has been updated successfully!');
        return redirect()->route('banner.index');
    }

    public function destroy(string $id){
        $banner = Banner::findOrFail($id);

        if(empty($banner)){
            return 0;
        }

        if(isset($banner['image']) && !empty($banner['image'])){
            $images = json_decode($banner['image'], true, JSON_UNESCAPED_SLASHES);
            foreach($images as $key => $value){
                if (!empty($value) && file_exists($value)) {
                    unlink($value);
                }
            }
        }

        $banner->delete();
        return 1;
    }
}
