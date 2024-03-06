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

    public function contactFormSubmit(Request $request)
    {
        $request->validate([
            'name' => 'required',
            'email' => 'required|email',
            'subject' => 'required',
            'message' => 'required',
        ]);
        $contact_data = [
            'name' => ucfirst($request->name),
            'email' => $request->email,
            'subject' => $request->subject,
            'message' => $request->message
        ];
        ContactUs::create($contact_data);
        return redirect()->route('contact-us')->with('message','Form Submitted Successfully');
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
