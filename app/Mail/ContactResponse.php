<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;
use App\Models\Contact;

class ContactResponse extends Mailable
{
    use Queueable, SerializesModels;

    /**
     * Create a new message instance.
     */
    
    public $contact;
    
    public function __construct(Contact $contact)
    {
        $this->contact = $contact;
    }
    
    public function build()
    {
        return $this->subject('Response to Your Contact Message')
                    ->markdown('emails.contact-response')
                    ->with([
                        'contact' => $this->contact,
                    ]);
    }

    /**
     * Get the message envelope.
     */
    public function envelope(): Envelope
    {
        return new Envelope(
            subject: 'Contact Response',
        );
    }

    /**
     * Get the message content definition.
     */
    //public function content(): Content
    //{
    //    return new Content(
    //        view: 'view.name',
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
