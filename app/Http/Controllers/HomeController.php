<?php

namespace App\Http\Controllers;
use App\Models\Banner;
use App\Models\Category;
use App\Models\ContactUs;
use App\Models\Products;
use App\Models\Subscriber;
use App\Models\ProductImages;
use App\Models\ProductsOptions;
use App\Models\ProductsOptionsValues;
use Illuminate\Http\Request;
use App\Http\Requests\ContactUsRequest;

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

    public function about_us()
    {
        $data['title'] = 'About Us';

        return view('about-us', $data);
    }

    public function contact_us()
    {
        $data['title'] = 'Contact Us';

        return view('contact-us', $data);
    }

    public function contactFormSubmit(ContactUsRequest $request)
    {
        $input = $request->all();
        ContactUs::create($input);

        \Session::flash('success', 'Thank you for getting in touch! We will get back in touch with you soon!Have a great day!');
        return redirect()->back();
    }

    public function subscriberFormSubmit(Request $request)
    {
        $request->validate([
            'email' =>'required|email|unique:subscribers,email'
        ]);
        $subscriber_data = [
            'email' => $request->email,
        ];
        Subscriber::create($subscriber_data);
        return redirect()->back()->with('subscribe_message', 'You have successfully subscribed.');
    }
}
