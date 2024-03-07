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
use App\Http\Requests\SubscriberRequest;
use Illuminate\Support\Facades\Validator;

class HomeController extends Controller
{
    public function index(Request $request){
        $items = $request->items ?? 5;
        $products_collection = Products::with(['product_image', 'category', 'product_images', 'options.product_option_values'])
            ->where('status', 'active')
            ->orderBy('id', 'DESC')
            ->simplePaginate($items);

        $data['products'] = $products_collection;

        if ($request->ajax()) {
            return response()->json([
                'products' => $data['products'] ?? null,
                'is_last'  => $products_collection->onLastPage(),
                'status'   => 200, 
            ]);
        }

        return view('products', $data);
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

    public function page_not_found()
    {
        $data['title'] = '404';

        return view('404', $data);
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
        $validator = Validator::make($request->all(), [
            'email' => 'required|email|unique:subscribers,email',
        ]);

        if ($validator->fails()) {
            return response()->json(['error' => $validator->errors()->first()], 422);
        }

        try {
            Subscriber::create($request->all());
            return response()->json(['success' => 'You have successfully subscribed.'], 200);
        } catch (\Exception $e) {
            return response()->json(['error' => $e->getMessage()], 500);
        }
    }

}
