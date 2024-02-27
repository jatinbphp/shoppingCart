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
        if ($request->ajax()) {

            $dateRange = $request->input('daterange');
            $dateStart = null;
            $dateEnd = null;
            if (!empty($dateRange) && strpos($dateRange, ' - ') !== false) {
                [$dateStart, $dateEnd] = explode(' - ', $dateRange);
            }
            $usersWithOrdersAndProducts = User::where('role', 'user')->whereHas('orders')
            ->when($request->input('user_id'), function ($query, $userId) {
              return $query->where('id', $userId);
          })
          ->whereHas('orders', function ($query) use ($request, $dateStart, $dateEnd) {
              if ($request->input('status')) {
                  $query->where('status', $request->input('status'));
              }
              if (!is_null($dateStart)) {
                  $query->whereDate('created_at', '>=', $dateStart);
              }
              if (!is_null($dateEnd)) {
                  $query->whereDate('created_at', '<=', $dateEnd);
              }
          })
          ->withCount([
              'orders' => function ($query) use ($request, $dateStart, $dateEnd) {
                  if ($request->input('status')) {
                      $query->where('status', $request->input('status'));
                  }
                  if (!is_null($dateStart)) {
                      $query->whereDate('created_at', '>=', $dateStart);
                  }
                  if (!is_null($dateEnd)) {
                      $query->whereDate('created_at', '<=', $dateEnd);
                  }
              },
              'orderItems' => function ($query) use ($request, $dateStart, $dateEnd) {
                  if ($request->input('status')) {
                      $query->where('status', $request->input('status'));
                  }
                  if (!is_null($dateStart)) {
                      $query->whereHas('order', function ($query) use ($dateStart) {
                          $query->whereDate('created_at', '>=', $dateStart);
                      });
                  }
                  if (!is_null($dateEnd)) {
                      $query->whereHas('order', function ($query) use ($dateEnd) {
                          $query->whereDate('created_at', '<=', $dateEnd);
                      });
                  }
              },
              'orders as total_amount_sum' => function ($query) use ($request, $dateStart, $dateEnd) {
                  if ($request->input('status')) {
                      $query->where('status', $request->input('status'));
                  }
                  if (!is_null($dateStart)) {
                      $query->whereDate('created_at', '>=', $dateStart);
                  }
                  if (!is_null($dateEnd)) {
                      $query->whereDate('created_at', '<=', $dateEnd);
                  }
                  $query->select(DB::raw('coalesce(sum(total_amount), 0) as total_amount_sum'));
              }
          ]);

            return Datatables::of($usersWithOrdersAndProducts)
                ->addIndexColumn()
                ->editColumn('orders_count', function($row) {
                    return $row->orders_count;
                })
                ->editColumn('order_items_count', function($row) {
                    return $row->order_items_count;
                })
                ->editColumn('total_amount_sum', function($row) {
                    return env('CURRENCY').number_format($row->total_amount_sum, 2);
                })
                ->make(true);
        }

         $data['users']=  User::where('role','user')->pluck('name', 'id');
         $data['status'] = Order::$allStatus;

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
        ->when($request->input('status') && $request->input('daterange'), function ($query) use ($request) {
            $query->where('orders.status', $request->input('status'))
                  ->whereBetween('orders.created_at', [
                      date('Y-m-d 00:00:00', strtotime(explode('-', $request->input('daterange'))[0])),
                      date('Y-m-d 23:59:59', strtotime(explode('-', $request->input('daterange'))[1]))
                  ]);
        })
        ->when($request->input('status') && !$request->input('daterange'), function ($query) use ($request) {
            $query->where('orders.status', $request->input('status'));
        })
        ->when(!$request->input('status') && $request->input('daterange'), function ($query) use ($request) {
            $dates = explode("-", $request->input('daterange'));
            if (count($dates) == 2) {
                $start_date = date('Y-m-d', strtotime(trim($dates[0])));
                $end_date = date('Y-m-d', strtotime(trim($dates[1])));
                $query->whereDate('orders.created_at', '>=', $start_date)
                      ->whereDate('orders.created_at', '<=', $end_date);
            }
        })
        ->when($request->input('product_id'), function ($query, $product_id) {
            $query->where('products.id', $product_id);
        })
        ->groupBy('products.id')
        ->withCount([
            'orderItems',
            'orderItems as product_price_sum' => function ($query) use ($request) {
                $query->select(DB::raw('coalesce(sum(sub_total), 0) as product_price_sum'))
                    ->join('orders', 'orders.id', '=', 'order_items.order_id')
                    ->when($request->input('status') && $request->input('daterange'), function ($query) use ($request) {
                        $query->where('orders.status', $request->input('status'))
                              ->whereBetween('orders.created_at', [
                                  date('Y-m-d 00:00:00', strtotime(explode('-', $request->input('daterange'))[0])),
                                  date('Y-m-d 23:59:59', strtotime(explode('-', $request->input('daterange'))[1]))
                              ]);
                    })
                    ->when($request->input('status') && !$request->input('daterange'), function ($query) use ($request) {
                        $query->where('orders.status', $request->input('status'));
                    })
                    ->when(!$request->input('status') && $request->input('daterange'), function ($query) use ($request) {
                        $dates = explode("-", $request->input('daterange'));
                        if (count($dates) == 2) {
                            $start_date = date('Y-m-d', strtotime(trim($dates[0])));
                            $end_date = date('Y-m-d', strtotime(trim($dates[1])));
                            $query->whereDate('orders.created_at', '>=', $start_date)
                                  ->whereDate('orders.created_at', '<=', $end_date);
                        }
                    });
            },
            'orderItems as product_qty_sum' => function ($query) use ($request) {
                $query->select(DB::raw('coalesce(sum(product_qty), 0) as product_qty_sum'))
                    ->join('orders', 'orders.id', '=', 'order_items.order_id')
                    ->when($request->input('status') && $request->input('daterange'), function ($query) use ($request) {
                        $query->where('orders.status', $request->input('status'))
                              ->whereBetween('orders.created_at', [
                                  date('Y-m-d 00:00:00', strtotime(explode('-', $request->input('daterange'))[0])),
                                  date('Y-m-d 23:59:59', strtotime(explode('-', $request->input('daterange'))[1]))
                              ]);
                    })
                    ->when($request->input('status') && !$request->input('daterange'), function ($query) use ($request) {
                        $query->where('orders.status', $request->input('status'));
                    })
                    ->when(!$request->input('status') && $request->input('daterange'), function ($query) use ($request) {
                        $dates = explode("-", $request->input('daterange'));
                        if (count($dates) == 2) {
                            $start_date = date('Y-m-d', strtotime(trim($dates[0])));
                            $end_date = date('Y-m-d', strtotime(trim($dates[1])));
                            $query->whereDate('orders.created_at', '>=', $start_date)
                                  ->whereDate('orders.created_at', '<=', $end_date);
                        }
                    });
            }
        ]);

        if ($request->ajax()) {
            return Datatables::of($collection)
                ->addIndexColumn()
                ->editColumn('price', function($row) {
                    return env('CURRENCY').number_format($row->price, 2);
                })
                ->editColumn('product_price_sum', function($row) {
                    return env('CURRENCY').number_format($row->product_price_sum, 2);
                })
                ->editColumn('product_qty_sum', function($row) {
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
            ->groupBy(DB::raw('DATE(orders.created_at)'));

            return DataTables::of($collection)
                ->editColumn('total_order_items', function($row) {
                    return $row->total_order_items;
                })
                ->editColumn('total_amount', function($row) {
                    return env('CURRENCY') . number_format($row->total_amount, 2);
                })
                ->make(true);
        }

        return view('admin.reports.index_sales', $data);
    }
}
