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
     * @param  array<string, mixed>  $registrationDetails
     */
    public function __construct(public array $ticket, public array $registrationDetails) {}

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
                'registrationRows' => [
                    'Ticket ID' => $this->ticket['ticket_id'],
                    'Registered at' => $this->registrationDetails['registered_at'],
                    'Email address' => $this->registrationDetails['email'],
                    'Alias / nickname' => $this->registrationDetails['nickname'] ?? 'Not provided',
                    'Age range' => $this->registrationDetails['age_range'],
                    'Country of residence' => $this->registrationDetails['country'],
                    'Favorite music genres' => implode(', ', $this->registrationDetails['favorite_genres']),
                    'Referral source' => $this->registrationDetails['referral_source'] ?? 'Not provided',
                    'Message / song request' => $this->registrationDetails['message'] ?? 'Not provided',
                    'Email use and ticket acknowledgement' => 'Accepted',
                ],
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
