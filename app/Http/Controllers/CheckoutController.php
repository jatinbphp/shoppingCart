<?php

namespace App\Http\Controllers;

use App\Models\UserAddresses;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Http\Requests\OrderPlacedRequest;

class CheckoutController extends Controller
{
    public function __construct(Request $request){
        $this->middleware('auth');
    }

    public function checkout(){        
        $data['title'] = 'Checkout';

        $data['cart_products'] = getTotalCartProducts();

        if(count($data['cart_products'])==0){
            return redirect()->route('products')->with('danger', 'Thank you for shopping with us! Please add the product to your cart.');
        }

        $data['user_addresses'] = UserAddresses::where('user_id',Auth::user()->id)->get();

        return view('checkout.checkout', $data);
    }

    public function placed(OrderPlacedRequest $request)
    {
        // code...
    }

    public function orderCompleted(){   
        $data['title'] = 'Order Completed';
        return view('checkout.order-completed', $data);
    }
}
