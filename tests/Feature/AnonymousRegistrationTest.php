<?php

namespace Tests\Feature;

use App\Mail\RegistrationConfirmation;
use App\Models\AnonymousRegistration;
use App\Services\TicketService;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\URL;
use Symfony\Component\Mailer\Exception\TransportException;
use Tests\TestCase;

class AnonymousRegistrationTest extends TestCase
{
    use RefreshDatabase;

    public function test_landing_page_renders_successfully(): void
    {
        $response = $this->get('/');

        $response->assertStatus(200);
        $response->assertSee('Experience The Night Beyond Music');
        $response->assertSee('Your email is used for confirmation only.');
        $response->assertSee('type="email"', false);
        $response->assertDontSee('No account. No email.');
        $response->assertSee('NOVA HORIZON');
    }

    public function test_validation_requires_mandatory_fields(): void
    {
        Mail::fake();

        $response = $this->postJson('/register', []);

        $response->assertStatus(422);
        $response->assertJsonValidationErrors(['email', 'age_range', 'country', 'favorite_genres', 'agree_anonymous']);
        $this->assertDatabaseCount('anonymous_registrations', 0);
        Mail::assertNothingSent();
    }

    public function test_anonymous_registration_succeeds_and_creates_ticket(): void
    {
        Mail::fake();

        $response = $this->postJson('/register', $this->registrationPayload());

        $response->assertStatus(201);
        $response->assertJsonPath('email_sent', true);
        $response->assertJsonStructure([
            'success',
            'message',
            'ticket' => [
                'ticket_id',
                'nickname',
                'age_range',
                'country',
                'favorite_genres',
                'registered_at',
                'concert',
                'view_url',
                'download_url',
            ],
        ]);

        $ticketId = $response->json('ticket.ticket_id');
        $this->assertStringStartsWith('ANON-', $ticketId);

        $this->assertDatabaseHas('anonymous_registrations', [
            'anonymous_ticket_id' => $ticketId,
            'nickname' => 'CyberGuest',
            'age_range' => '25-34',
            'country' => 'Indonesia',
            'agreed_anonymous' => true,
        ]);

        $registration = AnonymousRegistration::where('anonymous_ticket_id', $ticketId)->first();
        $this->assertNotNull($registration);
        $this->assertNull($registration->confirmed_at);
        $this->assertArrayNotHasKey('email', $registration->getAttributes());
        $response->assertDontSee('guest@example.com');
        $response->assertDontSee('signature=');

        Mail::assertSent(RegistrationConfirmation::class, function (RegistrationConfirmation $mail) use ($ticketId): bool {
            return $mail->hasTo('guest@example.com') && $mail->ticket['ticket_id'] === $ticketId;
        });
        Mail::assertSentCount(1);

        $mail = Mail::sent(RegistrationConfirmation::class)->first();
        $this->assertEmpty($mail->cc);
        $this->assertEmpty($mail->bcc);
        $mail->assertSeeInHtml('Your registration details');
        $mail->assertSeeInText('Your registration details');
        foreach (['guest@example.com', 'CyberGuest', '25-34', 'Indonesia', 'Rock, EDM', 'Discord', 'Cannot wait for Ariel Noah x Synthesia live!', 'Accepted', $registration->created_at->toIso8601String()] as $detail) {
            $mail->assertSeeInHtml($detail);
            $mail->assertSeeInText($detail);
        }

        // Test ticket pass page
        $ticketResponse = $this->get('/ticket/'.$ticketId);
        $ticketResponse->assertStatus(200);
        $ticketResponse->assertSee($ticketId);
        $ticketResponse->assertSee('CyberDome Arena');
        $ticketResponse->assertSee('Awaiting email confirmation');
        $ticketResponse->assertDontSee('signature=');
        $ticketResponse->assertDontSee('guest@example.com');
        $this->get('/ticket/'.$ticketId.'/download')->assertOk()->assertDontSee('guest@example.com');
    }

    public function test_invalid_email_does_not_create_a_registration_or_send_mail(): void
    {
        Mail::fake();

        foreach (['not-an-email', str_repeat('a', 255).'@example.com', ['guest@example.com']] as $email) {
            $this->postJson('/register', array_replace($this->registrationPayload(), ['email' => $email]))
                ->assertUnprocessable()
                ->assertJsonValidationErrors('email');
        }

        $this->assertDatabaseCount('anonymous_registrations', 0);
        Mail::assertNothingSent();
    }

    public function test_classic_form_submission_sends_confirmation_and_redirects_with_feedback(): void
    {
        Mail::fake();

        $response = $this->post('/register', $this->registrationPayload());

        $response->assertRedirect();
        $response->assertSessionHas('success_ticket.ticket_id');
        $response->assertSessionHas('success_message', fn (string $message): bool => str_contains($message, 'awaiting confirmation'));
        Mail::assertSent(RegistrationConfirmation::class, 'guest@example.com');
        $this->followRedirects($response)->assertOk()->assertSee('awaiting confirmation');
    }

