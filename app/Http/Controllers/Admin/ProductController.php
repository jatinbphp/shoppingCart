<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Category;
use App\Models\Products;
use App\Models\ProductImages;
use App\Models\Options;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Yajra\DataTables\DataTables;
use App\Http\Requests\ProductRequest;
use App\Http\Requests\ProductImportRequest;

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
                ->addColumn('status', function($row){
                    $row['table_name'] = 'products';
                    return view('admin.status-buttons', $row);
                })
                ->addColumn('action', function($row){
                    $row['section_name'] = 'products';
                    $row['section_title'] = 'Product';
                    return view('admin.action-buttons', $row);
                })
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
        $data['options'] = Options::with('option_values')->where('status','active')->get();
        return view("admin.product.create",$data);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(ProductRequest $request)
    {
        $input = $request->all();
        $input['user_id'] = Auth::user()->id;
        $product = Products::create($input);

        if ($request->hasFile('file')) {
            foreach ($request->file('file') as $image) {

                $imageName = $this->fileMove($image,'products');
                ProductImages::create([
                    'product_id' => $product->id,
                    'image' =>  $imageName,
                ]);
            }
        }

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
        $data['product'] = Products::with('product_images')->where('id',$id)->first();
        $data['categories'] = $this->getCategories();
        $data['options'] = Options::with('option_values')->where('status','active')->get();
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

        if ($request->hasFile('file')) {
            foreach ($request->file('file') as $image) {

                $imageName = $this->fileMove($image,'products');
                ProductImages::create([
                    'product_id' => $id,
                    'image' =>  $imageName,
                ]);
            }
        }

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

    public function removeImage(Request $request)
    {
        $option_values = ProductImages::findOrFail($request['id']);
        if(!empty($option_values)){
            unlink($request['img_name']);
            $option_values->delete();
            return 1;
        }else{
            return 0;
        }
    }

    public function importProduct()
    {
        $data['menu'] = 'Products';        
        return view("admin.product.import",$data);
    }

    public function importProductStore(ProductImportRequest $request)
    {
        
        $file = $request->file('file');
        $csvFile = $this->fileMove($file,'product-csv');

        if (($handle = fopen($csvFile, 'r')) !== false) {
            // Read the header row
            $header = fgetcsv($handle);

            // Process each row
            while (($row = fgetcsv($handle)) !== false) {
                $data = array_combine($header, $row);

                if(!empty($data['CATEGORY_NAME']) && !empty($data['PRODUCT_NAME']) && !empty($data['SKU']) && !empty($data['DESCRIPTION']) && !empty($data['PRICE']) && !empty($data['STATUS'])){
                    $categoryName = $data['CATEGORY_NAME'];

                    // check Category
                    $category = Category::where('name',$categoryName)->first();
                    if(empty($category)){
                        $inputCategory = [
                            'user_id' => Auth::user()->id,
                            'name' => $categoryName,
                        ];
                        $category = Category::create($inputCategory);
                    }

                    // check Product
                    $product = Products::where('sku',$data['SKU'])->first();
                    $inputProduct = [
                        'user_id' => Auth::user()->id,
                        'category_id' => $category->id,
                        'sku' => $data['SKU'],
                        'product_name' => $data['PRODUCT_NAME'],
                        'description' => $data['DESCRIPTION'],
                        'price' => (is_numeric($data['PRICE'])) ? $data['PRICE'] : 0,
                        'status' => $data['STATUS'],
                    ];
                    if(empty($product)){
                        $product = Products::create($inputProduct);
                    } else {
                        $product->update($inputProduct);
                    }

                    // check product image
                    if(!empty($data['PRODUCT_IMAGES'])){
                        foreach (explode(",", $data['PRODUCT_IMAGES']) as $key => $value) {
                            $productsImage = ProductImages::where('image','uploads/products/'.trim($value))->where('product_id',$product->id)->first();

                            if(empty($productsImage)){
                                ProductImages::create([
                                    'product_id' => $product->id,
                                    'image' =>  'uploads/products/'.trim($value),
                                ]);
                            }
                        }
                    }
                }
            }
            fclose($handle);
        }

        \Session::flash('success', 'Product has been imported successfully!');
        return redirect()->route('products.index');
    }
}
