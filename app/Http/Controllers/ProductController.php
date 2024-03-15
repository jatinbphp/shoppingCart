<?php

namespace App\Http\Controllers;
use App\Models\Category;
use App\Models\Products;
use App\Models\ProductImages;
use App\Models\ProductsOptions;
use App\Models\ProductsOptionsValues;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ProductController extends Controller
{
    public function index(Request $request){                 
        $data['title'] = 'Shop';

        $items = $request->items ?? env('PRODUCT_PAGINATION_LENGHT');

        $category_id = $request->route()->hasParameter('category_id') ? $request->route('category_id') : ($request->input('category_id') ? $request->input('category_id') : null);

        $products_query = $this->buildProductsQuery($request, $category_id);

        if(!empty($request->sort) && isset($request->sort)){
            if ($request->sort === 'low_to_high') {
                $products_query->orderByRaw("CAST(REPLACE(REPLACE(price, ',', ''), '$', '') AS DECIMAL(10, 2)) ASC");
            } elseif ($request->sort === 'high_to_low') {
                $products_query->orderByRaw("CAST(REPLACE(REPLACE(price, ',', ''), '$', '') AS DECIMAL(10, 2)) DESC");
            } 
        }

        $total_products = $products_query->count();

        $products_collection = $products_query->with(['product_image', 'category', 'product_images', 'options.product_option_values', 'reviews'])
            ->orderBy('id', 'DESC')
            ->simplePaginate($items);

        // Calculate total_reviews and total_review_rating for each product
        $products_collection->getCollection()->transform(function ($product) {
            $product->total_reviews = $product->total_reviews();
            $product->total_review_rating = $product->total_review_rating();
            return $product;
        });

        $data['products'] = $products_collection;
        $data['total_products'] = $total_products;

        if ($request->ajax()) {
            $data['layout'] = $request->layout;
            return response()->json([
                'view'     => view('products.more-products', $data)->render(),
                'products' => $data['products'] ?? null,
                'is_last'  => $products_collection->onLastPage(),
                'status'   => 200, 
            ]);
        }

        return view('products.products-list', $data);
    }

    protected function buildProductsQuery($request, $category_id){
        return Products::where('status', 'active')
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
            ->when($request->keyword, function ($query, $keyword) {
                return $query->where(function ($query) use ($keyword) {
                    $query->where('product_name', 'like', '%' . $keyword . '%')
                        ->orWhere('sku', 'like', '%' . $keyword . '%')
                        ->orWhere('description', 'like', '%' . $keyword . '%');
                });
            })

            ->when($request->input('sizes'), function ($query, $sizes) {
                return $query->whereHas('products_options_value', function ($query) use ($sizes) {
                    $query->whereIn('option_value', $sizes);
                });
            })

            ->when($request->input('minPrice') && $request->input('maxPrice'), function ($query) use ($request) {
                return $query->whereBetween('price', [$request->minPrice, $request->maxPrice]);
            });
    }

    public function details($productId){   
        $data['product'] = Products::with(['product_image', 'category', 'product_images', 'options.product_option_values', 'reviews'])->where('status', 'active')->where('id', $productId)->first();

        // Calculate total_reviews and total_review_rating for the fetched product
        $data['product']->total_reviews = $data['product']->reviews->count();
        $data['product']->total_review_rating = $data['product']->reviews->sum('rating');

        $data['title'] = $data['product']['product_name'];

        $category = Category::findOrFail($data['product']['category_id']);
        $data['category_products'] = $category->products()->where('id', '!=', $productId)->take(8)->get();

        $user=Auth::user();
        if(!empty($user) || isset($user))
        {
            $data['user_data']= Auth::user();
        }
        else{
            $data['user_data']= "";
        }
        return view('products.product-details', $data);
    }

    public function quickview($productId){   
        $product = Products::with(['product_image', 'category', 'product_images', 'options.product_option_values', 'reviews'])->where('status', 'active')->where('id', $productId)->first();

        // Calculate total_reviews and total_review_rating for the fetched product
        $product->total_reviews = $product->reviews->count();
        $product->total_review_rating = $product->reviews->sum('rating');
        
        return view('modals.quick-modal-data', [
            'info' => $product->toArray()
        ]);
    }
    public function productsFilter(Request $request){
        //return $request->all();
    }
}
