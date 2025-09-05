<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Contracts\Queue\ShouldQueue;

class PendingProgramMail extends Mailable
{
    use Queueable, SerializesModels;

    public $course_name;
    public $trainee_name;
    public $fees;

    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct($course_name, $trainee_name,$fees)
    {
        $this->course_name = $course_name;
        $this->trainee_name = $trainee_name;
        $this->fees = $fees;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        return $this->from(config('mail.from.address'), config('mail.from.name'))
            ->subject('Program Status: Pending - Training Hub')
            ->view('emails.pending_Program')->with([
                'course_name'=> $this->course_name,
                'trainee_name' => $this->trainee_name,
                'fees' => $this->fees,
            ]);
    }
}
