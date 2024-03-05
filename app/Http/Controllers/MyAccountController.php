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

class MyAccountController extends Controller
{

    public function shoppingCart(){   
        $user_id = Auth::user()->id;

        $data['title'] = 'Shopping Cart';

        return view('my-account.shopping-cart', $data);
    }

    public function checkout(){   
        $user_id = Auth::user()->id;

        $data['title'] = 'Checkout';

        return view('my-account.checkout', $data);
    }

    public function orderCompleted(){   
        $user_id = Auth::user()->id;

        $data['title'] = 'Order Completed';

        return view('my-account.order-completed', $data);
    }

    public function myWishlist(){   
        $user_id = Auth::user()->id;

        $data['title'] = 'My Wishlist';

        $data['wishlists'] = Wishlist::where('user_id', $user_id)->get();

        return view('my-account.wishlists', $data);
    }

    public function myOrders(){   
        $user_id = Auth::user()->id;

        $data['title'] = 'My Orders';

        return view('my-account.orders', $data);
    }

    public function profileInfo(){   
        $user_id = Auth::user()->id;

        $data['title'] = 'Profile Information';

        return view('my-account.profile-info', $data);
    }

    public function myAddresses(){   
        $user_id = Auth::user()->id;

        $data['title'] = 'My Addresses';

        return view('my-account.addresses', $data);
    }

    public function editAddresses(){   
        $user_id = Auth::user()->id;

        $data['title'] = 'Edit Address';

        return view('my-account.edit-address', $data);
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
