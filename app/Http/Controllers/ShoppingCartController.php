<?php

namespace App\Http\Controllers;
use App\Models\Cart;
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
}
