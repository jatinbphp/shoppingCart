<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Products;
use App\Models\Category;
use App\Models\User;
use App\Models\Order;
use Illuminate\Http\Request;

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

        return view('admin.dashboard', $data);
    }
}
