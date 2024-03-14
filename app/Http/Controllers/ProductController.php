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

        $data['categories'] = Category::with(['children', 'children.products'])->where('parent_category_id', 0)->orderBy('name', 'ASC')->get();

        $data['sizes'] = $this->getProductSizes();

        //$data['colors'] = $this->getProductColors();

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

        $products_collection = $products_query->with(['product_image', 'category', 'product_images', 'options.product_option_values'])
            ->orderBy('id', 'DESC')
            ->simplePaginate($items);

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

    protected function getProductSizes(){
        return ProductsOptions::join('products_options_values', 'products_options.id', '=', 'products_options_values.option_id')
            ->select('products_options_values.option_value')
            ->where('products_options.option_name', 'SIZE')
            ->groupBy('products_options_values.option_value')
            ->orderBy('products_options_values.option_value')
            ->get()
            ->pluck('option_value')
            ->toArray();
    }

    protected function getProductColors(){
        return ProductsOptions::join('products_options_values', 'products_options.id', '=', 'products_options_values.option_id')
            ->select('products_options_values.option_value')
            ->where('products_options.option_name', 'COLOR')
            ->groupBy('products_options_values.option_value')
            ->get()
            ->pluck('option_value')
            ->toArray();
    }

    public function details($productId){   
        $data['product'] = Products::with(['product_image', 'category', 'product_images', 'options.product_option_values'])->where('status', 'active')->where('id', $productId)->first();

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
        $product = Products::with(['product_image', 'category', 'product_images', 'options.product_option_values'])->where('status', 'active')->where('id', $productId)->first();
        
        return view('modals.quick-modal-data', [
            'info' => $product->toArray()
        ]);
    }
    public function productsFilter(Request $request){
        //return $request->all();
    }
}
