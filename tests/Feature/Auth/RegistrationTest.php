<?php

namespace Tests\Feature\Auth;

use App\Models\User;
use Illuminate\Auth\Events\Registered;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Event;
use Tests\TestCase;

class RegistrationTest extends TestCase
{
    use RefreshDatabase;

    public function test_registration_screen_can_be_rendered(): void
    {
        $this->get('/register')->assertStatus(200);
    }

    public function test_new_users_can_register(): void
    {
        $response = $this->post('/register', [
            'username'              => 'john_doe',
            'email'                 => 'john@example.com',
            'password'              => 'Password1!',
            'password_confirmation' => 'Password1!',
        ]);

        $this->assertAuthenticated();
        $response->assertRedirect(route('dashboard', absolute: false));
        $this->assertDatabaseHas('users', ['username' => 'john_doe', 'email' => 'john@example.com']);
    }

    public function test_registered_event_is_fired_on_registration(): void
    {
        Event::fake();

        $this->post('/register', [
            'username'              => 'jane_doe',
            'email'                 => 'jane@example.com',
            'password'              => 'Password1!',
            'password_confirmation' => 'Password1!',
        ]);

        Event::assertDispatched(Registered::class);
    }

    public function test_registration_fails_without_username(): void
    {
        $this->post('/register', [
            'email'                 => 'john@example.com',
            'password'              => 'Password1!',
            'password_confirmation' => 'Password1!',
        ])->assertSessionHasErrors(['username']);
    }

    public function test_registration_fails_with_username_too_long(): void
    {
        $this->post('/register', [
            'username'              => str_repeat('a', 21),
            'email'                 => 'john@example.com',
            'password'              => 'Password1!',
            'password_confirmation' => 'Password1!',
        ])->assertSessionHasErrors(['username']);
    }

    public function test_registration_fails_with_duplicate_username(): void
    {
        User::factory()->create(['username' => 'taken']);

        $this->post('/register', [
            'username'              => 'taken',
            'email'                 => 'other@example.com',
            'password'              => 'Password1!',
            'password_confirmation' => 'Password1!',
        ])->assertSessionHasErrors(['username']);
    }

    public function test_registration_fails_without_email(): void
    {
        $this->post('/register', [
            'username'              => 'john_doe',
            'password'              => 'Password1!',
            'password_confirmation' => 'Password1!',
        ])->assertSessionHasErrors(['email']);
    }

    public function test_registration_fails_with_invalid_email_format(): void
    {
        $this->post('/register', [
            'username'              => 'john_doe',
            'email'                 => 'not-an-email',
            'password'              => 'Password1!',
            'password_confirmation' => 'Password1!',
        ])->assertSessionHasErrors(['email']);
    }

    public function test_registration_fails_with_duplicate_email(): void
    {
        User::factory()->create(['email' => 'taken@example.com']);

        $this->post('/register', [
            'username'              => 'john_doe',
            'email'                 => 'taken@example.com',
            'password'              => 'Password1!',
            'password_confirmation' => 'Password1!',
        ])->assertSessionHasErrors(['email']);
    }

    public function test_registration_fails_without_password(): void
    {
        $this->post('/register', [
            'username' => 'john_doe',
            'email'    => 'john@example.com',
        ])->assertSessionHasErrors(['password']);
    }

    public function test_registration_fails_with_password_confirmation_mismatch(): void
    {
        $this->post('/register', [
            'username'              => 'john_doe',
            'email'                 => 'john@example.com',
            'password'              => 'Password1!',
            'password_confirmation' => 'DifferentPass1!',
        ])->assertSessionHasErrors(['password']);
    }
}
