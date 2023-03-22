<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class NewsletterMail extends Mailable
{
    use Queueable, SerializesModels;
    public $contact_data; 

    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct($contact_data)
    {
        $this->contact_data = $contact_data;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        $from_name = "HELLODEPART";
        $from_email = "sales@hellodepart.com";
        $subject = "HELLODEPART nouveau abonnement à la NewsLetter";
        return $this->from($from_email, $from_name)
            ->view('emails.newsletter')
            ->subject($subject)
        ;
    }
}
