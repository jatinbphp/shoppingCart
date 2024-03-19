<?php

namespace App\Http\Controllers;
use App\Models\User;
use App\Models\Order;
use App\Models\OrderItem;
use App\Models\OrderOption;
use DataTables;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Session;

class OrderController extends Controller
{
    public function __construct(Request $request){
        $this->middleware('auth');
    }

    public function index(Request $request){   
        $data['title'] = 'My Orders';    

        if ($request->ajax()) {
            return Datatables::of(Order::with('user', 'orderItems')->where('user_id',Auth::user()->id))
                ->addIndexColumn()
                ->addColumn('order_informations', function($row){
                    return view('my-orders.order-info', $row);
                })
                ->rawColumns(['order_informations'])
                ->make(true);
        }

        return view('my-orders.orders', $data);
    }

    public function orderDetails($orderId){   
        $data['title'] = 'My Order Details';
        $data['order'] = Order::with('orderItems.product.product_image')->findOrFail($orderId);

        if(empty($data['order'])){
            \Session::flash('danger', 'Something went wrong. Please try again!');
            return redirect()->route('orders-list');
        }
        return view('my-orders.order-details', $data);
    }
}
