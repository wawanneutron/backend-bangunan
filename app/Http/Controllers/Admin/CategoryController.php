<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\CategoryRequest;
use App\Http\Requests\UpdateCategory;
use App\Http\Requests\UpdateCategoryRequest;
use App\Models\Category;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class CategoryController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        // display data and search fitur in one code
        $categories = Category::latest()->when(request()->q,  function ($categories) {
            $categories = $categories->where('name', 'like', '%' . request()->q . '%');
        })->paginate(10);

        return view('admin.category.index', compact('categories'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('admin.category.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(CategoryRequest $request)
    {
        // upload image
        $image = $request->file('image')->store('category-images', 'public');

        // save t DB
        $category = Category::create([
            'image' => $image,
            'name' => $request->name,
            'slug' => Str::slug($request->name)
        ]);

        if ($category) {
            // redirect dengan pesan success
            return redirect()->route('admin.category.index')->with([
                'success' => 'Data Berhasil Disimpan!'
            ]);

            // redirect dengan pesan error
            return redirect()->route('admin.category.index')->with([
                'error' => 'Data Gagal Disimpan!'
            ]);
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
    public function edit($id)
    {
        $category = Category::findOrFail($id);
        return view('admin.category.edit', compact('category'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Category $category)
    {
        $this->validate($request, [
            'name' => 'unique:categories,name,' . $category->id,
            'image' => 'image|mimes:jpeg,jpg,img,gif,png,webp|max:1000,'
        ]);
        // check jika image kosong
        if ($request->file('image') == '') {
            // update data tanpa image
            $category = Category::findOrFail($category->id);
            $category->update([
                'name' => $request->name,
                'slug' => Str::slug($request->name),
            ]);
        } else {
            // hapus image lama
            $category_image_delete = basename($category->image) . PHP_EOL;
            Storage::disk('local')->delete('public/category-images/' . $category_image_delete);

            // upload image baru
            $image = $request->file('image')->store('category-images', 'public');
            // save db
            $category = Category::findOrFail($category->id);
            $category->update([
                'image' => $image,
                'name' => $request->name,
                'slug' => Str::slug($request->name),
            ]);
        }

        if ($category) {
            // redirect dengan pesan success
            return redirect()->route('admin.category.index')->with([
                'success' => 'Data Berhasil Di Update'
            ]);
        } else {
            // redirect dengan pesan error
            return redirect()->route('admin.category.index')->with([
                'error' => 'Data Gagal Di Update'
            ]);
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $category = Category::findOrFail($id);
        // jika menggunakan getImageAtribute di model gunakan hapus storege ini 
        $category_image_delete = basename($category->image) . PHP_EOL;
        Storage::disk('local')->delete('public/category-images/' . $category_image_delete);

        $category->delete();

        if ($category) {
            return response()->json([
                'status' => 'success'
            ]);
        } else {
            return response()->json([
                'status' => 'error'
            ]);
        }
    }
}
