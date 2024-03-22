<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class ReplyContact extends Mailable
{
    use Queueable, SerializesModels;

    private $completeNameContact;
    private $messageContact;
    private $replyContact;

    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct($completeNameContact, $messageContact, $replyContact)
    {
        $this->completeNameContact = $completeNameContact;
        $this->messageContact = $messageContact;
        $this->replyContact = $replyContact;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        return $this->subject('Respuesta a consulta')
            ->view('backoffice.contact.replyContact')
            ->with([
                'completeNameContact' => $this->completeNameContact,
                'messageContact' => $this->messageContact,
                'replyContact' => $this->replyContact
            ]);
    }
}
