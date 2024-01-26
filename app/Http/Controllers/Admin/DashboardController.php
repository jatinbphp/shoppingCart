<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class DashboardController extends Controller
{
    public function adminDashBoard()
    {
        return view('admin.auth.admin_dashboard');
    }
}
