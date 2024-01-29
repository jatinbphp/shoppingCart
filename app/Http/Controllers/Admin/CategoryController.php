<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Category;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Yajra\DataTables\DataTables;

class CategoryController extends Controller
{
    public function index(Request $request)
    {
        $data['menu'] = "Category";

        if ($request->ajax()) {
            return Datatables::of(Category::where('parent_category_id',0)->get())
                ->addIndexColumn()
                ->make(true);
        }

        return view('admin.category.index', $data);
    }

    public function create($pcid = null)
    {
        $data['menu'] = "Category";
        return view("admin.category.create",$data);
    }

    public function store(Request $request, $pcid = null)
    {
        $this->validate($request, [
            'name' => 'required',
            'image' => 'required|mimes:jpeg,jpg,png,bmp',
            'status' => 'required',
        ]);

        $input = $request->all();
        $input['user_id'] = Auth::user()->id;

        if($file = $request->file('image')){
            $input['image'] = $this->fileMove($file,'categories');
        }

        Category::create($input);

        \Session::flash('success', 'Category has been inserted successfully!');
        return redirect()->route('category.index');
    }

    public function show(Request $request, string $id){
        $data['menu'] = "Category";
        if ($request->ajax()) {
            return Datatables::of(Category::where('parent_category_id',$id)->get())
                ->addIndexColumn()
                ->make(true);
        }
        $data['parent_id'] = $id;
        return view('admin.category.subCategory', $data);
    }

    public function edit(string $id, $pcid = null)
    {
        $data['menu'] = "Category";
        $data['category'] = Category::where('id',$id)->first();
        return view('admin.category.edit',$data);
    }

    public function update(Request $request, string $id, $pcid = null)
    {
        $this->validate($request, [
            'name' => 'required',
            'image' => 'mimes:jpeg,jpg,png,bmp',
            'status' => 'required',
        ]);

        $input = $request->all();
        $category = Category::findorFail($id);

        if($file = $request->file('image')){
            if (!empty($category['image']) && file_exists($category['image'])) {
                unlink($category['image']);
            }
            $input['image'] = $this->fileMove($file,'categories');
        }

        $category->update($input);

        \Session::flash('success','Category has been updated successfully!');
        return redirect()->route('category.index');
    }

    public function destroy(string $id)
    {
        $categorys = Category::findOrFail($id);
        if(!empty($categorys)){
            if (!empty($categorys['image']) && file_exists($categorys['image'])) {
                unlink($categorys['image']);
            }
            $categorys->delete();
            return 1;
        }else{
            return 0;
        }
    }

    public function assign(Request $request){
        $category = Category::findorFail($request['id']);
        $category['status'] = "active";
        $category->update($request->all());
    }

    public function unassign(Request $request){
        $category = Category::findorFail($request['id']);
        $category['status'] = "inactive";
        $category->update($request->all());
    }
}
