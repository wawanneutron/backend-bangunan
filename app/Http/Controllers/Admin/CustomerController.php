<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Customer;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Yajra\DataTables\Facades\DataTables;

class CustomerController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        if (request()->ajax()) {
            $customers = Customer::latest();
            return DataTables::of($customers)
                ->editColumn('at', function ($item) {
                    return dateID($item->created_at);
                })
                ->rawColumns(['created_at'])
                ->make();
        }

        return view('admin.customer.index');
    }
}
