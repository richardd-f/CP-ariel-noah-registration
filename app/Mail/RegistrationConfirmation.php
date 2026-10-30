<?php

namespace App\Mail;

use Endroid\QrCode\ErrorCorrectionLevel;
use Endroid\QrCode\QrCode;
use Endroid\QrCode\Writer\PngWriter;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;

class RegistrationConfirmation extends Mailable
{
    /**
     * @param  array<string, mixed>  $ticket
     */
    public function __construct(public array $ticket) {}

    /**
     * Get the message envelope.
     */
    public function envelope(): Envelope
    {
        return new Envelope(
            subject: $this->ticket['concert']['title'].' - Registration Confirmation',
        );
    }

    /**
     * Get the message content definition.
     */
    public function content(): Content
    {
        return new Content(
            view: 'emails.registration-confirmation',
            text: 'emails.registration-confirmation-text',
            with: [
                'qrCode' => (new PngWriter)->write(new QrCode(
                    data: 'TICKET:'.$this->ticket['ticket_id'].'|EVENT:NOVA_HORIZON_2026|GATE:ALPHA-09',
                    errorCorrectionLevel: ErrorCorrectionLevel::Medium,
                    size: 320,
                    margin: 32,
                ))->getString(),
            ],
        );
    }
}
