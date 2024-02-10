<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Order;
use App\Models\OrderItem;
use App\Models\OrderOption;
use App\Models\ProductsOptions;
use App\Models\ProductsOptionsValues;
use App\Models\User;
use App\Models\Cart;
use App\Models\Products;
use App\Models\UserAddresses;
use Yajra\DataTables\DataTables;
use App\Http\Requests\OrderRequest;

class OrderController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $data['menu'] = 'Orders';
        if ($request->ajax()) {
            return DataTables::of(Order::select()->orderBy('id', 'DESC'))
                ->addColumn('order_id', function($order) {
                    return env('ORDER_PREFIX').'-'.date("Y", strtotime($order->created_at)).'-'.$order->id; 
                })
                ->addColumn('user_name', function($order) {
                    return $order->user->name; 
                })
                ->addColumn('total_amount', function($order) {
                    return env('CURRENCY').number_format($order->total_amount, 2);
                })
                ->addColumn('created_at', function($row){
                    return $row['created_at']->format('Y-m-d h:i:s');
                })
                ->addColumn('action', function($row){
                    $row['section_name'] = 'orders';
                    $row['section_title'] = 'order';
                    return view('admin.action-buttons', $row);
                })
                ->addColumn('status', function($row){
                    $select = '<select class="form-control select2 orderStatus" id="status'.$row->unique_id.'"  data-id="'.$row->id.'" >';
                        foreach(Order::$allStatus as $status){
                            $selected = ($status == $row->status) ? ' selected="selected"' : '';
                            $select .= '<option '.$selected.' value="'.$status.'">'.ucfirst($status).'</option>';
                        }
                    $select .= '</select>';
                    return $select;
                })
                ->rawColumns(['status'])
                ->make(true);
        }

        return view('admin.order.index', $data);
    }

    public function index_product(Request $request)
    {
        $data['menu'] = 'Orders';
        if ($request->ajax()) {
            return DataTables::of(Cart::select()->where('csrf_token',csrf_token())->get())
                ->addColumn('product_name', function($order) {

                    $product_name = $order->product->product_name; 

                    $options = json_decode($order->options);
                    if(!empty($options)){
                        foreach ($options as $keyO => $valueO) {

                            $product_option = ProductsOptions::where('id',$keyO)->first();
                            $product_option_value = ProductsOptionsValues::where('id', $valueO)->first();

                            $product_name .= '</br><small><b>'.$product_option->option_name.' :</b> '.$product_option_value->option_value.'</small>';
                        }
                    }

                    return $product_name;
                })
                ->addColumn('sku', function($order) {
                    return $order->product->sku; 
                })
                ->addColumn('unit_price', function($order) {
                    return env('CURRENCY').number_format($order->product->price, 2);
                })
                ->addColumn('total', function($order) {
                    return env('CURRENCY').number_format(($order->quantity*$order->product->price), 2);
                })
                ->addColumn('quantity', function($row){
                    $quantity = '<div class="qty">';
                    $quantity .= '<button type="button" id="minus" data-id="'.$row->id.'"><i class="fa fa-minus" aria-hidden="true"></i></button>';
                    $quantity .= '<input type="text" id="quantity'.$row->id.'" value="'.$row->quantity.'">';
                    $quantity .= '<button type="button" id="plus" data-id="'.$row->id.'"><i class="fa fa-plus" aria-hidden="true"></i></button>';
                    $quantity .= '</div>';
                    return $quantity;
                })
                ->addColumn('action', function($row){
                    $row['section_name'] = 'cart_products';
                    $row['section_title'] = 'product';
                    return view('admin.action-buttons', $row);
                })
                ->rawColumns(['product_name', 'quantity'])
                ->make(true);
        }
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $data['menu'] = 'Orders';
        $data['users'] = User::where('status', 'active')->where('role', 'user')->get();
        $data['products'] = Products::where('status', 'active')->get();
        return view("admin.order.create",$data);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(OrderRequest $request)
    {
        $input = $request->all();
        $order_products = Cart::with('product')->where('csrf_token',csrf_token())->get();
        if(!empty($order_products)){
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
            $order->save();

            // clear cart
            Cart::with('csrf_token',csrf_token())->delete();

            \Session::flash('success','Order has been updated successfully!');
            return redirect()->route('orders.index');
            
        } else {
            \Session::flash('success', 'Please add Product.');
            return redirect()->route('orders.create');
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        $data['menu'] = 'Orders';
        $data['order'] = Order::where('id',$id)->first();
        return view('admin.order.edit',$data);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $id)
    { 
        $data['status'] = 0;
        $order = Order::findOrFail($id);
        $input = $request->all();
        
        if (!empty($order)) {
            $order->update(['status' => $request->status]);
            $data['status'] = 1;
        }

        return $data;
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $order = Order::findOrFail($id);
        if(!empty($order)){
            $order->delete();
            return 1;
        }else{
            return 0;
        }
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

        $cart = Cart::where('csrf_token',csrf_token())->where('user_id', 0)->where('added_by_admin', 1)->where('product_id', $input['product_id'])->where('options', json_encode($input['options']))->first();

        if(empty($cart)){
            $input['added_by_admin'] = 1;
            $input['options'] = json_encode($input['options']);
            $input['csrf_token'] = $input['_token'];
            Cart::create($input);
        } else{
            $cart['quantity'] = ($cart['quantity']+$input['quantity']);
            $cart->save();
        }

        return $cart;
    }

    public function getAddressesByUser($userId)
    {   
        $user = User::with('user_addresses')->where('id', $userId)->first();
        $addresses = $user->user_addresses;
        return response()->json($addresses);
    }

    public function deleteCart(Request $request, $id)
    {
        $cart = Cart::find($id);

        if ($cart) {
            $cart->delete();
            return 1;
        } else {
            return 0;
        }
    }

    public function updateQty(Request $request)
    {
        $input = $request->all();
        $cart = Cart::find($input['id']);
        $cart['quantity'] = ($input['type']==1) ? ($cart['quantity']-1) : ($cart['quantity']+1);
        $cart->save();
        
        return 1;
    }

    public function updateOrderStatus(Request $request)
    { 
        $data['status'] = 0;
        $order = Order::findOrFail($request->id);
        $input = $request->all();
        
        if (!empty($order)) {
            $order->update(['status' => $request->status]);
            $data['status'] = 1;
        }

        return $data;
    }
} 
