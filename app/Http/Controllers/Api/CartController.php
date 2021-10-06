<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Cart;
use App\Models\Product;
use App\Models\ProductGallery;
use Illuminate\Http\Request;

class CartController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth:api');
    }

    public function index()
    {
        $carts = Cart::with('product.gallery')
            ->where('customer_id', auth()->user()->id)
            ->orderBy('created_at', 'desc')
            ->get();
        return response()->json([
            'success'   =>  true,
            'message'   =>  'List Data Cart',
            'cart'      =>  $carts,
        ]);
    }

    public function addToCart(Request $request)
    {
        $item = Cart::with('product')->where('product_id', $request->product_id)
            ->where('customer_id', $request->customer_id);

        if ($item->count()) {
            // increment quantity
            $item->increment('quantity');

            $item = $item->first();

            //sum price and wight * quantity
            $price = $request->price;
            $price_before = $request->price_before;
            $qty = $request->quantity;

            $item->update([
                'price'     => $price,
                'price_before' => $price_before,
                'quantity'  => $qty
            ]);
        } else {
            $item = Cart::create([
                'product_id'    => $request->product_id,
                'customer_id'   => $request->customer_id,
                'quantity'      => $request->quantity,
                'price'         => $request->price,
                'price_before'  => $request->price_before,
            ]);
        }

        return response()->json([
            'success'   => true,
            'message'   => 'Success add to cart',
            'quantity'  => $item->quantity,
            'product'   => $item->product
        ]);
    }

    public function cartTotalPrice()
    {
        $carts = Cart::with('product')
            ->where('customer_id', auth()->guard('api')->user()->id)
            ->orderBy('created_at', 'desc')
            ->sum('price');
        return response()->json([
            'success'   => true,
            'message'   => 'Total Cart Price',
            'total'     => $carts
        ]);
    }

    public function beforeDiscount()
    {
        $carts = Cart::with('product')
            ->where('customer_id', auth()->guard('api')->user()->id)
            ->sum('price_before');
        return response()->json([
            'success'   => true,
            'message'   => 'harga sebelum diskon',
            'total'     => $carts
        ]);
    }

    public function cartTotalWeight()
    {
        $carts = Cart::with('product')
            ->where('customer_id', auth()->guard('api')->user()->id)
            ->orderBy('created_at', 'desc')
            ->sum('weight');
        return response()->json([
            'success'   => true,
            'message'   => 'Total Cart Wight',
            'total'     => $carts
        ]);
    }

    public function removeCart(Request $request)
    {
        Cart::with('product')
            ->whereId($request->cart_id)
            ->delete();
        return response()->json([
            'success'   => true,
            'message'   => 'Remove item cart'
        ]);
    }


    public function removeAllCart(Request $request)
    {
        Cart::with('product')
            ->where('customer_id', auth()->user()->id)
            ->delete();
        return response()->json([
            'success'   => true,
            'message'   => 'Remove All item in cart'
        ]);
    }
}
