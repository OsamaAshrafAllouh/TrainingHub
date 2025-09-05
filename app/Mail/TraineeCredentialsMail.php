<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Contracts\Queue\ShouldQueue;

class TraineeCredentialsMail extends Mailable
{
    use Queueable, SerializesModels;

    public $trainee_id;
    public $password;

    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct($trainee_id, $password)
    {
        $this->trainee_id = $trainee_id;
        $this->password = $password;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        return $this->from(config('mail.from.address'), config('mail.from.name'))
            ->subject('بيانات تسجيل الدخول - نظام التدريب')
            ->view('emails.trainee_credentials')->with([
                'trainee_id' => $this->trainee_id,
                'password' => $this->password,
            ]);


    }
}
