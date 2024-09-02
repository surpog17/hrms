<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Contracts\Queue\ShouldQueue;

use App\Awards;
use App\Employee;
use App\Payroll;
use App\User;
use App\Deduct;
use PDF;

class Payroll_mail extends Mailable
{
    use Queueable, SerializesModels;

    public $user;

    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct($user)
    {
        //
        $this->user = $user;

    }

    /**
     * Build the message.
     *
     * @return $this
     */

    public function build()
    {
        $employee = Employee::where('employee_id',$this->user->employee_id)->first();
        $payroll = Payroll::where('employee_id',$this->user->employee_id)->first();
        $award = Awards::where('employee_id',$this->user->employee_id)->first();
        $ded = Deduct::where('employee_id',$this->user->employee_id)->first();

        $pdf = PDF::loadView('payslip');


        return $this->markdown('emails.payroll');
    }
}
