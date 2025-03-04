<?php

namespace App\Mail;

use Illuminate\Mail\Mailable;

class OrderConfirmation extends Mailable
{
    public $order;

    public function __construct($order)
    {
        $this->order = $order;
    }

    public function build()
    {
        return $this->subject("Подтверждение записи на автомойку")
            ->view('emails.order_confirmation');
    }
}
