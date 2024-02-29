<?php

namespace App\Http\Controllers;
use App\Models\Category;
use App\Models\Products;
use App\Models\ProductImages;
use App\Models\ProductsOptions;
use App\Models\ProductsOptionsValues;
use Illuminate\Http\Request;

class ProductController extends Controller
{
    public function index()
    {
        $data['products'] = Products::with(['product_image', 'category', 'product_images', 'options.product_option_values'])->where('status', 'active')->orderBy('id', 'DESC')->get();
        return view('products', $data);
    }

    public function details()
    {
        return view('product-details');
    }

    public function quickview($productId)
    {   
        $product = Products::with(['product_image', 'category', 'product_images', 'options.product_option_values'])->where('status', 'active')->where('id', $productId)->first();
        
        return view('modals.quick-modal-data', [
            'info' => $product->toArray()
        ]);
    }
}
