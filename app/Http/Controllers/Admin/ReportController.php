<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use DataTables;
use App\Models\User;
use App\Models\Products;
use Illuminate\Support\Facades\DB;

class ReportController extends Controller
{
    public function index_user_orders(Request $request)
    {
        $data['menu'] = 'User Orders Report';
        if ($request->ajax()) {

            $usersWithOrdersAndProducts = User::where('role', 'user')->whereHas('orders')
            ->withCount([
                'orders',
                'orderItems',
                'orders as total_amount_sum' => function ($query) {
                    $query->select(DB::raw('coalesce(sum(total_amount), 0) as total_amount_sum'));
                }
            ]);

            return Datatables::of($usersWithOrdersAndProducts)
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

        return view('admin.reports.index_user_orders', $data);
    }

    public function index_purchase_product(Request $request)
    {
        $data['menu'] = 'Products Purchased Report';

        $collection = Products::whereHas('orderItems')
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

        return view('admin.reports.index_purchase_products', $data);
    }
}
