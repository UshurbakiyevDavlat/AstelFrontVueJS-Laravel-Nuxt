<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class JobApplicationMail extends Mailable
{
    use Queueable, SerializesModels;

    protected $jobApplication;
    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct($jobApplication)
    {
        $this->jobApplication = $jobApplication;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        $cc = $this->jobApplication->getAddress();
        $cc = array_map('trim', explode(',', $cc));
        $to = array_shift($cc);

        $mail = $this->to($to);
        if (count($cc)) {
            $mail->cc($cc);
        }

        $mail = $this->to($to);
        $cv = $this->jobApplication->cv;

        if ($cv) {
            $file_path = \Storage::disk('public')->path($cv);
            if (file_exists($file_path)) {
                $mime = mime_content_type($file_path);
                $filename = "Резюме.".pathinfo($file_path)['extension'];

                $mail->attach($file_path, [
                    'as' => $filename,
                    'mime' => $mime,
                ]);
            }
        }

        return $mail->subject("Новый отклик га вакансию {$this->jobApplication->vacancy->name} | Astel")
            ->markdown('emails.jobapplication')
            ->with([
                'jobApplication' => $this->jobApplication,
            ]);
    }
}
