<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class NotificationCheckoutSuccess extends Mailable
{
    use Queueable, SerializesModels;

    public $data_transaction_success;
    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct($data_transaction_success)
    {
        $this->data_transaction_success = $data_transaction_success;
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
            ->subject('Pembayaran Success')
            ->view('emails.pembayaran-success');
    }
}
