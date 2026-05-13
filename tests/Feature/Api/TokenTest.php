<?php

namespace Tests\Feature\Api;

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class TokenTest extends TestCase
{
    use RefreshDatabase;

    public function test_user_can_obtain_token_with_correct_credentials(): void
    {
        $user = User::factory()->create();

        $response = $this->postJson('/api/v1/tokens', [
            'username' => $user->username,
            'password' => 'password',
        ]);

        $response->assertStatus(200)->assertJsonStructure(['token']);
    }

    public function test_token_is_a_non_empty_string(): void
    {
        $user = User::factory()->create();

        $response = $this->postJson('/api/v1/tokens', [
            'username' => $user->username,
            'password' => 'password',
        ]);

        $this->assertNotEmpty($response->json('token'));
    }

    public function test_token_request_fails_with_wrong_password(): void
    {
        $user = User::factory()->create();

        $this->postJson('/api/v1/tokens', [
            'username' => $user->username,
            'password' => 'wrong-password',
        ])->assertStatus(422)->assertJsonValidationErrors(['username']);
    }

    public function test_token_request_fails_with_nonexistent_username(): void
    {
        $this->postJson('/api/v1/tokens', [
            'username' => 'nobody',
            'password' => 'password',
        ])->assertStatus(422)->assertJsonValidationErrors(['username']);
    }

    public function test_token_request_fails_without_username(): void
    {
        $this->postJson('/api/v1/tokens', [
            'password' => 'password',
        ])->assertStatus(422)->assertJsonValidationErrors(['username']);
    }

    public function test_token_request_fails_without_password(): void
    {
        $user = User::factory()->create();

        $this->postJson('/api/v1/tokens', [
            'username' => $user->username,
        ])->assertStatus(422)->assertJsonValidationErrors(['password']);
    }
}
