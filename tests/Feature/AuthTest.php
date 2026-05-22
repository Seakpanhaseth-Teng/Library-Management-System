<?php

namespace Tests\Feature;

use App\Models\User;
use Illuminate\Auth\Notifications\ResetPassword;
use Illuminate\Auth\Notifications\VerifyEmail;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Notification;
use Tests\TestCase;

class AuthTest extends TestCase
{
    use RefreshDatabase;

    public function test_login_page_is_accessible(): void
    {
        $response = $this->get('/login');

        $response->assertStatus(200);
        $response->assertSee('Login');
    }

    public function test_register_page_is_accessible(): void
    {
        $response = $this->get('/register');

        $response->assertStatus(200);
        $response->assertSee('Register');
    }

    public function test_forgot_password_page_is_accessible(): void
    {
        $response = $this->get('/forgot-password');

        $response->assertStatus(200);
        $response->assertSee('Forgot Password');
    }

    public function test_user_can_register(): void
    {
        Notification::fake();

        $response = $this->post('/register', [
            'name' => 'John Doe',
            'email' => 'john@example.com',
            'password' => 'Password123!',
            'password_confirmation' => 'Password123!',
        ]);

        $response->assertRedirect('/verify-email');

        $this->assertAuthenticated();
        $this->assertDatabaseHas('users', [
            'email' => 'john@example.com',
            'name' => 'John Doe',
        ]);

        $user = User::where('email', 'john@example.com')->first();
        $this->assertNotNull($user);
        $this->assertFalse($user->hasVerifiedEmail());

        Notification::assertSentTo($user, VerifyEmail::class);
    }

    public function test_user_cannot_register_with_mismatched_passwords(): void
    {
        $response = $this->post('/register', [
            'name' => 'John Doe',
            'email' => 'john@example.com',
            'password' => 'Password123!',
            'password_confirmation' => 'DifferentPassword123!',
        ]);

        $response->assertSessionHasErrors('password');
        $this->assertGuest();
    }

    public function test_user_cannot_register_with_duplicate_email(): void
    {
        User::factory()->create(['email' => 'john@example.com']);

        $response = $this->post('/register', [
            'name' => 'John Doe',
            'email' => 'john@example.com',
            'password' => 'Password123!',
            'password_confirmation' => 'Password123!',
        ]);

        $response->assertSessionHasErrors('email');
    }

    public function test_user_can_login(): void
    {
        $user = User::factory()->create([
            'email' => 'john@example.com',
            'password' => bcrypt('Password123!'),
        ]);

        $response = $this->post('/login', [
            'email' => 'john@example.com',
            'password' => 'Password123!',
        ]);

        $response->assertRedirect('/all/books');
        $this->assertAuthenticatedAs($user);
    }

    public function test_user_cannot_login_with_wrong_password(): void
    {
        User::factory()->create([
            'email' => 'john@example.com',
            'password' => bcrypt('Password123!'),
        ]);

        $response = $this->post('/login', [
            'email' => 'john@example.com',
            'password' => 'WrongPassword123!',
        ]);

        $response->assertSessionHasErrors('email');
        $this->assertGuest();
    }

    public function test_authenticated_user_can_access_books(): void
    {
        $user = User::factory()->create();

        $response = $this->actingAs($user)->get('/all/books');

        $response->assertStatus(200);
    }

    public function test_guest_cannot_access_books(): void
    {
        $response = $this->get('/all/books');

        $response->assertRedirect('/login');
    }

    public function test_verify_email_notice_shows_for_unverified_user(): void
    {
        $user = User::factory()->unverified()->create();

        $response = $this->actingAs($user)->get('/verify-email');

        $response->assertStatus(200);
        $response->assertSee('Verify Your Email');
    }

    public function test_verified_user_is_redirected_from_verify_notice(): void
    {
        $user = User::factory()->create(['email_verified_at' => now()]);

        $response = $this->actingAs($user)->get('/verify-email');

        $response->assertRedirect('/all/books');
    }

    public function test_email_can_be_verified(): void
    {
        $user = User::factory()->unverified()->create();

        $this->actingAs($user);

        $verificationUrl = $user->markEmailAsVerified();

        $user->email_verified_at = null;
        $user->save();

        $verificationUrl = \Illuminate\Support\Facades\URL::temporarySignedRoute(
            'verification.verify',
            now()->addMinutes(60),
            ['id' => $user->id, 'hash' => sha1($user->email)]
        );

        $response = $this->get($verificationUrl);

        $response->assertRedirect('/all/books');
        $this->assertTrue($user->fresh()->hasVerifiedEmail());
    }

    public function test_forgot_password_sends_reset_link(): void
    {
        Notification::fake();

        $user = User::factory()->create([
            'email' => 'john@example.com',
        ]);

        $response = $this->post('/forgot-password', [
            'email' => 'john@example.com',
        ]);

        $response->assertSessionHas('status');
        Notification::assertSentTo($user, ResetPassword::class);
    }

    public function test_password_can_be_reset(): void
    {
        $user = User::factory()->create([
            'email' => 'john@example.com',
            'password' => bcrypt('OldPassword123!'),
        ]);

        $token = \Illuminate\Support\Facades\Password::createToken($user);

        $response = $this->post('/reset-password', [
            'token' => $token,
            'email' => 'john@example.com',
            'password' => 'NewPassword123!',
            'password_confirmation' => 'NewPassword123!',
        ]);

        $response->assertRedirect('/login');
        $this->assertTrue(\Illuminate\Support\Facades\Hash::check('NewPassword123!', $user->fresh()->password));
    }

    public function test_logout_works(): void
    {
        $user = User::factory()->create();

        $this->actingAs($user);

        $response = $this->post('/logout');

        $response->assertRedirect('/login');
        $this->assertGuest();
    }

    public function test_verify_email_banner_appears_in_layout(): void
    {
        $user = User::factory()->unverified()->create();

        $response = $this->actingAs($user)->get('/all/books');

        $response->assertSee('Please verify your email');
    }

    public function test_verify_email_banner_hidden_for_verified_user(): void
    {
        $user = User::factory()->create(['email_verified_at' => now()]);

        $response = $this->actingAs($user)->get('/all/books');

        $response->assertDontSee('Please verify your email');
    }

    public function test_forgot_password_link_on_login_page(): void
    {
        $response = $this->get('/login');

        $response->assertSee('Forgot Password');
    }
}