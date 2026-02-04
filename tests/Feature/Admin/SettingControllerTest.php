<?php

namespace Tests\Feature\Admin;

use App\Mail\MassNotification;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Mail;
use Tests\TestCase;

class SettingControllerTest extends TestCase
{
    use RefreshDatabase;

    public function test_send_notification_sends_emails()
    {
        Mail::fake();

        // Create admin user (active by default)
        $admin = User::factory()->create([
            'role' => 'admin',
            'email' => 'admin@example.com',
        ]);

        // Create active users
        $user1 = User::factory()->create(['active' => true, 'email' => 'user1@example.com']);
        $user2 = User::factory()->create(['active' => true, 'email' => 'user2@example.com']);
        // Inactive user should not receive email
        $user3 = User::factory()->create(['active' => false, 'email' => 'user3@example.com']);

        $response = $this->actingAs($admin)
            ->post('/admin/configuracoes/enviar-notificacao', [
                'subject' => 'Test Subject',
                'message' => '<p>Test Message</p>',
            ]);

        $response->assertRedirect();
        $response->assertSessionHas('success');

        // Admin (1) + User1 (1) + User2 (1) = 3 emails queued
        Mail::assertQueued(MassNotification::class, 3);

        // Ensure inactive user was not emailed
        // We iterate through all queued mails and ensure none match user3
        Mail::assertQueued(MassNotification::class, function ($mail) use ($user3) {
            return !$mail->hasTo($user3->email);
        });

        // Verify content and recipient for user1
        Mail::assertQueued(MassNotification::class, function ($mail) use ($user1) {
            return $mail->hasTo($user1->email) &&
                   $mail->subjectText === 'Test Subject' &&
                   $mail->htmlContent === '<p>Test Message</p>';
        });
    }
}
