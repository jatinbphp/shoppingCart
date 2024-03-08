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
    public function index(Request $request){
        $items = $request->items ?? 6;
        $products_collection = Products::with(['product_image', 'category', 'product_images', 'options.product_option_values'])
            ->where('status', 'active')
            ->orderBy('id', 'DESC')
            ->simplePaginate($items);

        $data['products'] = $products_collection;

        if ($request->ajax()) {
            return response()->json([
                'view'     => view('more-products', $data)->render(),
                'products' => $data['products'] ?? null,
                'is_last'  => $products_collection->onLastPage(),
                'status'   => 200, 
            ]);
        }

        return view('products', $data);
    }

    public function details($productId){   
        $data['product'] = Products::with(['product_image', 'category', 'product_images', 'options.product_option_values'])->where('status', 'active')->where('id', $productId)->first();

        $category = Category::findOrFail($data['product']['category_id']);
        $data['category_products'] = $category->products()->where('id', '!=', $productId)->take(8)->get();

        return view('product-details', $data);
    }

    public function quickview($productId){   
        $product = Products::with(['product_image', 'category', 'product_images', 'options.product_option_values'])->where('status', 'active')->where('id', $productId)->first();
        
        return view('modals.quick-modal-data', [
            'info' => $product->toArray()
        ]);
    }
}
