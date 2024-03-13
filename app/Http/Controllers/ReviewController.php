<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Review;
use Illuminate\Support\Facades\Validator;

use Illuminate\Support\Facades\Auth;

class ReviewController extends Controller
{
    public function productReview(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'full_name' => 'required',
            'email_address' => 'required|email',
            'rating' => 'required',
            'description' => 'required',
        ]);
    
        if ($validator->fails()) {
            return response()->json(['errors' => $validator->errors()], 422);
        }

       if (Auth::check()) {
        $user_id = Auth::user()->id;
        } else {
            $user_id = 0; 
        }
        $input = $request->all();
        $input['user_id'] = $user_id;
       Review::create($input);
      
       return response()->json(['success' => 'Review form submitted successfully']);
    }
}
