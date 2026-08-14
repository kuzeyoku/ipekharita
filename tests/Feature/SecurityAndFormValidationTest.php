<?php

declare(strict_types=1);

namespace Tests\Feature;

use Tests\TestCase;
use Illuminate\Foundation\Testing\RefreshDatabase;

class SecurityAndFormValidationTest extends TestCase
{
    use RefreshDatabase;
    /**
     * Test that OWASP security headers are present on all responses.
     */
    public function test_security_headers_are_attached(): void
    {
        $response = $this->get('/');

        $response->assertStatus(200);
        $response->assertHeader('X-Frame-Options', 'SAMEORIGIN');
        $response->assertHeader('X-Content-Type-Options', 'nosniff');
        $response->assertHeader('Referrer-Policy', 'strict-origin-when-cross-origin');
    }

    /**
     * Test that message submission validates required fields.
     */
    public function test_message_submission_requires_valid_data(): void
    {
        $response = $this->post(route('contact.submit'), []);

        $response->assertSessionHasErrors(['name', 'email', 'message']);
    }

    /**
     * Test that spam bots filling the honeypot field are rejected.
     */
    public function test_message_submission_rejects_honeypot_spam(): void
    {
        $response = $this->post(route('contact.submit'), [
            'name' => 'Spam Bot',
            'email' => 'bot@spammer.com',
            'message' => 'Buy cheap links now!',
            'website' => 'http://spam-link.com', // Honeypot filled by bot
        ]);

        $response->assertSessionHasErrors(['website']);
    }

    /**
     * Test successful message submission with valid input.
     */
    public function test_valid_message_submission_succeeds(): void
    {
        $response = $this->post(route('contact.submit'), [
            'name' => 'Test User',
            'email' => 'test@example.com',
            'phone' => '05551234567',
            'subject' => 'Bilgi Talebi',
            'message' => 'Projeniz hakkında detaylı bilgi almak istiyorum.',
        ]);

        $response->assertSessionHas('success');
    }
}
