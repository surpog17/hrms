<?php

namespace App\Jobs;

use Illuminate\Bus\Queueable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Mail;

class SendEmail implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;


 
    public $timeout = 300; // default is 60sec. You may overwrite like this
    protected $data;
    public function __construct($data, $user, $pdf)
    {
        $this->data = $data;
        $this->user = $user;
        $this->pdf = $pdf;
    }

public function handle(Mailer $mailer)
{
    $data = $this->data; // retrieve your passed data to variable
    $user = $this->user;
    $pdf = $this->pdf;
    // your mail code here
      Mail::send('emails.payroll', ["pass_data" => $data], function ($message) use ($pdf, $user) {
                        $message->from('iefinance@ienetworksolutions.com', 'IEFinanceNoReply@ienetworksolutions.com');

                        //$message->to('$webhr->email')->cc('iefinance@ienetworksolutions.com')->subject('Generated Payroll');
                        $message->to('hawi@ienetworks.co')->subject('Generated Payroll');

                        $message->attachData($pdf->output(), "IE-payroll.pdf");
    });
  }
}