    public function test_ticket_is_preserved_when_confirmation_email_fails(): void
    {
        Mail::shouldReceive('to')->once()->with('guest@example.com')->andReturnSelf();
        Mail::shouldReceive('send')->once()->with(\Mockery::type(RegistrationConfirmation::class))
            ->andThrow(new TransportException('SMTP unavailable'));

        $response = $this->postJson('/register', $this->registrationPayload());

        $response->assertCreated()
            ->assertJsonPath('success', true)
            ->assertJsonPath('email_sent', false)
            ->assertJsonPath('message', 'Your registration has been saved, but we could not send the confirmation email. It remains unconfirmed. Please save your ticket ID and contact the organizer.')
            ->assertDontSee('SMTP unavailable');
        $this->assertDatabaseCount('anonymous_registrations', 1);
        $this->assertNull(AnonymousRegistration::first()->confirmed_at);
        $this->get($response->json('ticket.view_url'))->assertOk();
    }

    public function test_classic_form_preserves_the_ticket_and_mail_failure_warning(): void
    {
        Mail::shouldReceive('to')->once()->andReturnSelf();
        Mail::shouldReceive('send')->once()->andThrow(new TransportException('SMTP unavailable'));

        $response = $this->post('/register', $this->registrationPayload());

        $response->assertRedirect()
            ->assertSessionHas('success_ticket.ticket_id')
            ->assertSessionHas('success_message', fn (string $message): bool => str_contains($message, 'could not send'));
        $this->assertDatabaseCount('anonymous_registrations', 1);
    }

    public function test_confirmation_contains_event_details_and_ticket_links_in_html_and_text(): void
    {
        $concert = app(TicketService::class)->getConcertDetails();
        $ticket = [
            'ticket_id' => 'ANON-TEST123',
            'nickname' => 'Anonymous Guest',
            'concert' => $concert,
            'view_url' => route('ticket.show', 'ANON-TEST123'),
            'download_url' => route('ticket.download', 'ANON-TEST123'),
        ];
        $mail = new RegistrationConfirmation($ticket, $this->registrationDetails());

        $mail->assertHasSubject('NOVA HORIZON - Confirm your Registration');
        foreach ([$ticket['ticket_id'], $ticket['nickname'], $concert['date_formatted'], $concert['venue'], $concert['gate_code'], $ticket['view_url'], $mail->content()->with['confirmationUrl']] as $content) {
            $mail->assertSeeInHtml($content);
            $mail->assertSeeInText($content);
        }

        $mail->assertSeeInHtml('ANONYMOUS PASS ID');
        $mail->assertSeeInHtml('PENDING');
        $mail->assertSeeInHtml('Confirm my Registration');
        $mail->assertSeeInText($ticket['download_url']);
        $mail->assertDontSeeInHtml('Your reservation is confirmed.');
        $mail->assertDontSeeInText('is confirmed.');
    }

    public function test_confirmation_embeds_a_ticket_specific_png_and_escapes_the_guest_alias(): void
    {
        $concert = app(TicketService::class)->getConcertDetails();
        $ticket = [
            'ticket_id' => 'ANON-TEST123',
            'nickname' => '<script>alert("guest")</script>',
            'concert' => $concert,
            'view_url' => route('ticket.show', 'ANON-TEST123'),
            'download_url' => route('ticket.download', 'ANON-TEST123'),
        ];

        $details = array_replace($this->registrationDetails(), ['message' => '<img src=x onerror=alert(1)>'."\n".str_repeat('x', 900)]);
        $sent = Mail::mailer('array')->to('guest@example.com')->send(new RegistrationConfirmation($ticket, $details));
        $message = $sent->getSymfonySentMessage()->getOriginalMessage();
        $attachments = $message->getAttachments();

        $this->assertCount(1, $attachments);
        $this->assertSame('inline', $attachments[0]->getDisposition());
        $this->assertSame('image/png', $attachments[0]->getContentType());
        $this->assertSame('ticket-qr.png', $attachments[0]->getFilename());
        $this->assertStringContainsString('cid:'.$attachments[0]->getContentId(), $message->getHtmlBody());
        $this->assertStringContainsString(e($ticket['nickname']), $message->getHtmlBody());
        $this->assertStringNotContainsString('<script>', $message->getHtmlBody());
        $this->assertStringContainsString(e($details['message']), $message->getHtmlBody());
        $this->assertStringNotContainsString('<img src=x', $message->getHtmlBody());
        $this->assertStringContainsString($details['message'], $message->getTextBody());
        $this->assertStringContainsString($ticket['ticket_id'], $message->getTextBody());
        $this->assertStringNotContainsString('cid:', $message->getTextBody());

        $png = $attachments[0]->getBody();
        $this->assertSame(IMAGETYPE_PNG, getimagesizefromstring($png)[2]);

        $otherMail = new RegistrationConfirmation(array_replace($ticket, ['ticket_id' => 'ANON-OTHER12']), $details);
        $this->assertNotSame($png, $otherMail->content()->with['qrCode']);
    }

