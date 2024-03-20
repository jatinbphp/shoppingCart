<?php

namespace App\Http\Controllers;
use App\Models\User;
use App\Models\Products;
use App\Models\Wishlist;
use App\Models\ProductImages;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Session;

class WishlistController extends Controller
{   
    /*public function __construct(Request $request){
        $this->middleware('auth');
    }*/

    public function myWishlist(Request $request){   
        $data['title'] = 'My Wishlist';
        $user_id = Auth::user()->id;

        $items = $request->items ?? env('PRODUCT_PAGINATION_LENGHT');
        
        $wishlist_query = Wishlist::where('user_id', $user_id);
        
        $total_products_in_wishlist = $wishlist_query->count();

        $wishlist_data = $wishlist_query->with('product', 'product.product_image')
            ->simplePaginate($items);

        $data['wishlists'] = $wishlist_data;
        $data['total_products_in_wishlist'] = $total_products_in_wishlist;

        if ($request->ajax()) {
            return response()->json([
                'view'     => view('my-wishlist.more-wishlists', $data)->render(),
                'wishlists' => $data['wishlists'] ?? null,
                'is_last'  => $wishlist_data->onLastPage(),
                'status'   => 200, 
            ]);
        }
        return view('my-wishlist.wishlists', $data);
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

    public function wishlistRemove($id){
        Wishlist::findOrFail($id)->delete();
        return response()->json(['success' => true, 'total' => count(getWishlistProductIds())]);
    }
}
