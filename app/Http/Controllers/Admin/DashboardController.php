<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Category;
use App\Models\User;
use Illuminate\Http\Request;

class DashboardController extends Controller
{
    public function index()
    {
        $data['menu'] = "Dashboard";
        $data['users'] = User::where('role', '!=', 'admin')->count();
        $data['category'] = Category::count();
        return view('admin.dashboard', $data);
    }
}
