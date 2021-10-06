<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Order;
use App\Models\Review;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class ReviewController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth:api');
    }

    public function addReview(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'rating' => 'required',
            'review' => 'required'
        ]);

        if ($validator->fails()) {
            return response()->json($validator->errors(), 400);
        }

        $review = Review::create([
            'customer_id'   => $request->customer_id,
            'order_id'      => $request->order_id,
            'product_id'    => $request->product_id,
            'rating'        => $request->rating,
            'review'        => $request->review
        ]);
        if ($review) {
            return response()->json([
                'success'       => true,
                'message'       => 'review berhasil ditambahkan',
                'review'        => $review
            ], 200);
        }
        return response()->json([
            'success'   =>  false
        ], 409);
    }

    public function cekReview(Request $request)
    {
        $data = Review::where('customer_id', auth()->guard('api')->user()->id)
            ->where('order_id', $request->order_id)
            ->pluck('order_id')
            ->all();

        if ($data) {
            return response()->json([
                'success'       => true,
                'message'       => 'data review sudah ada',
                'review'        => $data
            ], 200);
        }
        return response()->json([
            'success'       =>  false,
            'message'       => 'belum ada review',
            'review'        => $data
        ], 200);
    }
}
