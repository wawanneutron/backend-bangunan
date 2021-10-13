<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Invoice;
use App\Models\Order;
use App\Models\Product;
use Illuminate\Support\Facades\DB;

class DashboardController extends Controller
{
    public function index()
    {
        // count invoice
        $pending        = Invoice::where('status', 'pending')->count();
        $paymentSuccess = Invoice::where('status', 'payment-success')->count();
        $process        = Invoice::where('status', 'process')->count();
        $shipping       = Invoice::where('status', 'shipping')->count();
        $success        = Invoice::where('status', 'success')->count();
        $expired        = Invoice::where('status', 'expired')->count();
        $failed         = Invoice::where('status', 'failed')->count();

        // year and month
        $year  = date('Y');
        $month = date('m');
        // $day   = date('d');
        // statistic revenue
        // $revanueDay = Invoice::where('status', 'payment-success')
        //     ->whereDay('created_at', '=',  $day)
        //     ->whereMonth('created_at', '=', $month)
        //     ->whereYear('created_at', $year)
        //     ->sum('grand_total');

        $revenueMonth = Invoice::where('status', 'success')
            ->whereMonth('created_at', '=', $month)
            ->whereYear('created_at', $year)
            ->sum('grand_total');
        $revenueYear = Invoice::where('status', 'success')
            ->whereYear('created_at', $year)
            ->sum('grand_total');
        $revenueAll = Invoice::where('status', 'success')
            ->sum('grand_total');

        // pendapatan bulanan
        $revanueEveryMonth = DB::table('invoices')
            ->select(DB::raw("sum(grand_total) as revanue, date_format(created_at, '%Y-%m') as YearMonth"))
            ->where('status', 'success')
            ->groupBy('YearMonth')
            ->orderBy('YearMonth', 'ASC')
            ->get();
        /* looping dan ambil revanue dan YearMonth lalu pisahkan ke array baru 
        dan revanue jadikan int agar bisa dipakai ssebagai array di chart.js */
        $newRevanues = array();
        $newMonth    = array();

        foreach ($revanueEveryMonth as $key => $value) {
            array_push($newRevanues, intval($value->revanue));
            array_push($newMonth, $value->YearMonth);
        }
        /* looping bulan dan ubah format tanggal */
        $monthConvert = array();
        foreach ($newMonth as $date) {
            array_push($monthConvert, date('F,Y', strtotime($date)));
        }



        return view('admin.dashboard.index', compact(
            'pending',
            'paymentSuccess',
            'process',
            'shipping',
            'success',
            'expired',
            'failed',
            'revenueMonth',
            'revenueYear',
            'revenueAll',
            'revanueEveryMonth',
            'newRevanues',
            'monthConvert'
        ));
    }
}
