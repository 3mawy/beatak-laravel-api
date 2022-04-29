<?php

namespace Tests\Feature\Auth;

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class AuthenticationTest extends TestCase
{
    use RefreshDatabase;

    public function test_users_can_authenticate_using_the_api()
    {
        $user = User::factory()->create();

        $response = $this->post('api/login', [
            'email' => $user->email,
            'password' => 'password',
        ]);
        $response
            ->assertStatus(200)
            ->assertJsonStructure([
                'data', 'meta'
            ]);
    }

    public function test_users_can_not_authenticate_with_invalid_password()
    {
        $user = User::factory()->create();

        $response= $this->post('api/login', [
            'email' => $user->email,
            'password' => 'wrong-password',
        ]);
        $response
            ->assertStatus(401);
        $this->assertGuest();
    }
}
