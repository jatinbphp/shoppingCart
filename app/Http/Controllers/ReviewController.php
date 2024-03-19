<?php

namespace App\Http\Controllers;
use App\Models\Review;
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
      
        return response()->json(['success' => true, 'message' => 'Review hase been inserted successfully!']);
    }

    public function reviewDetail(Request $request, $productId)
    {
        $data= Review::where('product_id',$productId)->get();
        foreach ($data as $review) {
            $userImage = User::where('id', $review->user_id)->value('image');
            $review->user_image = $userImage ?? 'default.jpg'; 

            $description = $review->description;
            $shortDescription = substr($description, 0, 200); 
            $remainingDescription = substr($description, 200); 
            $review->short_description = $shortDescription;
            $review->remaining_description = $remainingDescription;
        }
        // return $data;
        if ($request->ajax()) {
            return Datatables::of($data)
                ->addIndexColumn()
                ->editColumn('user_image', function ($row) {
                    if (!empty($row->user_image) && file_exists($row->user_image)) {
                        return url($row->user_image);
                    } else {
                        return url('assets/admin/dist/img/no-image.png');
                    }
                })
                ->editColumn('created_at', function($row){
                    return $row['created_at']->format('Y-m-d h:i:s');
                })
                ->make(true);
        }
        // return $data;
        return view('review.review-detail', [
            'data' => $data,
            'productId' => $productId
        ]);
        
    }
}
