<?php

namespace App\Jobs;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;


use Illuminate\Support\Facades\Mail;

use App\Mail\povpMail;
use App\Mail\HotelMail;



class SendMailReservation implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    /**
     * Create a new job instance.
     *
     * @return void
     */

	public $emaildata;


    public function __construct($emaildata)
    {
        $this->emaildata = $emaildata;
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
	
        Mail::to("WebWhatMarko@gmail.com")->send(new HotelMail($this->emaildata));
        Mail::to($this->emaildata[7])->send(new povpMail($this->emaildata));
        
    }
}
