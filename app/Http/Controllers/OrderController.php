<?php

namespace App\Http\Controllers;
use App\Models\User;
use App\Models\Order;
use App\Models\OrderItem;
use App\Models\OrderOption;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Session;

class OrderController extends Controller
{
    public function __construct(Request $request){
        $this->middleware('auth');
    }

    public function myOrders(){   
        $data['title'] = 'My Orders';
        $data['orders'] = Order::with(['user', 'orderItems'])->where('user_id', Auth::user()->id)->get();
        return view('my-orders.orders', $data);
    }

    public function orderDetails($orderId){   
        $data['title'] = 'My Order Details';
        $data['order'] = Order::with('orderItems')->find($orderId);
        return view('my-orders.order-details', $data);
    }
}
