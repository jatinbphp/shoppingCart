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
                ->editColumn('total_amount', function($order) {
                    return env('CURRENCY').number_format($order->total_amount, 2);
                })
                ->editColumn('created_at', function($row){
                    return $row['created_at']->format('Y-m-d h:i:s');
                })
                ->editColumn('status', function($row){
                    $select = '<select class="form-control select2 orderStatus" id="status'.$row->unique_id.'"  data-id="'.$row->id.'" >';
                        foreach(Order::$allStatus as $status){
                            $selected = ($status == $row->status) ? ' selected="selected"' : '';
                            $select .= '<option '.$selected.' value="'.$status.'">'.ucfirst($status).'</option>';
                        }
                    $select .= '</select>';
                    return $select;
                })
                ->addColumn('action', function($row){
                    $row['section_name'] = 'orders';
                    $row['section_title'] = 'order';
                    return view('admin.action-buttons', $row);
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

                            $product_name .= '</br><small><b>'.$product_option->option_name.' :</b> '.$product_option_value->option_value.' <a class="editOption" href="javascript:void(0)" data-option_id="'.$keyO.'" data-option_value_id="'.$valueO.'" data-product_id="'.$order->product->id.'" data-id="'.$order->id.'" data-type="add"/>Edit</a></small>';
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
                    $quantity .= '<button type="button" id="minus" data-id="'.$row->id.'" data-action="add"><i class="fa fa-minus" aria-hidden="true"></i></button>';
                    $quantity .= '<input type="text" id="quantity'.$row->id.'" value="'.$row->quantity.'">';
                    $quantity .= '<button type="button" id="plus" data-id="'.$row->id.'" data-action="add"><i class="fa fa-plus" aria-hidden="true"></i></button>';
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

    public function index_order_product(Request $request)
    {
        $data['menu'] = 'Orders';
        if ($request->ajax()) {
            return DataTables::of(OrderItem::select()->with('product')->where('order_id',3000)->get())
                ->addColumn('product_name', function($order) {

                    $product_name = $order->product_name; 

                    $options = OrderOption::where('order_id',$order->order_id)->where('order_product_id',$order->id)->get();
                    if(!empty($options)){
                        foreach ($options as $keyO => $valueO) {

                            $product_option = ProductsOptions::where('id',$valueO->product_option_id)->first();
                            $product_option_value = ProductsOptionsValues::where('id', $valueO->product_option_value_id)->first();

                            $product_name .= '</br><small><b>'.$product_option->option_name.' :</b> '.$product_option_value->option_value.' <a class="editOption" href="javascript:void(0)" data-option_id="'.$valueO->product_option_id.'" data-option_value_id="'.$valueO->product_option_value_id.'" data-product_id="'.$order->product->id.'" data-id="'.$valueO->id.'"  data-type="edit"/>Edit</a></small>';
                        }
                    }

                    return $product_name;
                })
                ->addColumn('sku', function($order) {
                    //return $order->product->sku; 
                    return $order->product_sku;
                })
                ->addColumn('unit_price', function($order) {
                    //return env('CURRENCY').number_format($order->product->price, 2);
                    return env('CURRENCY').number_format($order->product_price, 2);
                })
                ->addColumn('total', function($order) {
                    //return env('CURRENCY').number_format(($order->quantity*$order->product->price), 2);
                    return env('CURRENCY').number_format(($order->product_qty*$order->product_price), 2);
                })
                ->addColumn('quantity', function($row){
                    $quantity = '<div class="qty">';
                    $quantity .= '<button type="button" id="minus" data-id="'.$row->id.'" data-action="edit"><i class="fa fa-minus" aria-hidden="true"></i></button>';
                    $quantity .= '<input type="text" id="quantity'.$row->id.'" value="'.$row->product_qty.'">';
                    $quantity .= '<button type="button" id="plus" data-id="'.$row->id.'" data-action="edit"><i class="fa fa-plus" aria-hidden="true"></i></button>';
                    $quantity .= '</div>';
                    return $quantity;
                })
                ->addColumn('action', function($row){
                    $row['section_name'] = 'order_products';
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
        $data['users'] = User::where('status', 'active')->where('role', 'user')->pluck('name', 'id')->prepend('Please Select', '');
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
        $data['order'] = Order::find($id);
        return view('admin.order.show_modal', $data);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        $data['menu'] = 'Orders';
        $data['users'] = User::where('status', 'active')->where('role', 'user')->pluck('name', 'id')->prepend('Please Select', '');
        $data['products'] = Products::where('status', 'active')->get();
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

        if($input['order_id']==0){
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
        } else {
            $order = Order::find($input['order_id']);
            $product = Products::find($input['product_id']);

            $inputOrderItem = [
                'order_id' => $input['order_id'],
                'product_id' => $input['product_id'],
                'product_name' => $product->product_name,
                'product_sku' => $product->sku,
                'product_price' => $product->price,
                'product_qty' => $input['quantity'],
                'sub_total' => ($product->price*$input['quantity']),
            ];
            $OrderItem = OrderItem::create($inputOrderItem);

            $sumOfSubTotal = OrderItem::where('order_id', $input['order_id'])->sum('sub_total');            
            $order->total_amount = $sumOfSubTotal;
            $order->save(); // Save changes

            if(!empty($input['options'])){
                foreach ($input['options'] as $key => $value) {

                    $product_option = ProductsOptions::where('id',$key)->first();
                    $product_option_value = ProductsOptionsValues::where('id', $value)->first();

                    $inputOrderOption = [
                        'order_id' => $input['order_id'],
                        'order_product_id' => $OrderItem->id,
                        'product_option_id' => $key,
                        'product_option_value_id' => $value,
                        'name' => $product_option->option_name,
                        'value' => $product_option_value->option_value,
                        'price' => $product_option_value->option_price,
                    ];

                    OrderOption::create($inputOrderOption);
                }
            }
        }

        return 1;
    }

    public function getAddressesByUser($userId)
    {   
        $user = User::with('user_addresses')->where('id', $userId)->first();
        $addresses = $user->user_addresses;
        return response()->json($addresses);
    }

    public function deleteCart(Request $request, $id, $type)
    {
        // Check the type to determine the model to use
        if ($type == 'cart') {
            $cart = Cart::find($id);    
        } else {
            $cart = OrderItem::find($id);
        }

        // If the cart item exists, delete it and return success
        if ($cart) {
            $cart->delete();

            if ($type != 'cart') {
                $sumOfSubTotal = OrderItem::where('order_id', $cart->order_id)->sum('sub_total');
                //$sumOfSubTotal = OrderItem::where('order_id', $cart->order_id)->selectRaw('SUM(sub_total * product_qty) as total')->first()->total;

                $order = Order::find($cart->order_id);
                $order->total_amount = $sumOfSubTotal;
                $order->save(); // Save changes
            }

            return response()->json(['status' => 'success']);
        } else {
            // If the cart item does not exist, return failure
            return response()->json(['status' => 'error']);
        }
    }

    public function updateQty(Request $request)
    {
        $input = $request->all();
        if($input['action']=='add'){
            $cart = Cart::find($input['id']);

            if ($cart) {
                $quantityChange = ($input['type'] == 1) ? -1 : 1; // Determine quantity change based on type
                $cart->quantity += $quantityChange; // Update cart quantity
                $cart->save(); // Save changes
            }

        } else {
            $orderitem = OrderItem::find($input['id']);

            if ($orderitem) {
                $quantityChange = ($input['type'] == 1) ? -1 : 1; // Determine quantity change based on type
                $orderitem->product_qty += $quantityChange; // Update product quantity

                // Update product price based on quantity change
                $orderitem->sub_total = $orderitem->product_price*$orderitem->product_qty;
                $orderitem->save(); // Save changes

                $sumOfSubTotal = OrderItem::where('order_id', $orderitem->order_id)->sum('sub_total');
                //$sumOfSubTotal = OrderItem::where('order_id', $orderitem->order_id)->selectRaw('SUM(sub_total * product_qty) as total')->first()->total;
                $order = Order::find($orderitem->order_id);
                $order->total_amount = $sumOfSubTotal;
                $order->save(); // Save changes
            }
        }
        
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

    public function editProductOptionToCart(Request $request)
    {
        $this->validate($request, [
            'cart_id' => 'required',
            'option_id' =>'required|numeric',
            'options' => 'required|array',
            'options.*' => 'array', // Ensure each option is an array
            'options.*' => 'numeric' // Ensure each option value is numeric
        ]);

        $input = $request->all();

        if($input['type']=='add'){

            $cart = Cart::find($input['cart_id']);

            if(!empty($cart)){

                $optionsArray = [];
                if(!empty($cart['options'])){
                     $optionsArray = json_decode($cart['options'], true);
                     $optionsArray[$input['option_id']] = $input['options'][$input['option_id']];
                }

                $cart['options'] = json_encode($optionsArray);

                $checkCart = Cart::where('csrf_token',csrf_token())->where('user_id', 0)->where('added_by_admin', 1)->where('product_id', $cart['product_id'])->where('options', json_encode($input['options']))->where('id', '!=', $input['cart_id'])->first();

                if(empty($checkCart)){
                    $cart->save();
                } else {
                    $cart['quantity'] += $checkCart['quantity'];
                    $cart->save();
                    $checkCart->delete();
                }
            }
        } else {

            $option = OrderOption::where('id',$input['cart_id'])->first();
            if(!empty($option)){

                $checkOrderOption = OrderOption::where('id', '!=',$input['cart_id'])->where('product_option_id',$input['option_id'])->where('product_option_value_id',$input['options'][$input['option_id']])->first();

                $product_option = ProductsOptions::where('id',$input['option_id'])->first();
                $product_option_value = ProductsOptionsValues::where('id', $input['options'][$input['option_id']])->first();

                $option['product_option_value_id'] = $input['options'][$input['option_id']];
                $option['name'] = $product_option['option_name'];
                $option['value'] = $product_option_value['option_value'];
                $option['price'] = $product_option_value['option_price'];

                if(empty($checkOrderOption)){
                    $option->save();
                } else {
                    $OrderItem = OrderItem::find($option['order_product_id']);
                    $checkOrderOptionItem = OrderItem::where('id',$checkOrderOption['order_product_id'])->first();

                    if(!empty($checkOrderOptionItem)){
                        $checkOrderOptionItem['product_qty'] = ($OrderItem['product_qty']+$checkOrderOptionItem['product_qty']);
                        $checkOrderOptionItem['sub_total'] = ($checkOrderOptionItem['product_price']*$checkOrderOptionItem['product_qty']);
                        $checkOrderOptionItem->save();
                    }
                    
                    $OrderItem->delete();
                    $option->delete();

                    $sumOfSubTotal = OrderItem::where('order_id', $option->order_id)->sum('sub_total');
                    $order = Order::find($option->order_id);
                    $order->total_amount = $sumOfSubTotal;
                    $order->save(); // Save changes
                }
                
            }
        }
        return 1;
    }
} 
