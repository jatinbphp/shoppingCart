<?php

namespace App\Http\Controllers;

use Mail;
use App\Models\UserAddresses;
use App\Models\Cart;
use App\Models\Order;
use App\Models\OrderItem;
use App\Models\OrderOption;
use App\Models\ProductsOptions;
use App\Models\ProductsOptionsValues;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Http\Requests\OrderPlacedRequest;
use App\Mail\OrderPlaced;

class CheckoutController extends Controller
{
    public function __construct(Request $request){
        $this->middleware('auth');
    }

    public function checkout(){        
        $data['title'] = 'Checkout';
        $data['user_addresses'] = UserAddresses::where('user_id',Auth::user()->id)->get();
        $data['cart_products'] = getTotalCartProducts();

        if(count($data['cart_products'])==0){
            return redirect()->route('products')->with('danger', 'Thank you for shopping with us! Please add the product to your cart.');
        }

        return view('checkout.checkout', $data);
    }

    public function placed(OrderPlacedRequest $request){
        $input = $request->all();
        $order_products = Cart::with('product')->where('user_id',Auth::user()->id)->where('order_id',0)->get();
        if(!empty($order_products)){

            $input['user_id'] = Auth::user()->id;

            if($input['address_id']==0){
                $newAddress = UserAddresses::create($input);
                $input['address_id'] = $newAddress['id'];
            }
            $order = Order::create($input);

            $orderTotal = 0;
            foreach ($order_products as $key => $value) {

                $orderTotal += ($value->product->price*$value->quantity);
                $inputOrderItem = [
                    'order_id' => $order->id,
                    'product_id' => $value->product_id,
                    'product_name' => $value->product->product_name,
                    'product_sku' => $value->product->sku,
                    'product_price' => $value->product->price,
                    'product_qty' => $value->quantity,
                    'sub_total' => ($value->product->price*$value->quantity),
                ];
                $OrderItem = OrderItem::create($inputOrderItem);

                $options = json_decode($value->options);
                if(!empty($options)){
                    foreach ($options as $keyO => $valueO) {

                        $product_option = ProductsOptions::where('id',$keyO)->first();
                        $product_option_value = ProductsOptionsValues::where('id', $valueO)->first();
                        $inputOrderOption = [
                            'order_id' => $order->id,
                            'order_product_id' => $OrderItem->id,
                            'product_option_id' => $keyO,
                            'product_option_value_id' => $valueO,
                            'name' => $product_option->option_name,
                            'value' => $product_option_value->option_value,
                            'price' => $product_option_value->option_price,
                        ];
                        OrderOption::create($inputOrderOption);
                    }
                }
                //OrderOption
            }

            //update total in order table
            $address = UserAddresses::findOrFail($input['address_id']);
            $order['address_info'] = json_encode($address);
            $order['total_amount'] = $orderTotal;
            $order['status'] = 'complete';
            $order->save();

            // clear cart
            Cart::where('user_id',Auth::user()->id)->delete();

            //send order success mial
            $data['order'] = Order::with('orderItems.product.product_image')->find(7);
            $data['user'] = Auth::user(); 
            Mail::to('emmanuel.k.php@gmail.com')->send(new OrderPlaced($data));

            return redirect()->route('checkout.order-completed');
            
        } else {
            \Session::flash('danger', 'Something went wrong. Please try again!');
            return redirect()->route('checkout');
        }
    }

    public function orderCompleted(){   
        $data['title'] = 'Order Completed';
        $order = Order::select('id', 'created_at')->where('user_id', Auth::user()->id)->orderBy('id', 'DESC')->firstOrFail();

        if(empty($order)){
            return redirect()->route('products')->with('danger', 'Your account needs to be updated with the orders.');
        }

        $data['order_id'] = env('ORDER_PREFIX').'-'.date("Y", strtotime($order->created_at)).'-'.$order->id; 
        return view('checkout.order-completed', $data);
    }
}
