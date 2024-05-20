<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Category;
use App\Models\Products;
use App\Models\ProductImages;
use App\Models\ProductsOptions;
use App\Models\ProductsOptionsValues;
use App\Models\Review;
use App\Models\ProductStock;
use App\Models\ProductStockHistory;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Yajra\DataTables\DataTables;
use App\Http\Requests\ProductRequest;
use App\Http\Requests\ProductImportRequest;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;

class ProductController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $data['menu'] = 'Products';

        if ($request->ajax()) {
            return Datatables::of(Products::select())
                ->addIndexColumn()
                ->editColumn('price', function($row) {
                    return env('CURRENCY').number_format($row->price, 2);
                })
                ->editColumn('created_at', function($row){
                    return $row['created_at']->format('Y-m-d h:i:s');
                })
                ->editColumn('status', function($row){
                    $row['table_name'] = 'products';
                    return view('admin.common.status-buttons', $row);
                })
                ->addColumn('action', function($row){
                    $row['section_name'] = 'products';
                    $row['section_title'] = 'Product';
                    return view('admin.common.action-buttons', $row);
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
        $data['categories'] = Category::where('status', 'active')->orderBy('full_name', 'ASC')->pluck('full_name', 'id');
        $data['product_options'] = [];
        return view("admin.product.create",$data);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(ProductRequest $request)
    {
        $input = $request->all();
        $input['user_id'] = Auth::guard('admin')->id();
        $input['category_id'] = !empty($input['category_id']) ? implode(',', $input['category_id']) : '';
        $product = Products::create($input);

        //add default option
        $inputOption = ['SIZE', 'COLOR'];

        if(!empty($inputOption)){
            foreach ($inputOption as $key => $value) {

                if(!empty($value)){
                    $inputOptionRecord = [
                        'product_id' => $product->id,
                        'option_name' => $value
                    ];
                    ProductsOptions::create($inputOptionRecord);
                }
            }
        }

        /*if ($request->hasFile('file')) {
            foreach ($request->file('file') as $image) {

                $imageName = $this->fileMove($image,'products');
                ProductImages::create([
                    'product_id' => $product->id,
                    'image' =>  $imageName,
                ]);
            }
        }

        // options & options values
        if(!empty($input['options'])){
            $this->addProductOptionAddUpdate($input, $product->id);
        }*/

        \Session::flash('success', 'Product has been inserted successfully! Please add product images, options and options values.');
        return redirect()->route('products.edit', ['product' => $product->id]);
    }

    /**
     * Display the specified resource.
     */
    public function show($id)
    {
        //$products = Products::with(['category', 'product_images', 'options.product_option_values'])->findOrFail($id);
        $products = Products::with(['product_images', 'options.product_option_values'])->findOrFail($id);

        $products['categories'] = [];
        if(!empty($products['category_id'])){
            //$products['categories'] = get_product_categories_by_ids($products['category_id']);
            $products['categories'] =  Category::select('id', 'full_name', 'slug')->whereIn('id', explode(',', $products['category_id']))->orderBy('full_name', 'ASC')->get();
        }

        return view('admin.common.show_modal', [
            'section_info' => $products->toArray(),
            'type' => 'Product',
            'required_columns' => ['id', 'categories', 'product_name', 'sku', 'description', 'price', 'status', 'created_at', 'product_images', 'options']
        ]);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        $data['menu'] = 'Products';
        $data['product'] = Products::with('product_images')->findorFail($id);
        $data['categories'] = Category::where('status', 'active')->orderBy('full_name', 'ASC')->pluck('full_name', 'id');
        $data['product_options'] = ProductsOptions::with('product_option_values')->where('product_id',$id)->where('status','active')->get();

        return view('admin.product.edit',$data);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(ProductRequest $request, string $id)
    {
        $input = $request->all();
        $product = Products::findorFail($id);
        $input['category_id'] = !empty($input['category_id']) ? implode(',', $input['category_id']) : '';
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

        // options & options values
        if(!empty($input['options'])){
            $this->addProductOptionAddUpdate($input, $id);
        }

        \Session::flash('success','Product has been updated successfully!');
        return redirect()->route('products.index');
    }

    public function addProductOptionAddUpdate($input, $product_id)
    {
        $option_ids = [];
        $option_values_ids = [];
        if(!empty($input['options']['old'])){
            foreach ($input['options']['old'] as $key => $value) {
                $optionOld = ProductsOptions::where('id',$key)->where('product_id',$product_id)->first();
                $inputOption = [
                    'product_id' => $product_id,
                    'option_name' => $value
                ];
                $optionOld->update($inputOption);

                $option_ids[] = $optionOld->id;

                if(!empty($input['option_values']['old'][$key])){
                    foreach ($input['option_values']['old'][$key] as $oKey => $oValue) {

                        $option_value = ProductsOptionsValues::where('id',$oKey)->where('option_id',$optionOld->id)->where('product_id',$product_id)->first();
                        $inputOptionValues = [
                            'product_id' => $product_id,
                            'option_id' => $optionOld->id,
                            'option_value' => $oValue,
                            /*'option_price' => $input['option_price']['old'][$key][$oKey],*/
                        ];

                        if(empty($option_value)){
                            $option_new_value = ProductsOptionsValues::create($inputOptionValues);

                            $option_values_ids[] = $option_new_value->id;
                        } else {
                            $option_value->update($inputOptionValues);

                            $option_values_ids[] = $option_value->id;
                        }
                    }
                }

                if(!empty($input['option_values']['new'][$key])){
                    foreach ($input['option_values']['new'][$key] as $oKey => $oValue) {
                        $inputOptionValues = [
                            'product_id' => $product_id,
                            'option_id' => $optionOld->id,
                            'option_value' => $oValue,
                            /*'option_price' => $input['option_price']['new'][$key][$oKey],*/
                        ];
                        $option_new_value = ProductsOptionsValues::create($inputOptionValues);

                        $option_values_ids[] = $option_new_value->id;
                    }
                }
            }

            if(count($option_ids)>0){
                ProductsOptions::whereNotIn('id', $option_ids)->where('product_id', $product_id)->delete();
                ProductsOptionsValues::whereNotIn('option_id', $option_ids)->where('product_id', $product_id)->delete();
            }

            if(count($option_values_ids)>0){
                ProductsOptionsValues::whereNotIn('id', $option_values_ids)->where('product_id', $product_id)->delete();
            }
        }

        if(!empty($input['options']['new'])){
            foreach ($input['options']['new'] as $key => $value) {

                if(!empty($value)){
                    $inputOption = [
                        'product_id' => $product_id,
                        'option_name' => $value
                    ];
                    $optionNew = ProductsOptions::create($inputOption);

                    if(!empty($input['option_values']['new'][$key])){
                        foreach ($input['option_values']['new'][$key] as $oKey => $oValue) {
                            $inputOptionValues = [
                                'product_id' => $product_id,
                                'option_id' => $optionNew->id,
                                'option_value' => $oValue,
                                /*'option_price' => $input['option_price']['new'][$key][$oKey],*/
                            ];
                            ProductsOptionsValues::create($inputOptionValues);
                        }
                    }
                }
            }
        }
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
                            'user_id' => Auth::guard('admin')->id(),
                            'name' => $categoryName,
                        ];
                        $category = Category::create($inputCategory);
                    }

                    // check Product
                    $product = Products::where('sku',$data['SKU'])->first();
                    $inputProduct = [
                        'user_id' => Auth::guard('admin')->id(),
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

    public function getOptions(Request $request)
    {
        $data['product_options'] = [];
        if(!empty($request->product_id)){
            $data['product_options'] = ProductsOptions::with('product_option_values')->where('product_id',$request->product_id)->where('status','active')->get();
        }
        return view('admin.order.product-options', $data);
    }

    public function editOption(Request $request)
    {
        $data['product_options'] = [];
        if(!empty($request->product_id)){
            $data['option_value_id'] = $request->option_value_id;
            $data['product_options'] = ProductsOptions::with('product_option_values')
                ->when($request->has('product_id'), function ($query) use ($request) {
                    return $query->where('product_id', $request->product_id);
                })
                ->when($request->has('option_id'), function ($query) use ($request) {
                    return $query->where('id', $request->option_id);
                })
                ->where('status', 'active')
                ->get();

        }
        return view('admin.order.product-edit-options', $data);
    }

    public function reviewsList(Request $request,$id)
    {
        $data['menu'] = 'Product Reviews';
        $data['product_info'] = Products::findorFail($id);
        if ($request->ajax()) {
            return Datatables::of(Review::with('user')->where('product_id',$id)->get())
            ->addIndexColumn()
            ->addColumn('review_information', function($row){
                return view('admin.product.review-info', $row);
            })
            ->rawColumns(['review_information'])
            ->make(true);
        }
        return view('admin.product.review-list', $data);
    }

    public function reviewDetails(Request $request, $id)
    {
        $data['review_data'] = Review::findorFail($id);
        return response()->json($data);
    }

    public function index_stock(Request $request)
    {
        $id = $request->product_id;

        $combinations = DB::select("
                SELECT CONCAT(po1.option_value, ' ', po2.option_value) AS combination,
                       po1.option_value AS option_value_1,
                       po2.option_value AS option_value_2,
                       po1.id AS option_id_value_1,
                       po2.id AS option_id_value_2,
                       po1.option_id AS option_id_1,
                       po2.option_id AS option_id_2,
                       'SIZE' AS option_name_1,
                       'COLOR' AS option_name_2,
                       po1.product_id
                FROM (
                    SELECT * FROM products_options_values WHERE product_id = ? AND option_id IN (SELECT id FROM products_options WHERE option_name = 'SIZE') AND deleted_at IS NULL
                ) po1
                JOIN (
                    SELECT * FROM products_options_values WHERE product_id = ? AND option_id IN (SELECT id FROM products_options WHERE option_name = 'COLOR') AND deleted_at IS NULL
                ) po2 ON po1.product_id = po2.product_id AND po1.id <> po2.id
                WHERE po1.product_id = ?
                ORDER BY po1.option_value, po2.option_value
            ", [$id, $id, $id]);

        if ($request->ajax()) {
            return Datatables::of($combinations)
                ->addIndexColumn()
                ->editColumn('option_value_2', function($row){
                    return '<i class="fas fa-square" style="color: '.$row->option_value_2.'"></i>';
                })
                ->addColumn('total_qty', function($row){
                    $existStock = ProductStock::where('product_id',$row->product_id)->where('option_id_value_1',$row->option_id_value_1)->where('option_id_value_2',$row->option_id_value_2)->first();
                    return !empty($existStock) ? $existStock->total_qty : 0;
                })
                ->addColumn('remaining_qty', function($row){
                    $existStock = ProductStock::where('product_id',$row->product_id)->where('option_id_value_1',$row->option_id_value_1)->where('option_id_value_2',$row->option_id_value_2)->first();
                    return !empty($existStock) ? ($existStock->total_qty-$existStock->order_qty) : 0;
                })
                ->addColumn('order_qty', function($row){
                    $existStock = ProductStock::where('product_id',$row->product_id)->where('option_id_value_1',$row->option_id_value_1)->where('option_id_value_2',$row->option_id_value_2)->first();
                    return !empty($existStock) ? $existStock->order_qty : 0;
                })
                ->addColumn('action', function($row){
                    $rowArray['section_name'] = 'add_stock';
                    $rowArray['product_id'] = $row->product_id;
                    $rowArray['option_id_value_1'] = $row->option_id_value_1;
                    $rowArray['option_id_value_2'] = $row->option_id_value_2;
                    return view('admin.common.action-buttons', $rowArray);
                })
                ->rawColumns(['option_value_2'])
                ->make(true);
        }

        return view('admin.product.index', $data);
    }

    public function addProductStock(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'qty' => 'required|numeric|min:1',
            'product_id' =>'required',
            'option_id_value_1' => 'required',
            'option_id_value_2' => 'required',
        ]);

        if ($validator->fails()) {
            return response()->json(['errors' => $validator->errors()], 422);
        }

        $input = $request->all();
        ProductStockHistory::create($input);

        $existStock = ProductStock::where('product_id',$input['product_id'])->where('option_id_value_1',$input['option_id_value_1'])->where('option_id_value_2',$input['option_id_value_2'])->first();

        if(empty($existStock)){
            $input = $request->all();
            $input['total_qty'] = $input['qty'];
            $input['remaining_qty'] = $input['qty'];
            ProductStock::create($input);
        } else{
            $input['total_qty'] = ($input['qty']+$existStock['total_qty']);
            $existStock->update($input);
        }

        return response()->json(['success' => true, 'message' => 'Your data has been inserted successfully!']);
    }

    public function getStockHistory(Request $request){
        $history = ProductStockHistory::where('product_id',$request['product_id'])
            ->where('option_id_value_1',$request['option_1'])->where('option_id_value_2',$request['option_2'])
            ->orderBy('id','DESC')
            ->select();

        if ($request->ajax()) {
            return Datatables::of($history)
                ->addIndexColumn()
                ->editColumn('created_at', function($row){
                    return $row['created_at']->format('Y-m-d h:i:s');
                })
                ->make(true);
        }

        return ;
    }
}
