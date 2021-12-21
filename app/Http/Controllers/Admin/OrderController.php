<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Invoice;
use Illuminate\Http\Request;
use Yajra\DataTables\Facades\DataTables;

class OrderController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        // tampilkan order terbaru "latest" dan buat pengkondisian "when"
        // $invoices = Invoice::latest()->when(request()->q, function ($invoices) {
        //     $invoices->where('invoice', 'like', '%' . request()->q . '%');
        // })->paginate(10);

        // tampilkan dengan DataTables
        if (request()->ajax()) {
            $invoices = Invoice::latest();
            return DataTables::of($invoices)
                ->addColumn('action', function ($data) {
                    return '
                        <a href="' . route('admin.order.show', $data->id)  . '" class=" btn btn-sm btn-info ml-4"><i class="fa fa-eye"></i></a>
                    ';
                })
                ->rawColumns(['action'])
                ->make();
        }

        return view('admin.order.index');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $invoice = Invoice::with(['provinsi', 'kota', 'gallery', 'customer'])->findOrFail($id);
        return view('admin.order.show', compact('invoice'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        return view('admin.order.update',);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $invoice = Invoice::findOrFail($id);
        $invoice->update([
            'status' => $request->status,
        ]);

        return redirect()->route('admin.order.index')->with([
            'success' => 'Update Invoice Berhasil !'
        ]);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
