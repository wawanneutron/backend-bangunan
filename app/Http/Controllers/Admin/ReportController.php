<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Customer;
use App\Models\Invoice;
use App\Models\Order;
use App\Models\Product;
use Barryvdh\DomPDF\Facade as PDF;
use Illuminate\Http\Request;

class ReportController extends Controller
{
    public function cetak_pdf_product()
    {
        $data_product = Product::all();
        $pdf = PDF::loadView('admin.laporan.laporan-product', ['data' => $data_product]);
        return $pdf->stream('data-product.pdf');
    }

    public function cetak_pdf_orders()
    {
        $data_orders = Invoice::where('status', 'success')->get();
        $total = Invoice::where('status', 'success')->sum('grand_total');
        $pdf = PDF::loadView('admin.laporan.laporan-orders', ['data' => $data_orders, 'grandTotal' => $total]);
        return $pdf->stream('data-orders.pdf');
    }

    public function cetak_detail_order($id)
    {
        $invoice = Invoice::with(['provinsi', 'kota', 'gallery', 'customer'])->findOrFail($id);
        $pdf = PDF::loadView('admin.laporan.laporan-detail-order', ['invoice' => $invoice]);
        return $pdf->download("Invoice-Order $invoice->invoice.pdf");
    }

    public function cetak_data_customers()
    {
        $customers = Customer::all();
        $pdf = PDF::loadView('admin.laporan.laporan-data-customers', ['data' => $customers]);
        return $pdf->stream('data-customers.pdf');
    }
}


//*note gunakan stream() untuk preview