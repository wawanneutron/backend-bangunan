<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\SliderRequst;
use App\Models\Slider;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class SliderController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $sliders = Slider::latest()->paginate(5);
        return view('admin.slider.index', compact('sliders'));
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function store(SliderRequst $request)
    {
        // upload image
        $image = $request->file('image')->store('slider-images', 'public');
        $slider = Slider::create([
            'image' => $image,
            'link'  => $request->link
        ]);

        if ($slider) {
            return redirect()->route('admin.slider.index')->with([
                'success' => 'Data Berhasil Disimpan !'
            ]);
        } else {
            return redirect()->route('admin.slider.index')->with([
                'error' => 'Data Gagal Disimpan !'
            ]);
        }
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $slider = Slider::findOrFail($id);
        $image = Storage::delete('public/' . $slider->image);

        $slider->delete();

        if ($slider) {
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
