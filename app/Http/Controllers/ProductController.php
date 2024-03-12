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
        $data['title'] = 'Shop';
        $data['categories'] = Category::with(['children', 'children.products'])->where('parent_category_id', 0)->orderBy('name', 'ASC')->get();

        $items = $request->items ?? env('PRODUCT_PAGINATION_LENGHT');

        $category_id = $request->route()->hasParameter('category_id') ? $request->route('category_id') : ($request->input('category_id') ? $request->input('category_id') : null);

        $products_query = Products::where('status', 'active')
            ->when($category_id, function ($query, $category_id) {
                return $query->where(function ($query) use ($category_id) {
                    $query->where('category_id', $category_id)
                        ->orWhereIn('category_id', function ($query) use ($category_id) {
                            $query->select('id')
                                ->from('categories')
                                ->where('parent_category_id', $category_id);
                        });
                });
            })
            ->when($request->input('keyword'), function ($query, $keyword) {
                return $query->where(function ($query) use ($keyword) {
                    $query->where('product_name', 'like', '%' . $keyword . '%')
                        ->orWhere('sku', 'like', '%' . $keyword . '%')
                        ->orWhere('description', 'like', '%' . $keyword . '%');
                });
            });

        $total_products = $products_query->count();

        $products_collection = $products_query->with(['product_image', 'category', 'product_images', 'options.product_option_values'])
            ->orderBy('id', 'DESC')
            ->simplePaginate($items);

        $data['products'] = $products_collection;
        $data['total_products'] = $total_products;

        if ($request->ajax()) {
            $data['layout'] = $request->layout;
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

        $data['title'] = $data['product']['product_name'];

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
