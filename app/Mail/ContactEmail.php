<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class ContactEmail extends Mailable
{
    use Queueable, SerializesModels;

    public $content;
    public $subjectLine;

    public function __construct($subjectLine, $content)
    {
        $this->subjectLine = $subjectLine;
        $this->content = $content;
    }

    public function build()
    {
        return $this->subject($this->subjectLine)
                    ->view('emails.contact_send')
                    ->with([
                        'content' => $this->content
                    ]);
    }
}