    public function test_confirmation_shows_when_optional_registration_fields_were_not_provided(): void
    {
        Mail::fake();
        $payload = $this->registrationPayload();
        unset($payload['nickname'], $payload['referral_source'], $payload['message']);

        $this->postJson('/register', $payload)->assertCreated()->assertJsonPath('email_sent', true);

        $mail = Mail::sent(RegistrationConfirmation::class)->first();
        $mail->assertSeeInHtml('Not provided');
        foreach (['Alias / nickname', 'Referral source', 'Message / song request'] as $label) {
            $mail->assertSeeInText($label.': Not provided');
        }
    }

    public function test_email_link_confirms_the_registration_and_displays_the_confirmation(): void
    {
        Mail::fake();
        $this->freezeTime();

        $response = $this->postJson('/register', $this->registrationPayload() + ['confirmed_at' => '2020-01-01 00:00:00']);
        $registration = AnonymousRegistration::firstOrFail();
        $this->assertNull($registration->confirmed_at);

        $mail = Mail::sent(RegistrationConfirmation::class)->first();
        $confirmationUrl = $mail->content()->with['confirmationUrl'];
        $this->call('HEAD', $confirmationUrl)->assertRedirect();
        $this->assertNull($registration->fresh()->confirmed_at);
        $confirmation = $this->get($confirmationUrl)->assertRedirect($response->json('ticket.view_url'));

        $this->assertSame(now()->toDateTimeString(), $registration->fresh()->confirmed_at->toDateTimeString());
        $this->followRedirects($confirmation)->assertOk()->assertSee('Registration confirmed')->assertSee('CONFIRMED');
        $this->get($response->json('ticket.download_url'))->assertOk()->assertSee('Registration confirmed');
        $this->assertDatabaseCount('anonymous_registrations', 1);
        Mail::assertSentCount(1);
    }

    public function test_repeated_confirmation_preserves_the_original_confirmation_time(): void
    {
        Mail::fake();
        $this->freezeTime();
        $this->postJson('/register', $this->registrationPayload())->assertCreated();
        $confirmationUrl = Mail::sent(RegistrationConfirmation::class)->first()->content()->with['confirmationUrl'];

        $this->get($confirmationUrl)->assertRedirect();
        $registration = AnonymousRegistration::firstOrFail();
        $confirmedAt = $registration->confirmed_at->toIso8601String();
        $updatedAt = $registration->updated_at->toIso8601String();

        $this->travel(1)->hours();
        $this->get($confirmationUrl)->assertRedirect();

        $this->assertSame($confirmedAt, $registration->fresh()->confirmed_at->toIso8601String());
        $this->assertSame($updatedAt, $registration->fresh()->updated_at->toIso8601String());
        $this->assertDatabaseCount('anonymous_registrations', 1);
    }

    public function test_a_ticket_id_without_an_email_signature_cannot_confirm_registration(): void
    {
        Mail::fake();
        $response = $this->postJson('/register', $this->registrationPayload())->assertCreated();

        $this->get(route('registration.confirm', $response->json('ticket.ticket_id')))->assertForbidden();

        $this->assertNull(AnonymousRegistration::firstOrFail()->confirmed_at);
    }

    public function test_changing_the_ticket_id_invalidates_the_confirmation_link(): void
    {
        Mail::fake();
        $first = $this->postJson('/register', $this->registrationPayload())->assertCreated();
        $second = $this->postJson('/register', $this->registrationPayload())->assertCreated();
        $confirmationUrl = Mail::sent(RegistrationConfirmation::class)->first()->content()->with['confirmationUrl'];
        $tamperedUrl = str_replace($first->json('ticket.ticket_id'), $second->json('ticket.ticket_id'), $confirmationUrl);

        $this->get($tamperedUrl)->assertForbidden();

        $this->assertSame(0, AnonymousRegistration::whereNotNull('confirmed_at')->count());
    }

    public function test_confirmation_of_an_unknown_registration_returns_not_found(): void
    {
        $this->get(URL::signedRoute('registration.confirm', ['ticketId' => 'ANON-MISSING']))->assertNotFound();

        $this->assertDatabaseCount('anonymous_registrations', 0);
    }

    /**
     * @return array<string, mixed>
     */
    private function registrationDetails(): array
    {
        return $this->registrationPayload() + ['registered_at' => '2026-10-30T05:30:00+00:00'];
    }

    /**
     * @return array<string, mixed>
     */
    private function registrationPayload(): array
    {
        return [
            'email' => 'guest@example.com',
            'nickname' => 'CyberGuest',
            'age_range' => '25-34',
            'country' => 'Indonesia',
            'favorite_genres' => ['Rock', 'EDM'],
            'referral_source' => 'Discord',
            'message' => 'Cannot wait for Ariel Noah x Synthesia live!',
            'agree_anonymous' => true,
        ];
    }
}
