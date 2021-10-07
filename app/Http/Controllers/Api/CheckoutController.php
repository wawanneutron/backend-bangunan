<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Mail\NotifCheckoutPayment;
use App\Mail\NotificationCheckout;
use App\Mail\NotificationCheckoutSuccess;
use App\Models\Cart;
use App\Models\Invoice;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Mail;
use Midtrans\Config;
use Midtrans\Snap;

class CheckoutController extends Controller
{

    protected $request;

    public function __construct(Request $request)
    {
        $this->middleware('auth:api')->except('notificationHandler');

        $this->request = $request;

        // Set midtrans configuration
        Config::$serverKey    = config('services.midtrans.serverKey');
        Config::$isProduction = config('services.midtrans.isProduction');
        Config::$isSanitized  = config('services.midtrans.isSanitized');
        Config::$is3ds        = config('services.midtrans.is3ds');
    }


    public function store()
    {
        DB::transaction(function () {

            // algorithm create no invoice
            $length     = 10;
            $random     = '';
            for ($i = 0; $i < $length; $i++) {
                $random .= rand(0, 1) ? rand(0, 9) : chr(rand(ord('a'), ord('z')));
            }
            $no_invoice = 'INV-' . Str::upper($random);

            $invoice = Invoice::create([
                'invoice'       =>  $no_invoice,
                'customer_id'   =>  auth()->guard('api')->user()->id,
                'name'          =>  $this->request->name,
                'phone'         =>  $this->request->phone,
                'province'      =>  $this->request->province,
                'city'          =>  $this->request->city,
                'address'       =>  $this->request->address,
                'note'          =>  $this->request->note,
                'grand_total'   =>  $this->request->grand_total,
                'status'        =>  'Pending',
            ]);
            foreach (Cart::where('customer_id', auth()->guard('api')->user()->id)->get() as $cart) {
                // insert product yang ada di kranjang/cart  ke table order
                $invoice->orders()->create([
                    'invoice_id'    =>  $invoice->id,
                    'invoice'       =>  $no_invoice,
                    'product_id'    =>  $cart->product_id,
                    'product_name'  =>  $cart->product->title,
                    'unit'          =>  $cart->product->unit,
                    'qty'           =>  $cart->quantity,
                    'price'         =>  $cart->price,
                ]);

                // decrement stock
                $stock = $cart->product->stock -= $cart->quantity;
                $cart->product()->update([
                    'stock' => $stock
                ]);
            }

            /* Buat transaksi ke Midtrans,
            kemudian save snap tokennya ke databse */
            $payload = [
                'transaction_details' => [
                    'order_id'      => $invoice->invoice,
                    'gross_amount'  => $invoice->grand_total,
                ],
                'customer_details' => [
                    'first_name'       => $invoice->name,
                    'email'            => auth()->guard('api')->user()->email,
                    'phone'            => $invoice->phone,
                    'shipping_address' => $invoice->address
                ],
                'vtweb' => []

            ];

            //create snap token
            $snapToken = Snap::getSnapToken($payload);
            $invoice->snap_token = $snapToken;
            $invoice->save();

            $this->response['snap_token'] = $snapToken;

            /* kirim notifikasi email (detail pembayaran) ke customer */
            // data transaction
            $data_transaction   = Invoice::with(['customer', 'orders'])->where('invoice', $invoice->invoice)->first();
            Mail::to($data_transaction->customer->email)->send(new NotificationCheckout($data_transaction));
        });
        return response()->json([
            'success' => true,
            'message' => 'Order Successfully',
            $this->response,
        ]);
    }



    // kirim notifikasi ke midtrans
    public function notificationHandler(Request $request)
    {
        $payload            =   $request->getContent();
        $notification       =   json_decode($payload);

        $validSignatureKey  =   hash("sha512", $notification->order_id . $notification->status_code . $notification->gross_amount . config('services.midtrans.serverKey'));

        if ($notification->signature_key != $validSignatureKey) {
            return response([
                'message'   =>  'Invalid signature'
            ], 403);
        }
        $transactionStatus    =   $notification->transaction_status;
        // $type                 =   $notification->payment_type;
        $orderId              =   $notification->order_id; //order_id = invoice
        // $fraud                =   $notification->fraud_status;

        // data transaction
        $data_transaction   = Invoice::with(['customer', 'orders'])->where('invoice', $orderId)->first();

        // if ($transactionStatus == 'capture') {
        //     /* 
        //     For credit card transaction,
        //     we need to check whether transaction is challenge by FDS or not 
        //      ini kalo pembayaran pake Indomaret gak bakal bisa  jadi harus di blok credit card nya
        //     */
        //     if ($type == 'credit_card') {

        //         if ($fraud == 'challenge') {
        //             // update invoice to pending
        //             $data_transaction->update([
        //                 'status' => 'pending'
        //             ]);
        //         } else {
        //             // update invoice to payment-success
        //             $data_transaction->update([
        //                 'status' => 'payment-success'
        //             ]);
        //         }
        //     }
        // } 
        if ($transactionStatus == 'settlement') {
            // update invoice to payment-success
            $data_transaction->update([
                'status' => 'payment-success'
            ]);
            Mail::to($data_transaction->customer->email)->send(new NotificationCheckoutSuccess($data_transaction));
        } elseif ($transactionStatus == 'pending') {
            // update invoice to pending
            $data_transaction->update([
                'status' => 'pending'
            ]);
        } elseif ($transactionStatus == 'deny') {
            // update invoice to failed
            $data_transaction->update([
                'status' => 'failed'
            ]);
        } elseif ($transactionStatus == 'expire') {
            // update invoice to expired
            $data_transaction->update([
                'status' => 'expired'
            ]);
        } elseif ($transactionStatus == 'cancel') {
            $data_transaction->update([
                'status' => 'failed'
            ]);
        }
        return response()->json([
            'meta' => [
                'code' => 200,
                'message' => 'Midtrans notification success'
            ]
        ]);
    }
}
