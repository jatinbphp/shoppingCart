<?php

namespace App\Http\Controllers;
use App\Models\Review;
use App\Models\Products;
use App\Models\User;
use DataTables;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Auth;

class ReviewController extends Controller
{
    public function productReview(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'product_id' => 'required',
            'full_name' => 'required',
            'email_address' => 'required|email',
            'rating' => 'required',
            'description' => 'required',
        ]);
    
        if ($validator->fails()) {
            return response()->json(['errors' => $validator->errors()], 422);
        }
        
        $input = $request->all();
        $input['user_id'] = optional(Auth::user())->id ?? 0;
        Review::create($input);
      
        return response()->json(['success' => true, 'message' => 'Your review has been successfully inserted.']);
    }

    public function reviewsList(Request $request, $id)
    {       
        $data['title'] = 'Reviews';
        $data['productId'] = $id;
        $data['product_info'] = Products::findorFail($id);
        
        if ($request->ajax()) {
            return Datatables::of(Review::with('user')->where('product_id',$id))
                ->addIndexColumn()
                ->addColumn('review_informations', function($row){
                    return view('products.reviews.review-info', $row);
                })
                ->rawColumns(['review_informations'])
                ->make(true);
        }

        return view('products.reviews.reviews-list', $data);
    }

    public function reviewsInfo(Request $request, $id)
    {       
        $data['review_info'] = Review::findorFail($id);
        return response()->json($data);
    }
}
