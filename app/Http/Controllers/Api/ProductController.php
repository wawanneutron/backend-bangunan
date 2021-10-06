<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Product;
use App\Models\Review;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class ProductController extends Controller
{
    public function productAll()
    {
        $products = Product::with('gallery')
            ->leftJoin('reviews', 'reviews.product_id', '=', 'products.id')
            ->select(
                'products.*',
                DB::raw('avg(reviews.rating) as avg_rating'),
                DB::raw('count(reviews.review) as total_reviews'),
            )
            ->groupBy('products.id')
            ->inRandomOrder()
            ->get();

        return response()->json([
            'success'   => true,
            'message'   => 'List Data Product',
            'product'   => $products,
        ], 200);
    }

    public function terlaris()
    {
        // product paling banyak dibeli ("terlaris")
        $data = Product::with('gallery', 'reviews')
            ->join('orders', 'orders.product_id', '=', 'products.id')
            ->join('invoices', 'invoices.id', '=', 'orders.invoice_id')
            ->leftjoin('reviews', 'reviews.product_id', '=', 'products.id')
            ->select(
                'products.*',
                DB::raw('count(orders.product_id) as total_pembelian'),
                DB::raw('avg(reviews.rating) as avg_rating'),
                DB::raw('count(reviews.review) as total_reviews'),
            )
            ->where('invoices.status', 'success')
            ->groupBy('orders.product_id')
            ->orderBy('total_pembelian', 'DESC')
            ->take(8)
            ->get();

        return response()->json([
            'success'   => true,
            'message'   => 'List Data Product Terlaris',
            'terlaris'  => $data,
        ], 200);
    }

    public function productHome()
    {
        // ambil 8 data secara random serta hitung avg rating dan total rating
        $products = Product::with('gallery')
            ->leftJoin('reviews', 'reviews.product_id', '=', 'products.id')
            ->select(
                'products.*',
                DB::raw('avg(reviews.rating) as avg_rating'),
                DB::raw('count(reviews.review) as total_reviews'),
            )
            ->groupBy('products.id')
            ->inRandomOrder()
            ->take(8)
            ->get();

        return response()->json([
            'success'   => true,
            'message'   => 'List Data Product Home',
            'product'   => $products
        ], 200);
    }


    public function show($slug)
    {
        $product = Product::with(['gallery', 'category'])->where('slug', $slug)->first();
        $reviews = Review::with('customer')
            ->where('product_id', $product->id)
            ->orderBy('created_at', 'desc')
            ->get();

        // menghitung rating
        $reviews_count = Review::where('product_id', $product->id)->count();
        $reviews_avg_rating = Review::where('product_id', $product->id)->avg('rating');

        if ($product) {
            return response()->json([
                'success'   => true,
                'message'   => 'Detail Data Product' . $product->name,
                'product'   => $product,
                'reviews'   => $reviews,
                'reviews_count' => $reviews_count,
                'reviews_avg_rating' => $reviews_avg_rating
            ], 200);
        } else {
            return response()->json([
                'success'   => false,
                'message'   => 'Data Product Tidak Ditemukan !'
            ], 404);
        }
    }

    public function search($keyword)
    {
        $products = Product::with('gallery')
            ->where('title', 'LIKE', "%" . $keyword . "%")
            ->leftJoin('reviews', 'reviews.product_id', '=', 'products.id')
            ->select(
                'products.*',
                DB::raw('avg(reviews.rating) as avg_rating'),
                DB::raw('count(reviews.review) as total_reviews'),
            )
            ->groupBy('products.id')
            ->orderBy('created_at', 'DESC')
            ->get();

        return response()->json([
            'success'   => true,
            'message'   => 'pencarian product',
            'product'   => $products,
        ], 200);
    }
}
