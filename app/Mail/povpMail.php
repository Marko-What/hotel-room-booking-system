<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class povpMail extends Mailable
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
	    $address = 'roomreservation@example.com';
        $subject = 'Hvala za oddano povpraševanje!';
        $name = 'Hotel Mare';

        return $this->view('emails.testingEmailSpr')
                    ->from($address, $name)
                    ->subject($subject)
                    ->with([ 'emaildata' => $this->data ]);

    }
}
