<?php

namespace App\Http\Controllers;
use App\Models\Banner;
use App\Models\Category;
use App\Models\Products;
use App\Models\ProductImages;
use App\Models\ProductsOptions;
use App\Models\ProductsOptionsValues;
use Illuminate\Http\Request;

class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    /*public function __construct()
    {
        $this->middleware('auth');
    }*/

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index()
    {
        $data['products'] = Products::with(['product_image', 'category', 'product_images', 'options.product_option_values'])->where('status', 'active')->orderBy('id', 'DESC')->take(8)->get();

        $data['category_products'] = Category::has('products')->with(['products' => function ($query) {
            $query->inRandomOrder()->take(8); // Randomly order and limit to 8 products per category
        }])->take(4)->get();
        
        $data['banner'] = Banner::find(1);
        $data['banner']['image'] = json_decode($data['banner']['image'], true, JSON_UNESCAPED_SLASHES);

        return view('home', $data);
    }
}
