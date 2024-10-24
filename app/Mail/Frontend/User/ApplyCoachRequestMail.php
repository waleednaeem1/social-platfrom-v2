<?php

namespace App\Mail\Frontend\User;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class ApplyCoachRequestMail extends Mailable
{
    use Queueable, SerializesModels;

    public $data;
    /**
     * Create a new message instance.
     *
     * @return void
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
        $subject = 'Coach Assigning Request';
        return $this->to('brian@colourfulcpd.com')->cc('waleed.naeem@devsinc.com')->bcc(['waleed.naeem@devsinc.com','waleed.naeem@devsinc.com','mohsin.gmit@gmail.com','waleed.naeem@devsinc.com'])
        // return $this->to('waleed.naeem@devsinc.com')
            ->view('frontend.course.coach-assign-email',['data' => $this->data])
            ->subject($subject)
            ->from('no-reply@devsinc.com', 'VT Friends');

    }
}