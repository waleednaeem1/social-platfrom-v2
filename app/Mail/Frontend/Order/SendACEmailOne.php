<?php

namespace App\Mail\Frontend\Order;

use Illuminate\Http\Request;
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

/**
 * Class SendContact.
 */
class SendACEmailOne extends Mailable
{
    use Queueable, SerializesModels;

    /**
     * @var Request
     */
    public $order;

    /**
     * SendContact constructor.
     *
     * @param Request $request
     */
    public function __construct($order)
    {
        $this->order = $order;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        return $this->to($this->order->email, $this->order->first_name . ' ' . $this->order->last_name)
            ->view('frontend.mail.order-ac-one')
            ->subject($this->order->ac_subject)
            ->from('notifications@vetonly.com', appName())
            ->replyTo('no-reply@vetonly.com', 'No-Reply');
    }
}
