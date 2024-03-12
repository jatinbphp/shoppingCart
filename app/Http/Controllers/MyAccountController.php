<?php

namespace App\Http\Controllers;
use App\Models\Cart;
use App\Models\User;
use App\Models\Category;
use App\Models\Products;
use App\Models\Wishlist;
use Illuminate\Http\Request;
use App\Models\ProductImages;
use App\Models\UserAddresses;
use App\Models\ProductsOptions;
use App\Models\ProductsOptionsValues;
use App\Models\Order;
use App\Models\OrderItem;
use App\Models\OrderOption;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Session;
use App\Http\Requests\UserAddressesRequest;
use App\Http\Requests\UserProfileUpdateRequest;

class MyAccountController extends Controller
{

    public function __construct(Request $request){
        $this->middleware('auth');
    }

    public function shoppingCart(){   
        $user_id = Auth::user()->id;
        $data['title'] = 'Shopping Cart';
        $data['cart_products'] = Cart::with('product', 'product.product_image')->where('user_id', $user_id)->orderBy('created_at', 'desc')->get();

        if(count($data['cart_products'])==0){
            return redirect()->route('products')->with('danger', 'Thank you for shopping with us! Please add the product to your cart.');
        } else {
            foreach ($data['cart_products'] as $key => $order) {

                $optionArray = [];
                $options = json_decode($order->options);
                if (!empty($options)) {
                    foreach ($options as $keyO => $valueO) {
                        $product_option = ProductsOptions::where('id', $keyO)->first();
                        $product_option_value = ProductsOptionsValues::where('id', $valueO)->first();

                        $optionArray[$product_option->option_name] = $product_option_value->option_value;
                    }
                }

                $data['cart_products'][$key]['product_options'] = $optionArray;

            }
        }
        return view('my-account.shopping-cart', $data);
    }

    public function checkout(){   
        $user_id = Auth::user()->id;
        $data['title'] = 'Checkout';
        $data['cart_products'] = Cart::with('product', 'product.product_image')->where('user_id', $user_id)->orderBy('created_at', 'desc')->get();

        if(count($data['cart_products'])==0){
            return redirect()->route('products')->with('danger', 'Thank you for shopping with us! Please add the product to your cart.');
        } else {
            foreach ($data['cart_products'] as $key => $order) {

                $optionArray = [];
                $options = json_decode($order->options);
                if (!empty($options)) {
                    foreach ($options as $keyO => $valueO) {
                        $product_option = ProductsOptions::where('id', $keyO)->first();
                        $product_option_value = ProductsOptionsValues::where('id', $valueO)->first();

                        $optionArray[$product_option->option_name] = $product_option_value->option_value;
                    }
                }

                $data['cart_products'][$key]['product_options'] = $optionArray;

            }
        }

        return view('my-account.checkout', $data);
    }

    public function orderCompleted(){   
        $user_id = Auth::user()->id;
        $data['title'] = 'Order Completed';
        return view('my-account.order-completed', $data);
    }

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
                'view'     => view('more-wishlists', $data)->render(),
                'wishlists' => $data['wishlists'] ?? null,
                'is_last'  => $wishlist_data->onLastPage(),
                'status'   => 200, 
            ]);
        }
        return view('my-account.wishlists', $data);
    }

    public function myOrders(){   
        $user_id = Auth::user()->id;
        $data['title'] = 'My Orders';

        $data['orders'] = Order::with(['user', 'orderItems'])->where('user_id', $user_id)->get();

        return view('my-account.orders', $data);
    }

    public function profileInfo(){   
        $data['title'] = 'Profile Information';        
        $data['user_info']= Auth::user();
        $data['categories'] = Category::where('status', 'active')->where('parent_category_id', 0)->orderBy('full_name', 'ASC')->pluck('full_name', 'id');
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

        if (!empty($input['categories_id'])) {
            $input['categories_id'] = implode(",", $input['categories_id']);
        }
        $user->update($input);

        \Session::flash('success', 'Profile has been updated successfully!');
        return redirect()->back();
    }

    public function myAddresses(){   
        $user_id = Auth::user()->id;
        $data['title'] = 'My Addresses';
        $data['user_addresses'] = UserAddresses::where('user_id', $user_id)->get();
        return view('my-account.addresses', $data);
    }
    public function editAddresses(Request $request){
        $id = $request->id;   
        $user_id = Auth::user()->id;
        $data['title'] = 'Edit Address';
        $data['id'] = $request->id;
        $data['user_addresses'] = UserAddresses::where('id', $id)->where('user_id', $user_id)->first();
        return view('my-account.edit-address', $data);
    }

    public function addAddresses(){
        $user_id = Auth::user()->id;
        $data['title'] = 'Add Address';
        return view('my-account.edit-address', $data);
    }

    public function storeAddresses(UserAddressesRequest $request){
        $input = $request->all();
        $input['user_id'] = auth()->user()->id;
        $input['is_default'] = $request->has('is_default') ? 1 : 0; 
        UserAddresses::updateOrCreate(['id' => isset($input['id']) ? $input['id'] : null], $input);
        $message = isset($input['id']) ? "updated" : "stored";
        return redirect()->route('my-account.addresses')->with('success', 'Addreess ' .$message.  ' successfully.');
    }

     public function destroyAddresses(Request $request){
        $userAddresses = UserAddresses::where('id', $request->id)
            ->where('user_id', auth()->user()->id)
            ->first();
        
        if(empty($userAddresses)) return redirect()->back()->with('danger', 'Address not found, Please try again.');
        $userAddresses->delete();
        return redirect()->route('my-account.addresses')->with('success', 'Addreess deleted successfully.');
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
            
            $cart_products = Cart::with('product', 'product.product_image')->where('user_id', $userId)->orderBy('created_at', 'desc')->get();

            if(count($cart_products)>0){
                foreach ($cart_products as $key => $order) {
                    $optionArray = [];
                    $options = json_decode($order->options);
                    if (!empty($options)) {
                        foreach ($options as $keyO => $valueO) {
                            $product_option = ProductsOptions::where('id', $keyO)->first();
                            $product_option_value = ProductsOptionsValues::where('id', $valueO)->first();

                            $optionArray[$product_option->option_name] = $product_option_value->option_value;
                        }
                    }
                    $cart_products[$key]['product_options'] = $optionArray;
                }
            }
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
    
    public function wishlistRemove($id)
    {
        Wishlist::findOrFail($id)->delete();
        return response()->json(['success' => true, 'total' => count(getWishlistProductIds())]);
    }
}
