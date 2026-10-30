<?php

namespace Tests\Feature;

use App\Mail\RegistrationConfirmation;
use App\Models\AnonymousRegistration;
use App\Services\TicketService;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Mail;
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
        $this->assertArrayNotHasKey('email', $registration->getAttributes());
        $response->assertDontSee('guest@example.com');

        Mail::assertSent(RegistrationConfirmation::class, function (RegistrationConfirmation $mail) use ($ticketId): bool {
            return $mail->hasTo('guest@example.com') && $mail->ticket['ticket_id'] === $ticketId;
        });
        Mail::assertSentCount(1);

        // Test ticket pass page
        $ticketResponse = $this->get('/ticket/'.$ticketId);
        $ticketResponse->assertStatus(200);
        $ticketResponse->assertSee($ticketId);
        $ticketResponse->assertSee('CyberDome Arena');
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
        $response->assertSessionHas('success_message', fn (string $message): bool => str_contains($message, 'confirmation email has been sent'));
        Mail::assertSent(RegistrationConfirmation::class, 'guest@example.com');
        $this->followRedirects($response)->assertOk()->assertSee('confirmation email has been sent');
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
            ->assertJsonPath('message', 'Your reservation is confirmed, but we could not send the confirmation email. Please save your ticket now.')
            ->assertDontSee('SMTP unavailable');
        $this->assertDatabaseCount('anonymous_registrations', 1);
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
        $mail = new RegistrationConfirmation($ticket);

        $mail->assertHasSubject('NOVA HORIZON - Registration Confirmation');
        foreach ([$ticket['ticket_id'], $ticket['nickname'], $concert['date_formatted'], $concert['venue'], $concert['gate_code'], $ticket['view_url'], $ticket['download_url']] as $content) {
            $mail->assertSeeInHtml($content);
            $mail->assertSeeInText($content);
        }
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
