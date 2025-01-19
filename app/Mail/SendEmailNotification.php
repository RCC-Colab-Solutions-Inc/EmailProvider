<?php
namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class SendEmailNotification extends Mailable
{
    use Queueable, SerializesModels;

    public $subject;
    public $htmlContent;

    public function __construct($subject, $htmlContent)
    {
        $this->subject = $subject;
        $this->htmlContent = $htmlContent;
    }

    public function build()
    {
        return $this->subject($this->subject)
                    ->html($this->htmlContent); // Directly setting the raw HTML content
    }
}
