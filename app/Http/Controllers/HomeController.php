<?php

namespace App\Http\Controllers;
use App\Models\Banner;
use App\Models\Category;
use App\Models\Products;
use App\Models\Subscriber;
use Illuminate\Http\Request;

class HomeController extends Controller
{
    public function index()
    {   
        $data['title'] = 'Home';

        return view('home', $data);
    }

    public function page_not_found()
    {
        $data['title'] = '404';

        return view('errors.404', $data);
    }
}