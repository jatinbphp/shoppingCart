<?php

namespace App\Http\Controllers;
use App\Models\Cart;
use App\Models\User;
use App\Models\Products;
use App\Models\ProductImages;
use App\Models\ProductsOptions;
use App\Models\ProductsOptionsValues;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Session;
use App\Http\Requests\UserAddressesRequest;
use App\Http\Requests\UserProfileUpdateRequest;

class CheckoutController extends Controller
{
    public function __construct(Request $request){
        $this->middleware('auth');
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

        return view('checkout.checkout', $data);
    }

    public function orderCompleted(){   
        $data['title'] = 'Order Completed';
        return view('checkout.order-completed', $data);
    }
}
