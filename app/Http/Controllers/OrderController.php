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

    public function myOrders(Request $request){   
        if ($request->ajax()) {
            $paginationLength = config('constants.PRODUCT_PAGINATION_LENGTH', 9);
            $orders = Order::with(['user', 'orderItems'])
                        ->where('user_id', Auth::user()->id)
                        ->paginate($paginationLength);
            
            $view = view('my-orders.more-orders', compact('orders'))->render();
            $pagination = $orders->links()->toHtml();
            return response()->json(['orders' => $view, 'pagination' => $pagination]);
        } else {
            $data['title'] = 'My Orders';
            $paginationLength = config('constants.PRODUCT_PAGINATION_LENGTH', 9);
            $data['orders'] = Order::with(['user', 'orderItems'])
                                ->where('user_id', Auth::user()->id)
                                ->paginate($paginationLength);
            return view('my-orders.orders', $data);
        }
    }

    public function orderDetails($orderId){   
        $data['title'] = 'My Order Details';
        $data['order'] = Order::with('orderItems.product.product_image')->find($orderId);
        return view('my-orders.order-details', $data);
    }
}
