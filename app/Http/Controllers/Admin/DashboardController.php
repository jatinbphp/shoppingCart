<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Products;
use App\Models\User;
use App\Models\Order;
use Illuminate\Http\Request;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;

class DashboardController extends Controller
{
    public function index()
    {
        $data['menu'] = "Dashboard";
        
        // Total number of users
        $data['total_users'] = User::where('role', '!=', 'admin')->count();
        
        // Total number of products
        $data['total_products'] = Products::count();
        
        // Total number of orders
        $data['total_orders'] = Order::count();

        // Sum of the total_amount column
        $data['total_amount_sum'] = env('CURRENCY').number_format(Order::sum('total_amount'), 2);

        // Sales Chart
        $currentDate = Carbon::now();
        $startDate = $currentDate->copy()->subMonths(12)->startOfMonth();
        $endDate = $currentDate->endOfMonth();

        // Fetch monthly order amounts for the last 12 months
        $monthlyOrderAmounts = Order::select(
            DB::raw('DATE_FORMAT(created_at, "%Y-%m") as month'),
            DB::raw('SUM(total_amount) as total_amount')
        )
        ->whereBetween('created_at', [$startDate, $endDate])
        ->groupBy('month')
        ->get();

        // Initialize an array for the last 12 months
        $lastMonths = [];
        $monthFormat = 'Y-m';
        $currentMonth = $currentDate->copy()->startOfMonth();
        for ($i = 0; $i < 12; $i++) {
            $month = $currentMonth->format($monthFormat);
            $lastMonths[$month] = 0;
            $currentMonth->subMonth();
        }

        // Populate the array with actual values if available
        foreach ($monthlyOrderAmounts as $monthlyOrder) {
            $lastMonths[$monthlyOrder->month] = $monthlyOrder->total_amount;
        }

        // Format monthly order amounts array
        $monthlyOrderAmountsFormatted = array_map(function ($month, $amount) {
            return [
                'month' => $month,
                'total_amount' => $amount
            ];
        }, array_keys($lastMonths), $lastMonths);

        // Reverse the order of monthly order amounts for proper display
        $data['monthlyOrderAmounts'] = array_reverse($monthlyOrderAmountsFormatted);

        //total order

        $currentDate = now();
        $startDate = $currentDate->copy()->subDays(6)->startOfDay();
        $endDate = $currentDate->endOfDay();
        
        $ordersByDate = Order::selectRaw('DATE(created_at) as order_date, COUNT(*) as num_orders')
        ->where('created_at', '>=', $startDate)
        ->where('created_at', '<=', $endDate)
        ->groupBy('order_date')
        ->get()
        ->keyBy(function ($order) {
            return Carbon::parse($order->order_date)->day;
        });
        
        $result = [];
        $current = $startDate->copy();
        for ($current = $startDate->copy(); $current <= $endDate; $current->addDay()) {
            $orderDay = $current->day;
            $numOrders = $ordersByDate[$orderDay]->num_orders ?? 0;
            $result[] = ['order_date' => $orderDay, 'num_orders' => $numOrders];
        }
        $data['order_date'] = $result;
        
        return view('admin.dashboard', $data);
    }
}
