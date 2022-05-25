<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
Use App\Models\User;
use Tests\TestCase;

class AuthTest extends TestCase
{
    /**
     * Test if you can register a new user.
     *
     * @return void
     */
    public function test_user_can_register()
    {
        // User's data
        $data = [
            'email' => 'test@ipmdeth.nl',
            'name' => 'Test',
            'password' => 'secret1234',
        ];
        // Send post request
        $response = $this->json('POST', route('api.auth.register'), $data);
        $response->assertStatus(200)
            ->assertValid()
            ->assertJson([
                'success' => true,
                'message' => 'User registered successfully.',
            ]);
    }

    /**
     * Test if you can login a user.
     *
     * @return void
     */
    public function test_user_can_login()
    {
        $user = User::factory()->create();
        $data = [
            'email' => $user->email,
            'password' => 'password',
        ];
        // Send post request
        $response = $this->json('POST', route('api.auth.login'), $data);
        $response->assertStatus(200)
            ->assertValid()
            ->assertJson([
                'success' => true,
                'message' => 'User logged in successfully.',
            ]);
        $this->assertAuthenticated();
    }

    /**
     * Test if you can logout a user.
     *
     * @return void
     */
    public function test_user_can_logout()
    {
        $user = User::factory()->create();
        $token = $user->createToken('testToken')->plainTextToken;
        $headers = ['Authorization' => "Bearer $token"];

        // Send post request
        $response = $this->json('POST', route('api.auth.logout'), [], $headers);
        $response->assertStatus(200)
            ->assertJson([
                'success' => true,
                'message' => 'User logged out successfully.',
            ]);
    }

    /**
     * Test if you can get the user's info.
     *
     * @return void
     */
    public function test_user_can_get_userinfo()
    {
        $user = User::factory()->create();
        $token = $user->createToken('testToken')->plainTextToken;
        $headers = ['Authorization' => "Bearer $token"];

        // Send post request
        $response = $this->json('GET', route('api.auth.user'), [], $headers);
        $response->assertStatus(200)
            ->assertJson([
                'success' => true,
                'data' => [
                    'id' => $user->id,
                    'name' => $user->name,
                    'email' => $user->email,
                ],
                'message' => 'User info retrieved successfully.',
            ]);
    }

    /**
     * Test validation on register.
     *
     * @return void
     */
    public function test_validation_user_register()
    {
        // User's data
        $data = [
            'email' => 'test',
            'name' => '',
            'password' => '123',
        ];
        // Send post request
        $response = $this->json('POST', route('api.auth.register'), $data);
        $response->assertStatus(422)
            ->assertJson([
                'success' => false,
                'message' => 'Validation Error.',
                'details' => [
                    'email' => ['The email must be a valid email address.'],
                    'name' => ['The name field is required.'],
                    'password' => ['The password must be at least 6 characters.'],
                ],
            ]);
    }

    /**
     * Test login validation with wrong credentials.
     *
     * @return void
     */
    public function test_validation_login_wrong_credentials()
    {
        $user = User::factory()->create();
        $data = [
            'email' => $user->email,
            'password' => 'wrongpassword',
        ];
        // Send post request
        $response = $this->json('POST', route('api.auth.login'), $data);
        $response->assertStatus(401)
            ->assertUnauthorized()
            ->assertJson([
                'success' => false,
                'message' => 'These credentials do not match our records.',
            ]);
        $this->assertGuest();
    }
}
