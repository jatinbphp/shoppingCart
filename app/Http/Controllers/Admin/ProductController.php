<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Category;
use App\Models\Products;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Yajra\DataTables\DataTables;
use App\Http\Requests\ProductRequest;

class ProductController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $data['menu'] = 'Products';
        if ($request->ajax()) {
            return Datatables::of(Products::orderBy('product_name','ASC')->get())
                ->addIndexColumn()
                ->make(true);
        }

        return view('admin.product.index', $data);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $data['menu'] = 'Products';
        $data['categories'] = $this->getCategories();
        return view("admin.product.create",$data);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(ProductRequest $request)
    {
        $input = $request->all();
        $input['user_id'] = Auth::user()->id;
        Products::create($input);

        \Session::flash('success', 'Product has been inserted successfully!');
        return redirect()->route('products.index');
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
        $data['menu'] = 'Products';
        $data['product'] = Products::where('id',$id)->first();
        $data['categories'] = $this->getCategories();
        return view('admin.product.edit',$data);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(ProductRequest $request, string $id)
    {
        $input = $request->all();
        $product = Products::findorFail($id);
        $product->update($input);

        \Session::flash('success','Product has been updated successfully!');
        return redirect()->route('products.index');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $products = Products::findOrFail($id);
        if(!empty($products)){
            if (!empty($products['image']) && file_exists($products['image'])) {
                unlink($products['image']);
            }
            $products->delete();
            return 1;
        }else{
            return 0;
        }
    }

    public function assign(Request $request){
        $product = Products::findorFail($request['id']);
        $product['status'] = "active";
        $product->update($request->all());
    }

    public function unassign(Request $request){
        $product = Products::findorFail($request['id']);
        $product['status'] = "inactive";
        $product->update($request->all());
    }
}
