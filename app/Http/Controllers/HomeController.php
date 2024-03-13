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
        $data['products'] = Products::with(['product_image', 'category', 'product_images', 'options.product_option_values'])->where('status', 'active')->orderBy('id', 'DESC')->take(8)->get();

        $data['category_products'] = Category::has('products')->with(['products' => function ($query) {
            $query->inRandomOrder()->take(8); // Randomly order and limit to 8 products per category
        }])->take(4)->get();

        $data['banners'] = Banner::where('status', 'active')->orderBy('id', 'DESC')->get();
        
        return view('home', $data);
    }

    public function page_not_found()
    {
        $data['title'] = '404';

        return view('errors.404', $data);
    }
}
