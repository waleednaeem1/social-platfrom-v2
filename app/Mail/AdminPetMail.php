<?php

namespace App\Mail;

use App\Models\PetsImage;
use Illuminate\Http\Request;
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

/**
 * Class SendContact.
 */
class AdminPetMail extends Mailable
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
        // return $this->to('waleed.naeem@devsinc.com')->cc(['info@vetandtech.com','waleed.naeem@devsinc.com','mohsin.gmit@gmail.com'])->bcc(['waleed.naeem@devsinc.com','uzair.gmit@gmail.com'])
        return $this->to('waleed.naeem@devsinc.com')
            ->view('frontend.mail.pet-share')
            ->subject('Pet Approval Request')
            ->from($this->data['email'], $this->data['first_name'].' '.$this->data['last_name']);
    }
}