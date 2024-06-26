<?php

namespace App\Http\Controllers;

use App\Models\OrderStockHistory;
use App\Models\ProductStock;
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

            $error = 0;
            foreach ($order_products as $value) {
                $cartOptions = !empty($value->options) ? json_decode($value->options, true) : [];
                $oIds = !empty($cartOptions) ? array_values($cartOptions) : [];
                $stock = $this->checkStock($value->product_id, $oIds, 1);

                if (!empty($stock) && $stock['remaining_qty'] > 0) {
                    $newQty = $value->quantity;
                    $remaining_qty = $stock['remaining_qty'];

                    if ($stock['remaining_qty'] < $newQty) {
                        $error = 1;
                        break; // No need to continue if there's an error
                    }
                } else {
                    $error = 1;
                    break; // No need to continue if there's an error
                }
            }

            if($error==1){
                \Session::flash('danger', 'Something went wrong. Please try again!');
                return redirect()->route('checkout');
            }

            $input['user_id'] = Auth::user()->id;

            if($input['address_id']==0){
                $newAddress = UserAddresses::create($input);
                $input['address_id'] = $newAddress['id'];
            }
            $order = Order::create($input);

            $orderTotal = 0;
            foreach ($order_products as $key => $value) {
                $options = json_decode($value->options);
                $oIds = [];
                if(!empty($options)){
                    foreach ($options as $keyO => $valueO) {
                        $oIds[] = $valueO;
                    }
                }
                /*Stock Update During Order*/
                $stock = $this->checkStock($value->product_id,$oIds,0, $order->id, $value->quantity, 0);
                if($stock == 1){
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
                            $oIds[] = $valueO;
                        }
                    }
                }
            }

            //update total in order table
            $address = UserAddresses::findOrFail($input['address_id']);
            $order['address_info'] = json_encode($address);
            $order['total_amount'] = $orderTotal;
            $order['status'] = 'pending';
            $order->save();

            // clear cart
            Cart::where('user_id',Auth::user()->id)->delete();

            //send order
            $data['order'] = Order::with('orderItems.product.product_image')->find($order->id);
            $data['user'] = Auth::user();

            $to = env('MAIL_FROM_ADDRESS');
            $subject = 'New Order Received: #' . 'INV-'. date('Y', strtotime($data['order']->created_at)) . '-' . $data['order']->id;

            // For admin notification
            $data['recipient'] = 'admin';
            $adminMessage = view('mail-templates.orders.order-placed', $data)->render();

            // For customer confirmation
            $data['recipient'] = 'customer';
            $customerMessage = view('mail-templates.orders.order-placed', $data)->render();

            $headers = [
                'MIME-Version: 1.0',
                'Content-Type: text/html; charset=ISO-8859-1',
                'From: '.env('MAIL_FROM_ADDRESS'),
                'Reply-To: '.env('MAIL_FROM_ADDRESS')
            ];

            // Send email
            mail($to, $subject, $adminMessage, implode("\r\n", $headers)); //for admin
            mail(Auth::user()->email, $subject, $customerMessage, implode("\r\n", $headers)); //for customers

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
