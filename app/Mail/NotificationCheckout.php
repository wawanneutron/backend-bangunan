<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class NotificationCheckout extends Mailable
{
    use Queueable, SerializesModels;

    public $data_transaction;

    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct($data_transaction)
    {
        $this->data_transaction = $data_transaction;

        // dd($data_transaction);
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        return $this
            ->from('store-sport@gmail.com', 'Deni Store Shoes')
            ->subject('Silahkan Selesaikan Pembayaran Anda')
            ->view('emails.checkout-payment');
    }
}
