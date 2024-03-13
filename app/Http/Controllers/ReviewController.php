<?php

namespace App\Http\Controllers;
use App\Models\Review;
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
      
        return response()->json(['success' => true, 'message' => 'Review hase been inserted successfully!']);
    }
}
