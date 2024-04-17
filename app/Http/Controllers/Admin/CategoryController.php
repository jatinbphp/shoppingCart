<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Category;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Yajra\DataTables\DataTables;
use App\Http\Requests\CategoryRequest;

class CategoryController extends Controller
{
    public function index(Request $request)
    {
        $data['menu'] = 'Category';

        if ($request->ajax()) {
            return Datatables::of(Category::select())
                ->addIndexColumn()
                ->editColumn('created_at', function($row){
                    return $row['created_at']->format('Y-m-d h:i:s');
                })
                ->editColumn('status', function($row){
                    $row['table_name'] = 'categories';
                    return view('admin.common.status-buttons', $row);
                })
                ->addColumn('action', function($row){
                    $row['section_name'] = 'category';
                    $row['section_title'] = 'Category';
                    return view('admin.common.action-buttons', $row);
                })
                ->make(true);
        }

        return view('admin.category.index', $data);
    }

    public function create($pcid = null)
    {
        $data['menu'] = 'Category';

        $data['categories'] = Category::orderBy('full_name', 'ASC')->where('parent_category_id', 0)->pluck('full_name', 'id')->prepend('Please Select', '0');

        return view("admin.category.create",$data);
    }

    public function store(CategoryRequest $request, $pcid = null)
    {
        $input = $request->all();
        $input['user_id'] = Auth::guard('admin')->id();

        if($file = $request->file('image')){
            $input['image'] = $this->fileMove($file,'categories');
        }

        if(!empty($request->parent_category_id)){
            $category_parent = Category::findorFail($request->parent_category_id);
            $input['full_name'] = $category_parent->name.' -> '.$request->name;
        } else {
            $input['full_name'] = $request->name;
        }

        $input['slug'] = str_replace("--", "-",$this->getSlug($request->name));

        Category::create($input);

        \Session::flash('success', 'Category has been inserted successfully!');
        return redirect()->route('category.index');
    }

    public function show($id)
    {
        $category = Category::with('parent')->findOrFail($id);
        
        return view('admin.common.show_modal', [
            'section_info' => $category->toArray(),
            'type' => 'Category',
            'required_columns' => ['id', 'image', 'name', 'parent', 'status', 'created_at']
        ]);
    }

    public function edit(string $id, $pcid = null)
    {        
        $data['menu'] = 'Category';
        $data['category'] = Category::findOrFail($id);
        $data['categories'] = Category::orderBy('full_name', 'ASC')->where('parent_category_id', 0)->pluck('full_name', 'id')->prepend('Please Select', '0');
        
        return view('admin.category.edit',$data);
    }

    public function update(CategoryRequest $request, string $id, $pcid = null)
    {
        $input = $request->all();
        $category = Category::findorFail($id);

        if($file = $request->file('image')){
            if (!empty($category['image']) && file_exists($category['image'])) {
                unlink($category['image']);
            }
            $input['image'] = $this->fileMove($file,'categories');
        }

        if(!empty($request->parent_category_id)){
            $category_parent = Category::findorFail($request->parent_category_id);
            $input['full_name'] = $category_parent->name.' -> '.$request->name;
        } else {

            // update paths
            $parent_categories = Category::where('parent_category_id', $id)->get();

            if(!$parent_categories->isEmpty()) {
                foreach ($parent_categories as $categorySub) {
                    $categorySub->update([
                        'full_name' => $request->name.' -> '.$categorySub->name
                    ]);
                }
            }

            $input['full_name'] = $request->name;
        }

        $input['slug'] = str_replace("--", "-",$this->getSlug($request->name));
        
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
}
