<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class MyTestMail extends Mailable
{
    use Queueable, SerializesModels;

    /**
     * Create a new message instance.
     *
     * @return void
     */
    public $SubjectText;
    public $HeaderText;
    public $BodyText;
    public $Title;
    public function __construct($SubjectText, $HeaderText,$BodyText,$Title = null)
    {
       $this->HeaderText = $HeaderText;
       $this->BodyText = $BodyText;
       $this->SubjectText = $SubjectText;
       $this->Title = $Title;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        return $this->subject($this->HeaderText)
        ->view('mail.my-test-mail',['HeaderText'=>$this->HeaderText,'BodyText'=>$this->BodyText , 'Title'=>$this->Title]);
    }
}
