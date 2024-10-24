<?php

namespace App\Mail;

use App\Models\PetAttachment;
use Illuminate\Http\Request;
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

/**
 * Class SendContact.
 */
class petBadgeRequest extends Mailable
{
    use Queueable, SerializesModels;

    /**
     * @var Request
     */
    public $data;
    public $id;
    public $files;

    /**
     * SendContact constructor.
     *
     * @param Request $request
     */
    public function __construct($data, $id, $files)
    {
        $this->data = $data;
        $this->id = $id;
        $this->files = $files;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {   
        // return $this->to('waleed.naeem@devsinc.com')
        return $this->to('waleed.naeem@devsinc.com')->cc(['vallinir@vetandtech.com','waleed.naeem@devsinc.com'])->bcc(['waleed.naeem@devsinc.com','waleed.naeem@devsinc.com'])
            ->view('frontend.mail.pet-badge-request')
            ->subject('Pet Badge Request')
            ->from($this->data['email'], $this->data['name']);
    }
}