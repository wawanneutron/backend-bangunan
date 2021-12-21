<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Product;
use App\Models\ProductGallery;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;
use Yajra\DataTables\Facades\DataTables;

class GalleryController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        // $galleries = ProductGallery::latest('product_galleries.created_at')
        //     ->with('product')
        //     ->when(request()->q, function ($galleries) {
        //         $galleries
        //             ->join('products', 'products.id', '=', 'product_galleries.products_id')
        //             ->where('products.title', 'like', '%' . request()->q . '%');
        //     })
        //     ->paginate(10);

        if (request()->ajax()) {
            $gallery = ProductGallery::with(['product'])->latest();
            return DataTables::eloquent($gallery)
                ->addColumn('action', function ($item) {
                    return '
                    <div class="btn-group">
                        <div class="dropdown">
                            <button onclick="Delete(this.id)" class=" btn btn-sm btn-danger " id=" ' . $item->id . '">
                                    <i class="fa fa-trash"></i>
                                </button>
                        </div>
                    </div>
                ';
                })
                ->addColumn('image', function ($item) {
                    return $item->image ? '<img src="' . url($item->image) . ' " style="max-height: 55px;" />' : '';
                })
                ->rawColumns(['action', 'image'])
                ->make();
        }

        return view('admin.gallery.index');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $products = Product::all();

        // dd($products);
        return view('admin.gallery.create', compact('products'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $image = $request->file('image')->store('product-images', 'public');
        $gallery = ProductGallery::create([
            'image'         => $image,
            'products_id'   => $request->product_id
        ]);

        if ($gallery) {
            return redirect()->route('admin.gallery.index')
                ->with(['success' => 'Gallery Product Berhasil Ditambahkan']);
        } else {
            return redirect()->route('admin.gallery.index')
                ->with(['error' => 'Gallery Product Gagal Ditambahkan']);
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */


    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */


    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $gallery = ProductGallery::findOrFail($id);

        // jika menggunakan getImageAtribute di model gunakan hapus storege ini 
        $galleryProductDelete = basename($gallery->image) . PHP_EOL;
        Storage::disk('local')->delete('public/product-images/' . $galleryProductDelete);
        $gallery->delete();

        if ($gallery) {
            return response()->json([
                'status' => 'success',
            ]);
        } else {
            return response()->json([
                'status' => 'error',
            ]);
        }
    }
}
