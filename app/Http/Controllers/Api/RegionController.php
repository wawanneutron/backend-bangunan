<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\City;
use App\Models\Province;
use Illuminate\Http\Request;

class RegionController extends Controller
{
    public function getProvinces()
    {
        $provinces = Province::all();
        return response()->json([
            'success'   => true,
            'message'   => 'List Data Provinsi',
            'data'      => $provinces
        ]);
    }

    public function getCities(Request $request)
    {
        $city = City::where('province_id', $request->province_id)->get();
        return response()->json([
            'success'   => true,
            'message'   => 'List Data Cities By Provinces',
            'data'      => $city
        ]);
    }
}
