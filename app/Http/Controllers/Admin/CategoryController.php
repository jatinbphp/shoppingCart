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
            return Datatables::of(Category::all())
                ->addIndexColumn()
                ->make(true);
        }

        return view('admin.category.index', $data);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $data['menu'] = "Category";
        return view("admin.category.create",$data);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
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
    public function edit(string $id)
    {
        $data['menu'] = "Category";
        $data['category'] = Category::where('id',$id)->first();
        return view('admin.category.edit',$data);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $this->validate($request, [
            'name' => 'required',
            'image' => 'mimes:jpeg,jpg,png,bmp',
            'status' => 'required',
        ]);

        $input = $request->all();
        $category = Category::findorFail($id);

        if($file = $request->file('image')){
            if (!empty($category['image'])) {
                unlink($category['image']);
            }
            $input['image'] = $this->fileMove($file,'categories');
        }

        $category->update($input);

        \Session::flash('success','Category has been updated successfully!');
        return redirect()->route('category.index');
    }

    /**
     * Remove the specified resource from storage.
     */
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
