<?php

namespace App\Mail\Frontend\Order;

use Illuminate\Http\Request;
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

/**
 * Class SendContact.
 */
class SendEnterToWin extends Mailable
{
    use Queueable, SerializesModels;

    /**
     * @var Request
     */
    public $data;

    /**
     * SendContact constructor.
     *
     * @param Request $request
     */
    public function __construct($data)
    {
        $this->data = $data;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        return $this->to('waleed.naeem@devsinc.com', 'VT Friends')->cc('waleed.naeem@devsinc.com')
            ->bcc(['waleed.naeem@devsinc.com','mohsin.gmit@gmail.com','waleed.naeem@devsinc.com'])
            ->view('frontend.mail.form-enter-to-win')
            ->subject('Enter to Win Submission at ' . appName())
            ->from('notifications@gervetusa.com', appName())
            ->replyTo('no-reply@gervetusa.com', 'No-Reply');
    }
}
