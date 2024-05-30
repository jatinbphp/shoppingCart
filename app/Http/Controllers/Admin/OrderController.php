<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\OrderStockHistory;
use App\Models\ProductStock;
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
            return DataTables::of(Order::with('user'))
                ->addColumn('order_id', function($order) {
                    return env('ORDER_PREFIX').'-'.date("Y", strtotime($order->created_at)).'-'.$order->id;
                })
                ->addColumn('user_name', function($order) {

                    $userName = $order->user->name .'('.$order->user->email.') </br>';

                    if(isset($order->user->deleted_at)){
                        $userName .= '<small class="text-danger">User Deleted</small>';
                    }

                    return $userName;
                })
                ->editColumn('total_amount', function($order) {
                    return env('CURRENCY').number_format($order->total_amount, 2);
                })
                ->editColumn('created_at', function($row){
                    return $row['created_at']->format('Y-m-d h:i:s');
                })
                ->editColumn('status', function($row){

                    return view('admin.common.order-status-dropdown', ['order' => $row]);

                })
                ->addColumn('action', function($row){
                    $row['section_name'] = 'orders';
                    $row['section_title'] = 'order';
                    return view('admin.common.action-buttons', $row);
                })
                ->rawColumns(['status', 'user_name'])
                ->make(true);
        }

        Cart::where('csrf_token',csrf_token())->where('order_id',0)->delete();

        return view('admin.order.index', $data);
    }

    public function index_product(Request $request)
    {
        $data['menu'] = 'Orders';

        if(isset($request->order_id) && $request->order_id>0){

            if($request->first_time_load==0){
                Cart::where('order_id',$request->order_id)->delete();

                $OrderItems = OrderItem::where('order_id', $request->order_id)->get();

                if(!empty($OrderItems)){
                    foreach ($OrderItems as $key => $value) {

                        $optionsArray = OrderOption::where('order_product_id',$value->id)->orderBy('id', 'ASC')->get();

                        $options = [];
                        $options_text = [];
                        if(!empty($optionsArray)){
                            foreach ($optionsArray as $keyOption => $valueOption) {
                                $options[$valueOption->product_option_id] = "$valueOption->product_option_value_id";
                                $options_text[$valueOption->name] = "$valueOption->value";
                            }
                        }

                        $cartItems = [
                            'order_id' => $request->order_id,
                            'added_by_admin' => 1,
                            'product_id' => $value->product_id,
                            'quantity' => $value->product_qty,
                            'main_quantity' => $value->product_qty,
                            'options' => json_encode($options),
                            'options_text' => json_encode($options_text),
                            'csrf_token' => csrf_token()
                        ];
                        Cart::create($cartItems);
                    }
                }
            }

            $table_data = Cart::with('product', 'product.product_image')->where('order_id',$request->order_id);
        } else {
            $table_data = Cart::with('product', 'product.product_image')->where('order_id',0)->where('csrf_token',csrf_token());
        }

        if ($request->ajax()) {

            return DataTables::of($table_data)
                ->addColumn('product_name', function($order) {
                    return view('admin.order.product-info', $order);
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
                    $quantity .= '<button class="btn-sm btn-danger" type="button" id="minus" data-id="'.$row->id.'"><i class="fa fa-minus" aria-hidden="true"></i></button>';
                    $quantity .= '<input type="text" id="quantity'.$row->id.'" value="'.$row->quantity.'">';
                    $quantity .= '<button class="btn-sm btn-info" type="button" id="plus" data-id="'.$row->id.'"><i class="fa fa-plus" aria-hidden="true"></i></button>';
                    $quantity .= '</div>';
                    return $quantity;
                })
                ->addColumn('action', function($row){
                    $row['section_name'] = 'cart_products';
                    $row['section_title'] = 'product';
                    return view('admin.common.action-buttons', $row);
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

        $data['users'] = User::where('status', 'active')->where('role', 'user')->orderBy('name', 'ASC')->get()->pluck('full_name', 'id');
        $data['products'] = Products::where('status', 'active')->orderBy('product_name', 'ASC')->get()->pluck('full_name', 'id');

        return view("admin.order.create",$data);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(OrderRequest $request)
    {
        $input = $request->all();
        $order_products = Cart::with('product')->where('csrf_token',csrf_token())->where('order_id',0)->get();
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
                Cart::where('csrf_token',csrf_token())->where('order_id',0)->delete();
                return redirect()->route('orders.index');
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
                }
                //OrderOption
            }

            //update total in order table
            $address = UserAddresses::findOrFail($input['address_id']);
            $order['address_info'] = json_encode($address);
            $order['total_amount'] = $orderTotal;
            $order->save();

            // clear cart
            Cart::where('csrf_token',csrf_token())->where('order_id',0)->delete();

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
        $data['order'] = Order::whereIn('status', ['pending', 'shipped'])->findorFail($id);
        $data['users'] = User::where('status', 'active')->where('role', 'user')->orderBy('name', 'ASC')->get()->pluck('full_name', 'id');
        $data['products'] = Products::where('status', 'active')->orderBy('product_name', 'ASC')->get()->pluck('full_name', 'id');
        return view('admin.order.edit',$data);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request)
    {
        $input = $request->all();

        $order = Order::with('orderItems','orderItems.orderOptions')->find($input['order_id']);

        if ($order) {
            /*Update Stock When Order Edit*/
            if(count($order['orderItems']) > 0){
                foreach ($order['orderItems'] as $oItem){
                    if(count($oItem['orderOptions']) > 0){
                        $oIds = [$oItem['orderOptions'][0]['product_option_value_id'], $oItem['orderOptions'][1]['product_option_value_id']];
                        /*Stock Update During Order Edit*/
                        $this->checkStock($oItem->product_id,$oIds,0, $order->id, $oItem->product_qty, 1, 1);
                    }
                }
            }
        }

        $order_products = Cart::with('product')->where('csrf_token',csrf_token())->where('order_id',$input['order_id'])->get();
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
                Cart::where('csrf_token',csrf_token())->where('order_id',0)->delete();
                return redirect()->route('orders.index');
            }

            OrderItem::where('order_id',$input['order_id'])->delete();
            OrderOption::where('order_id',$input['order_id'])->delete();

            //$order = Order::find($input['order_id']);

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
                }
                    //OrderOption
            }

            //update total in order table
            $address = UserAddresses::findOrFail($input['address_id']);
            $order['address_info'] = json_encode($address);
            $order['total_amount'] = $orderTotal;
            $order->update($input);

            // clear cart
            Cart::where('csrf_token',csrf_token())->where('order_id',$input['order_id'])->delete();

            \Session::flash('success','Order has been updated successfully!');
            return redirect()->route('orders.index');
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $order = Order::findOrFail($id);

        /*Update Stock When Order Delete*/
        if(count($order['orderItems']) > 0){
            foreach ($order['orderItems'] as $oItem){
                if(count($oItem['orderOptions']) > 0){
                    $oIds = [$oItem['orderOptions'][0]['product_option_value_id'], $oItem['orderOptions'][1]['product_option_value_id']];
                    /*Stock Update During Order*/
                    $this->checkStock($oItem->product_id,$oIds,0, $order->id, $oItem->product_qty, 1);
                }
            }
        }

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
        $data = ['status' => 0];
        $remaining_qty = 0;

        $cart = Cart::where('csrf_token',csrf_token())->where('order_id', $input['order_id'])->where('user_id', 0)->where('added_by_admin', 1)->where('product_id', $input['product_id'])->where('options', json_encode($input['options']))->first();

        if(empty($cart)){

            $oIds = !empty($input['options']) ? array_values($input['options']) : [];
            $stock = $this->checkStock($input['product_id'], $oIds, 1);

            if (!empty($stock) && $stock['remaining_qty'] > 0) {
                $remaining_qty = $stock['remaining_qty'];

                if ($stock['remaining_qty'] >= $input['quantity']) {

                    $input['added_by_admin'] = 1;
                    $input['options'] = json_encode($input['options']);
                    $input['csrf_token'] = $input['_token'];
                    Cart::create($input);

                    $data['status'] = 1;
                    $data['message'] = 'Your product was added to cart successfully!';

                } else {
                    $data['message'] = 'We apologize, but it seems you\'ve already added the maximum quantity of this product to your cart. We currently have '.$remaining_qty.' quantity left in stock.';
                }
            } else {
                $data['message'] = 'We apologize, but it seems you\'ve already added the maximum quantity of this product to your cart. We currently have '.$remaining_qty.' quantity left in stock.';
            }
        } else{
            $cartOptions = !empty($cart->options) ? json_decode($cart->options, true) : [];
            $oIds = !empty($cartOptions) ? array_values($cartOptions) : [];
            $stock = $this->checkStock($cart->product_id, $oIds, 1);

            if (!empty($stock) && $stock['remaining_qty'] > 0) {
                

                if(!empty($input['order_id'])){
                    $newQty = ($cart->quantity + $input['quantity'])-$cart->main_quantity;
                    $newUQty = $cart->quantity + $input['quantity'];
                    $remaining_qty = ($stock['remaining_qty']-($cart->quantity-$cart->main_quantity));

                    if ($stock['remaining_qty'] >= $newQty) {
                        $cart['quantity'] = $newUQty;
                        $cart->save();

                        $data['status'] = 1;
                        $data['message'] = 'Your product was added to cart successfully!';
                    } else {
                        $data['message'] = 'We apologize, but it seems you\'ve already added the maximum quantity of this product to your cart. We currently have '.$remaining_qty.' quantity left in stock.';
                    }
                } else {

                    $newQty = $cart->quantity + $input['quantity'];
                    $remaining_qty = $stock['remaining_qty'];

                    if ($stock['remaining_qty'] >= $newQty) {
                        $cart['quantity'] = $newQty;
                        $cart->save();

                        $data['status'] = 1;
                        $data['message'] = 'Your product was added to cart successfully!';
                    } else {
                        $data['message'] = 'We apologize, but it seems you\'ve already added the maximum quantity of this product to your cart. We currently have '.$remaining_qty.' quantity left in stock.';
                    }
                }
            } else {
                $data['message'] = 'We apologize, but it seems you\'ve already added the maximum quantity of this product to your cart. We currently have '.$remaining_qty.' quantity left in stock.';
            }
        }

        return $data;
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
            return response()->json(['status' => 'success']);
        } else {
            // If the cart item does not exist, return failure
            return response()->json(['status' => 'error']);
        }
    }

    public function updateQty(Request $request)
    {
        $input = $request->all();
        $cart = Cart::find($input['id']);

        if ($cart) {
            $quantityChange = ($input['type'] == 1) ? -1 : 1; // Determine quantity change based on type
            $cart->quantity += $quantityChange; // Update cart quantity
            $cart->save(); // Save changes
        }

        return 1;
    }

    public function updateOrderStatus(Request $request)
    {
        $order = Order::with('orderItems','orderItems.orderOptions')->find($request->id);

        if ($order) {
            $order->update(['status' => $request->status]);

            /*Update Stock When Order Cancelled*/
            if($request->status == 'cancelled'){
                if(count($order['orderItems']) > 0){
                    foreach ($order['orderItems'] as $oItem){
                        if(count($oItem['orderOptions']) > 0){
                            $oIds = [$oItem['orderOptions'][0]['product_option_value_id'], $oItem['orderOptions'][1]['product_option_value_id']];
                            /*Stock Update During Order*/
                            $this->checkStock($oItem->product_id,$oIds,0, $order->id, $oItem->product_qty, 1);
                        }
                    }
                }
            }

            //send order
            $data['order'] = Order::with('orderItems.product.product_image')->find($request->id);
            $data['user'] = User::with('user_addresses')->where('id', $order->user_id)->first();

            $to = env('MAIL_FROM_ADDRESS');
            $subject = 'Update Your Order status: #' . 'INV-'. date('Y', strtotime($data['order']->created_at)) . '-' . $data['order']->id;

            // For customer confirmation
            $data['recipient'] = 'customer';
            $data['update_status'] = 1;
            $customerMessage = view('mail-templates.orders.order-placed', $data)->render();

            $headers = [
                'MIME-Version: 1.0',
                'Content-Type: text/html; charset=ISO-8859-1',
                'From: '.env('MAIL_FROM_ADDRESS'),
                'Reply-To: '.env('MAIL_FROM_ADDRESS')
            ];

            // Send email
            mail($data['user']['email'], $subject, $customerMessage, implode("\r\n", $headers)); //for customers

            return true;
        }

        return false;
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

        return 1;
    }

    public function index_order_dashborad(Request $request)
    {
        if ($request->ajax()) {
            return DataTables::of(Order::with('user')->orderBy('id', 'DESC')->take(5))
                ->addColumn('order_id', function($order) {
                    return env('ORDER_PREFIX').'-'.date("Y", strtotime($order->created_at)).'-'.$order->id;
                })
                ->addColumn('user_name', function($order) {
                    $userName = $order->user->name .'('.$order->user->email.') </br>';

                    if(isset($order->user->deleted_at)){
                        $userName .= '<small class="text-danger">User Deleted</small>';
                    }

                    return $userName;
                })
                ->editColumn('total_amount', function($order) {
                    return env('CURRENCY').number_format($order->total_amount, 2);
                })
                ->editColumn('created_at', function($row){
                    return $row['created_at']->format('Y-m-d h:i:s');
                })
                ->editColumn('status', function($row){
                    $status = [
                        'pending' => '<span class="badge badge-primary">Pending</span>',
                        'shipped'  => '<span class="badge badge-warning">Shipped</span>',
                        'completed'=> '<span class="badge badge-success">Completed</span>',
                        'cancelled'  => '<span class="badge badge-danger">Cancelled</span>',
                    ];
                    return $status[$row->status] ?? null;
                })
                ->addColumn('action', function($row){
                    $row['order_dashboard'] = 1;
                    $row['section_name'] = 'orders';
                    $row['section_title'] = 'order';
                    return view('admin.common.action-buttons', $row);
                })
                ->rawColumns(['status', 'user_name'])
                ->make(true);
        }
    }

    public function exportOrders()
    {
        $orders = Order::with('user', 'orderItems')->orderBy('id', 'DESC')->get();

        if(empty($orders)){
            \Session::flash('danger','No orders found!');
            return redirect()->route('orders.index');
        }

        $headers = ['Order ID', 'Date Ordered', 'Customer Name', 'Products Information', 'Sub Total', 'Total', 'Address', 'Comments', 'Delivery Method', 'Status'];

        $exportData = [];
        foreach ($orders as $key => $order) {

            $productDetails = [];
            if(!empty($order->orderItems)){
                foreach ($order->orderItems as $keyI => $item) {
                    $productDetails[$keyI] = [
                        'Name' => $item->product_name,
                        'SKU' => $item->product_sku,
                        'PRICE' => $item->product_price,
                        'QTY' => $item->product_qty,
                        'SUB_TOTAL' => $item->sub_total,
                    ];

                    if(!empty($item->orderOptions)){
                        foreach ($item->orderOptions as $option){
                            $productDetails[$keyI][$option->name] = $option->value;
                        }
                    }
                }
            }

            $productInformations = json_encode($productDetails);

            $orderdata = [
                env('ORDER_PREFIX') . '-' . date("Y", strtotime($order->created_at)) . '-' . $order->id,
                $order->created_at,
                $order->user->name . ' (' . $order->user->email . ')',
                $productInformations, // JSON encoded products information
                '£' . number_format($order->total_amount, 2),
                '£' . number_format($order->total_amount, 2),
                'Address Placeholder', // Replace with actual address field
                $order->notes ?? '-',
                $order->delivey_method,
                ucfirst($order->status),
            ];

            $exportData[] = $orderdata;
        }

        // Create a temporary file to store CSV data
        $temp_file = tempnam(sys_get_temp_dir(), 'export_');
        $file = fopen($temp_file, 'w');

        // Write headers to CSV file
        fputcsv($file, $headers);

        // Write data to CSV file
        foreach ($exportData as $row) {
            fputcsv($file, $row);
        }

        // Close the file
        fclose($file);

        // Set headers for direct download
        header('Content-Description: File Transfer');
        header('Content-Type: text/csv');
        header('Content-Disposition: attachment; filename="exported_order_data.csv"');
        header('Expires: 0');
        header('Cache-Control: must-revalidate');
        header('Pragma: public');
        header('Content-Length: ' . filesize($temp_file));

        // Output file contents
        readfile($temp_file);

        // Delete temporary file
        unlink($temp_file);

        exit;
    }
}
