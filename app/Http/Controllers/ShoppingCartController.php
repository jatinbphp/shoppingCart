<?php

namespace App\Http\Controllers;

use App\Models\Cart;
use App\Models\OrderOption;
use App\Models\OrderStockHistory;
use App\Models\ProductStock;
use App\Models\User;
use App\Models\Products;
use App\Models\ProductImages;
use App\Models\UserAddresses;
use App\Models\ProductsOptions;
use App\Models\ProductsOptionsValues;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Session;

class ShoppingCartController extends Controller
{
    public function __construct(Request $request){
        $this->middleware('auth');
    }

    public function shoppingCart(){
        $data['title'] = 'Shopping Cart';
        $data['cart_products'] = getTotalCartProducts();

        if(count($data['cart_products'])==0){
            return redirect()->route('products')->with('danger', 'Thank you for shopping with us! Please add the product to your cart.');
        }

        return view('cart.cart-lists', $data);
    }

    public function addProductToCart(Request $request){
        $this->validate($request, [
            'product_id' => 'required',
            'quantity' =>'required|numeric',
            'options' => 'required|array',
            'options.*' => 'array', // Ensure each option is an array
            'options.*' => 'numeric' // Ensure each option value is numeric
        ]);

        $input = $request->all();
        $data = ['status' => 0];
        $remaining_qty = 0;

        $cart = Cart::where('user_id', Auth::user()->id)
                ->where('product_id', $input['product_id'])
                ->where('options', json_encode($input['options']))
                ->first();

        if (empty($cart)) {
            $oIds = !empty($input['options']) ? array_values($input['options']) : [];
            $stock = $this->checkStock($input['product_id'], $oIds, 1);

            if (!empty($stock) && $stock['remaining_qty'] > 0) {
                $remaining_qty = $stock['remaining_qty'];

                if ($stock['remaining_qty'] >= $input['quantity']) {
                    $input['options'] = json_encode($input['options']);
                    $input['user_id'] = Auth::user()->id;
                    Cart::create($input);
                    $data['status'] = 1;
                    $data['message'] = 'Your product was added to cart successfully!';
                } else {
                    $data['message'] = '<span class="text-danger">We apologize, but it seems you\'ve already added the maximum quantity of this product to your cart. </br></br>We currently have '.$remaining_qty.' quantity left in stock.</span>';    
                }
            } else {
                $data['message'] = '<span class="text-danger">We apologize, but it seems you\'ve already added the maximum quantity of this product to your cart. </br></br>We currently have '.$remaining_qty.' quantity left in stock.</span>';
            }
        } else {
            $cartOptions = !empty($cart->options) ? json_decode($cart->options, true) : [];
            $oIds = !empty($cartOptions) ? array_values($cartOptions) : [];
            $stock = $this->checkStock($cart->product_id, $oIds, 1);

            if (!empty($stock) && $stock['remaining_qty'] > 0) {
                $newQty = $cart->quantity + $input['quantity'];
                $remaining_qty = $stock['remaining_qty'];

                if ($stock['remaining_qty'] >= $newQty) {
                    $cart->quantity = $newQty;
                    $cart->save();
                    $data['status'] = 1;
                    $data['message'] = 'Your product was added to cart successfully!';
                } else {
                    $data['message'] = '<span class="text-danger">We apologize, but it seems you\'ve already added the maximum quantity of this product to your cart. </br></br>We currently have '.$remaining_qty.' quantity left in stock.</span>';
                }
            } else {
                $data['message'] = '<span class="text-danger">We apologize, but it seems you\'ve already added the maximum quantity of this product to your cart. </br></br>We currently have '.$remaining_qty.' quantity left in stock.</span>';
            }
        }

        $data['cartCount'] = count(getTotalCartProducts());
        return $data;
    }

    public function cartview(){
        $cart_products = [];
        if (Auth::check()) {
            $userId = Auth::id();

            $cart_products = Cart::with('product', 'product.product_image')->where('user_id', $userId)->orderBy('created_at', 'desc')->take(3)->get();

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
            'total' => count(getTotalCartProducts()),
        ];
        return response()->json($responseData);
    }

    public function updateQuantity(Request $request){
        // Validate the incoming request
        $request->validate([
            'id' => 'required|integer',
            'quantity' => 'required|integer|min:1',
        ]);

        // Find the cart item by user_id and id
        $cart = Cart::where('user_id', Auth::user()->id)
                    ->where('id', $request->id)
                    ->first();

        // If the cart item doesn't exist, return a 404 response
        if (!$cart) {
            return response()->json(['status' => 404, 'message' => 'Product not found.'], 404);
        }

        // Decode cart options
        $cartOptions = !empty($cart->options) ? json_decode($cart->options, true) : [];
        $oIds = !empty($cartOptions) ? array_values($cartOptions) : [];

        // Check stock for the product and its options
        $stock = $this->checkStock($cart->product_id, $oIds, 1);

        // Initialize response data
        $remaining_qty = !empty($stock) ? $stock['remaining_qty'] : 0;

        if ($remaining_qty > 0) {
            $newQty = $request->quantity;

            if ($remaining_qty >= $newQty) {
                $cart->update(['quantity' => $newQty]);
                $response = ['status' => 1, 'message' => 'Your quantity has been successfully updated.'];
            } else {
                $response = ['status' => 0, 'message' => '<span class="text-danger">We apologize, but it seems you\'ve already added the maximum quantity of this product to your cart. </br></br>We currently have '.$remaining_qty.' quantity left in stock.</span>'];
            }
        } else {
            $response = ['status' => 0, 'message' => '<span class="text-danger">We apologize, but it seems you\'ve already added the maximum quantity of this product to your cart. </br></br>We currently have '.$remaining_qty.' quantity left in stock.</span>'];
        }

        // Return a response
        return response()->json(['status' => 200, 'message' => $response['message']]);
    }

    public function updateRemainingQuantity(Request $request){
        // Validate the incoming request
        $request->validate([
            'id' => 'required|integer',
        ]);

        // Find the cart item by user_id and id
        $cart = Cart::where('user_id', Auth::user()->id)
                    ->where('id', $request->id)
                    ->first();

        // If the cart item doesn't exist, return a 404 response
        if (!$cart) {
            return response()->json(['status' => 404, 'message' => 'Product not found.'], 404);
        }

        // Decode cart options
        $cartOptions = !empty($cart->options) ? json_decode($cart->options, true) : [];
        $oIds = !empty($cartOptions) ? array_values($cartOptions) : [];

        // Check stock for the product and its options
        $stock = $this->checkStock($cart->product_id, $oIds, 1);

        // Initialize response data
        $remaining_qty = !empty($stock) ? $stock['remaining_qty'] : 0;

        if ($remaining_qty > 0) {
            $cart->update(['quantity' => $stock['remaining_qty']]);
            $response = ['status' => 1, 'message' => 'Your quantity has been successfully updated.'];
        } else {
            $response = ['status' => 0, 'message' => '<span class="text-danger">We apologize, but it seems you\'ve already added the maximum quantity of this product to your cart. </br></br>We currently have '.$remaining_qty.' quantity left in stock.</span>'];
        }

        // Return a response
        return response()->json(['status' => 200, 'message' => $response['message']]);
    }
}
