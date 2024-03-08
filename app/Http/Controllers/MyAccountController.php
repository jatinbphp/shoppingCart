<?php

namespace App\Http\Controllers;
use App\Models\Category;
use App\Models\Products;
use App\Models\ProductImages;
use App\Models\ProductsOptions;
use App\Models\ProductsOptionsValues;
use App\Models\Wishlist;
use App\Models\Cart;
use App\Models\User;
use App\Http\Requests\UserProfileUpdateRequest;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Session;

class MyAccountController extends Controller
{

    public function __construct(Request $request){
        $this->middleware('auth');
    }

    public function shoppingCart(){   
        $user_id = Auth::user()->id;
        $data['title'] = 'Shopping Cart';
        return view('my-account.shopping-cart', $data);
    }

    public function checkout(){   
        $user_id = Auth::user()->id;
        $data['title'] = 'Checkout';
        $data['cart_prducts'] = Cart::with('product', 'product.product_image')->where('user_id', $user_id)->get();
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
        $data['wishlists'] = Wishlist::with('product', 'product.product_image')->where('user_id', $user_id)->get();
        return view('my-account.wishlists', $data);
    }

    public function myOrders(){   
        $user_id = Auth::user()->id;
        $data['title'] = 'My Orders';
        return view('my-account.orders', $data);
    }

    public function profileInfo(){   
        $data['title'] = 'Profile Information';        
        $data['user_info']= Auth::user();
        return view('my-account.profile-info', $data);
    }

    public function userProfileUpdate(Request $request)
    {
        $user = User::find(Auth::user()->id);
        $request->validate([
            'name' => 'required',
            'email' => 'required|email|unique:users,email,'.$user->id.',id',
            'image' => 'nullable|mimes:jpeg,jpg,png,bmp', // Allow null or valid image files
            'password' => 'nullable|confirmed',
        ]);

        $input = $request->except('password', 'password_confirmation');
        if ($request->hasFile('image')) {
            if (!empty($user->image) && file_exists(public_path($user->image))) {
                unlink(public_path($user->image));
            }
            $image = $request->file('image');
            $imageName = time().'.'.$image->extension(); 
            $image->move(public_path('uploads/users/'), $imageName); 
            $input['image'] = 'uploads/users/'.$imageName;
        }

        if ($request->filled('password')) {
            $input['password'] = Hash::make($request->password);
        } else {
            unset($input['password']);
        }
        $user->update($input);

        \Session::flash('success', 'Profile has been updated successfully!');
        return redirect()->back();
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

    public function addProductToCart(Request $request)
    {
        $this->validate($request, [
            'product_id' => 'required',
            'quantity' =>'required|numeric',
            'options' => 'required|array',
            'options.*' => 'array', // Ensure each option is an array
            'options.*' => 'numeric' // Ensure each option value is numeric
        ]);

        $input = $request->all();

        $cart = Cart::where('user_id', Auth::user()->id)->where('product_id', $input['product_id'])->where('options', json_encode($input['options']))->first();

        if(empty($cart)){
            $input['options'] = json_encode($input['options']);
            $input['user_id'] = Auth::user()->id;
            Cart::create($input);
        } else{
            $cart['quantity'] = ($cart['quantity']+$input['quantity']);
            $cart->save();
        }

        return count(getCartProductIds());
    }

    public function cartview(){   
        $cart_products = [];
        if (Auth::check()) {
            $userId = Auth::id();            
            $cartProducts = Cart::where('user_id', $userId)
                ->orderBy('created_at', 'desc') // Order by creation date
                ->take(4)
                ->pluck('product_id')
                ->toArray();
            
            $cart_products = Products::whereIn('id', $cartProducts)->get();
        }

        return view('modals.cart-modal-data', [
            'cart_products' => $cart_products
        ]);
    }

    public function removeProducttoCart(Request $request){
        
        $input = $request->all();
        $user_id = Auth::user()->id;

        $cart = Cart::where('user_id', $user_id)->where('product_id', $request->id)->first();
        $cart->delete();

        $responseData = [
            'total' => count(getCartProductIds()),
        ];        
        return response()->json($responseData);
    }
}
