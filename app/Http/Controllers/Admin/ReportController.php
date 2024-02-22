<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use DataTables;
use App\Models\User;
use App\Models\Products;
use App\Models\Order;
use Illuminate\Support\Facades\DB;

class ReportController extends Controller
{
    public function index_user_orders(Request $request)
    {
        $data['menu'] = 'User Orders Report';
        
        if($request->ajax()) {
            $collection = User::where('role', 'user')->whereHas('orders')
                ->withCount([
                    'orders',
                    'orderItems',
                    'orders as total_amount_sum' => function ($query) {
                        $query->select(DB::raw('coalesce(sum(total_amount), 0) as total_amount_sum'));
                    }
                ])
                ->when($request->input('status'), function ($query, $status) {
                    return $query->whereHas('orders', function ($subquery) use ($status) {
                        $subquery->where('status', $status);
                    });
                })
                ->when($request->input('user_id'), function ($query, $user_id) {
                    return $query->whereHas('orders', function ($subquery) use ($user_id) {
                        $subquery->where('user_id', $user_id);
                    });
                })
                ->when($request->input('daterange'), function ($query, $daterange) {
                    $start_date = explode("-", $daterange)[0];
                    $end_date = explode("-", $daterange)[1];
                    return $query->whereHas('orders', function ($subquery) use ($start_date, $end_date) {
                        $subquery->whereDate('created_at', '>=', $start_date)
                                 ->whereDate('created_at', '<=', $end_date);
                    });
                });


            return Datatables::of($collection)
                ->addIndexColumn()
                ->addColumn('total_orders', function($row) {
                    return $row->orders_count;
                })
                ->addColumn('total_order_items', function($row) {
                    return $row->order_items_count;
                })
                ->addColumn('total_amount_sum', function($row) {
                    return env('CURRENCY').number_format($row->total_amount_sum, 2);
                })                
                ->make(true);
        }

        $data['users'] = User::where('role', 'user')->where('status', 'active')->pluck('name', 'id');

        return view('admin.reports.index_user_orders', $data);
    }

    public function index_purchase_product(Request $request)
    {
        $data['menu'] = 'Products Purchased Report';

        $collection = Products::join('order_items', 'products.id', '=', 'order_items.product_id')
                        ->join('orders', 'orders.id', '=', 'order_items.order_id')
                        ->select(
                            'products.*',
                            DB::raw('SUM(order_items.product_qty) as total_quantity'),
                            DB::raw('SUM(order_items.sub_total) as total_amount')
                        )
                        ->when($request->input('status'), function ($query, $status) {
                            $query->where('orders.status', $status);
                        })
                        ->when($request->input('product_id'), function ($query, $product_id) {
                            $query->where('products.id', $product_id);
                        })
                        ->when($request->input('daterange'), function ($query, $daterange) {
                            $dates = explode("-", $daterange);
                            if (count($dates) == 2) {
                                $start_date = date('Y-m-d', strtotime(trim($dates[0])));
                                $end_date = date('Y-m-d', strtotime(trim($dates[1])));
                                $query->whereDate('orders.created_at', '>=', $start_date)
                                    ->whereDate('orders.created_at', '<=', $end_date);
                            }
                        })
                        ->groupBy('products.id')
                        ->withCount([
                            'orderItems',
                            'orderItems as product_price_sum' => function ($query) {
                                $query->select(DB::raw('coalesce(sum(sub_total), 0) as product_price_sum'));
                            },
                            'orderItems as product_qty_sum' => function ($query) {
                                $query->select(DB::raw('coalesce(sum(product_qty), 0) as product_qty_sum'));
                            }
                        ]);

        if ($request->ajax()) {
            return Datatables::of($collection)
                ->addIndexColumn()
                ->editColumn('price', function($row) {
                    return env('CURRENCY').number_format($row->price, 2);
                })
                ->addColumn('product_price_sum', function($row) {
                    return env('CURRENCY').number_format($row->product_price_sum, 2);
                })
                ->addColumn('product_qty_sum', function($row) {
                    return $row->product_qty_sum;
                })
                ->make(true);
        }

        $data['products'] = Products::where('status', 'active')->pluck('product_name', 'id');

        return view('admin.reports.index_purchase_products', $data);
    }

    public function index_sales(Request $request)
    {
        $data['menu'] = 'Sales Report';

        if ($request->ajax()) {

            $collection = Order::select([
                DB::raw('DATE(orders.created_at) as created_date'),
                DB::raw('COUNT(DISTINCT orders.id) as total_orders'),
                DB::raw('SUM(orders.total_amount) as total_amount'),
                DB::raw('SUM(order_items.product_qty) as total_order_items')
            ])
            ->leftJoin('order_items', 'orders.id', '=', 'order_items.order_id')
            ->when($request->input('status'), function ($query, $status) {
                $query->where('status', $status);
            })
            ->when($request->input('daterange'), function ($query, $daterange) {
                $dates = explode("-", $daterange);
                if (count($dates) == 2) {
                    $start_date = date('Y-m-d', strtotime(trim($dates[0])));
                    $end_date = date('Y-m-d', strtotime(trim($dates[1])));
                    $query->whereDate('order_items.created_at', '>=', $start_date)
                        ->whereDate('order_items.created_at', '<=', $end_date);
                }
            })
            ->groupBy(DB::raw('DATE(orders.created_at)'))
            ->orderBy('created_date', 'DESC');

            return DataTables::of($collection)
                ->addColumn('total_order_items', function($row) {
                    return $row->total_order_items;
                })
                ->addColumn('total_amount', function($row) {
                    return env('CURRENCY') . number_format($row->total_amount, 2);
                })
                ->make(true);
        }

        return view('admin.reports.index_sales', $data);
    }
}
