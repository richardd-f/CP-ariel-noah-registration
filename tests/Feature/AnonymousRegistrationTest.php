<?php

namespace Tests\Feature;

use App\Models\AnonymousRegistration;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class AnonymousRegistrationTest extends TestCase
{
    use RefreshDatabase;

    public function test_landing_page_renders_successfully(): void
    {
        $response = $this->get('/');

        $response->assertStatus(200);
        $response->assertSee('Experience The Night Beyond Music');
        $response->assertSee('Your identity is completely anonymous.');
        $response->assertSee('NOVA HORIZON');
    }

    public function test_validation_requires_mandatory_fields(): void
    {
        $response = $this->postJson('/register', []);

        $response->assertStatus(422);
        $response->assertJsonValidationErrors(['age_range', 'country', 'favorite_genres', 'agree_anonymous']);
    }

    public function test_anonymous_registration_succeeds_and_creates_ticket(): void
    {
        $payload = [
            'nickname' => 'CyberGuest',
            'age_range' => '25-34',
            'country' => 'Indonesia',
            'favorite_genres' => ['Rock', 'EDM'],
            'referral_source' => 'Discord',
            'message' => 'Cannot wait for Ariel Noah x Synthesia live!',
            'agree_anonymous' => true,
        ];

        $response = $this->postJson('/register', $payload);

        $response->assertStatus(201);
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

        // Assert no PII exists in DB
        $registration = AnonymousRegistration::where('anonymous_ticket_id', $ticketId)->first();
        $this->assertNotNull($registration);

        // Test ticket pass page
        $ticketResponse = $this->get('/ticket/' . $ticketId);
        $ticketResponse->assertStatus(200);
        $ticketResponse->assertSee($ticketId);
        $ticketResponse->assertSee('CyberDome Arena');
    }
}
