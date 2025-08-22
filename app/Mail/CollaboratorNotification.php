<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;
use App\Models\Collaborator;

class CollaboratorNotification extends Mailable
{
    use Queueable, SerializesModels;
    public $collaborator;
    /**
     * Create a new message instance.
     */
    public function __construct(Collaborator $collaborator)
    {
        $this->collaborator = $collaborator;
    }

    /**
     * Get the message envelope.
     */
    public function envelope(): Envelope
    {
        return new Envelope(
            subject: 'Collaborator Notification',
        );
    }
    /**
     * Build the message.
     */
    public function build()
    {
        return $this->subject('New Collaborator Request')
                    ->markdown('emails.collaborator');
    }

    /**
     * Get the message content definition.
     */
    //public function content(): Content
    //{
    //    return new Content(
    //        markdown: 'emails.collaborator',
    //    );
    //}

    /**
     * Get the attachments for the message.
     *
     * @return array<int, \Illuminate\Mail\Mailables\Attachment>
     */
    public function attachments(): array
    {
        return [];
    }
}
