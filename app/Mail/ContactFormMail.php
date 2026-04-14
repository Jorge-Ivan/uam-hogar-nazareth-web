<?php

declare(strict_types=1);

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Address;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;

final class ContactFormMail extends Mailable
{
    use Queueable;
    use SerializesModels;

    /**
     * @param array{name: string, email: string, phone: string|null, message: string} $data
     */
    public function __construct(
        public readonly array $data,
        public readonly string $fromName,
        public readonly string $fromAddress,
    ) {}

    public function envelope(): Envelope
    {
        return new Envelope(
            from: new Address($this->fromAddress, $this->fromName),
            subject: 'Nuevo mensaje de contacto — ' . $this->data['name'],
        );
    }

    public function content(): Content
    {
        return new Content(view: 'emails.contact-form');
    }
}
