<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Contracts\Queue\ShouldQueue;

use App\HeaderOrder;
use App\DetailOrder;

class OrderConfirmed extends Mailable
{
    use Queueable, SerializesModels;

    /**
     * Create a new message instance.
     *
     * @return void
     */

    public $header;
    public $detail;

    public function __construct($orderId)
    {
        $this->header = HeaderOrder::join('users', 'header_orders.user_id', '=', 'users.id')->select(DB::RAW('header_orders.*, users.*, header_orders.created_at as header_created_at, 0 as order_created_at'))->find($orderId);
        $this->detail = DetailOrder::where('order_header_id', $orderId)->get();
        $this->header->header_created_at = Carbon::createFromFormat('Y-m-d H:i:s', $this->header->header_created_at)->format('d-m-Y - H:i');
        $this->header->order_created_at = Carbon::createFromFormat('d-m-Y - H:i', $this->header->header_created_at)->format('d F Y');
        $this->subtotal = 0;
        foreach($this->detail as $d) {
            $this->subtotal += $d->price_per_box * $d->total_item;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        eturn $this->from(env('MAIL_ADDRESS', 'sales@depotile.com'), 'depotile.com')
                    ->subject('Payment Confirmation')
                    ->view('email-depotile.invoice2');
    }
}
