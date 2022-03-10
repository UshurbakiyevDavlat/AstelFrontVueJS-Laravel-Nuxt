<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class ServiceCallbackMail extends Mailable
{
    use Queueable, SerializesModels;

    protected $callback;
    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct($callback)
    {
        $this->callback = $callback;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        $cc = $this->callback->getAddress();
        $cc = array_map('trim', explode(',', $cc));
        $to = array_shift($cc);

        $mail = $this->to($to);
        if (count($cc)) {
            $mail->cc($cc);
        }

        return $mail->subject('Новый запрос на консультацию | Astel')
            ->markdown('emails.servicecallback')
            ->with([
                'callback' => $this->callback
            ]);
    }
}
