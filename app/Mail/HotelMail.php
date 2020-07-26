<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class HotelMail extends Mailable
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
	$address = 'roomreservationapp@example.com';
        $subject = 'uporabnik najem sobe';
        $name = 'hotel Mare';

        return $this->view('emails.hotelEmailSpr')
                    ->from($address, $name)
                    ->cc($address, $name)
                    ->replyTo($address, $name)
                    ->subject($subject)
                    ->with([ 'emaildata' => $this->data ]);

    }
}
