<?php

namespace App\Http\Controllers;
use App\Models\Category;
use App\Models\Products;
use App\Models\ProductImages;
use App\Models\ProductsOptions;
use App\Models\ProductsOptionsValues;
use App\Models\Wishlist;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session;

class ProductController extends Controller
{
    public function index(){
        $data['products'] = Products::with(['product_image', 'category', 'product_images', 'options.product_option_values'])->where('status', 'active')->orderBy('id', 'DESC')->get();
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

    public function addProducttoWishlist(Request $request){
        
        $input = $request->all();
        $user_id = Auth::user()->id;

        $wishlist = Wishlist::where('user_id', $user_id)->where('product_id', $request->id)->first();

        if ($wishlist) {
            $wishlist->delete();
            $type = 2;
        } else {
            $input['user_id'] = $user_id;
            $input['product_id'] = $request->id;
            Wishlist::create($input);
            $type = 1;
        }

        $responseData = [
            'total' => count(getWishlistProductIds()),
            'type' => $type,
        ];

        // Return the data as JSON response
        return response()->json($responseData);
    }

    public function wishlistview(){   

        $wishlist_products = [];
        // Check if a user is authenticated
        if (Auth::check()) {
            // Get the authenticated user's ID
            $userId = Auth::id();
            
            // Fetch wishlist products associated with the user
            $wishlistProducts = Wishlist::where('user_id', $userId)
                ->orderBy('created_at', 'desc') // Order by creation date
                ->take(4)
                ->pluck('product_id')
                ->toArray();

            // Fetch full product information for each product ID
            $wishlist_products = Products::whereIn('id', $wishlistProducts)->get();
        }

        return view('modals.wishlist-modal-data', [
            'wishlist_products' => $wishlist_products
        ]);
    }
}
