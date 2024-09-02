<?php

// In app/Mail/HelloMail.php
namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class PayrollMail extends Mailable
{
    use Queueable, SerializesModels;

    public $webhr;
    public $pdfPath;

    public function __construct($webhr, $pdfPath)
    {
        $this->webhr = $webhr;
        $this->pdfPath = $pdfPath;
    }

    public function build()
    {
        return $this
        ->view('payroll.mail')
        ->attach($this->pdfPath, [
            'as' => 'new-result.pdf',
            'mime' => 'application/pdf',
            ])
            ->cc('iefinance@ienetworksolutions.com')
            ->bcc('biniyam@ienetworksolutions.com')
            ->subject('Generated Payroll');
    }

}
