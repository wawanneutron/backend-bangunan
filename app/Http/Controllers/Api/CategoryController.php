<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Category;
use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class CategoryController extends Controller
{
    public function index()
    {
        $categories = Category::latest()->get();

        return response()->json([
            'success'       => true,
            'message'       => 'List Data Category',
            'categories'    => $categories
        ]);
    }

    public function show($slug)
    {
        $categoryName = Category::where('slug', $slug)->first();

        $category = Product::with('gallery')
            ->where('categories.slug', $slug)
            ->select(
                'products.*',
                DB::raw('avg(reviews.rating) as avg_rating'),
                DB::raw('count(reviews.review) as total_reviews'),
            )
            ->join('categories', 'categories.id', '=', 'products.category_id')
            ->leftjoin('reviews', 'reviews.product_id', '=', 'products.id')
            ->groupBy('products.id')
            ->get();

        if ($category) {
            return response()->json([
                'success'   => true,
                'message'   => 'List Product By Category ',
                'category'   => $categoryName,
                'product'   => $category
            ], 200);
        } else {
            return response()->json([
                'success'   => false,
                'message'   => 'Data Product By Category Tidak Ditemukan!'
            ], 404);
        }
    }

    public function categoryHome()
    {
        $categories = Category::latest()->take(6)->get();
        return response()->json([
            'status'        =>  true,
            'message'       =>  'List Data Category Home',
            'categories'    =>  $categories
        ]);
    }
}
