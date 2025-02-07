<?php

namespace App\Mail;

use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;

class NewNote extends Mailable implements ShouldQueue
{
    public $noteContent;
    public $noteSender;
    public $noteUserName;

    public $noteUrl;

    /**
     * Create a new message instance.
     *
     * @param string $noteContent
     * @param string $noteSender
     * @param string $noteUserName
     * @param string $noteUrl
     */
    public function __construct($noteContent, $noteSender, $noteUserName , $noteUrl)
    {
        $this->noteContent = $noteContent;
        $this->noteSender = $noteSender;
        $this->noteUserName = $noteUserName;
        $this->noteUrl = $noteUrl;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        return $this->from($this->noteSender, 'The Sendnotes App')
            ->subject("You have a new note from {$this->noteUserName}")
            ->view('emails.new-note')
            ->with([
                'noteContent' => $this->noteContent,
                'url' => $this->noteUrl,
            ]);
    }
}
