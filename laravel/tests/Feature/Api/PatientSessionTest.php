<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use App\Models\Patient;
use App\Models\PatientSession;
Use App\Models\User;
use Tests\TestCase;

class PatientSessionTest extends TestCase
{
    /**
     * Test get all sessions.
     *
     * @return void
     */
    public function test_get_all_sessions()
    {
        // Create a user
        $user = User::factory()->create();
        $token = $user->createToken('testToken')->plainTextToken;
        $headers = ['Authorization' => "Bearer $token"];

        // Create multiple sessions
        PatientSession::factory()->count(5)->create();

        // Send get request
        $response = $this->json('GET', route('api.sessions.index'), [], $headers);
        $response->assertStatus(200)
            ->assertValid()
            ->assertJson([
                'success' => true,
                'data' => [],
                'message' => 'All sessions retrieved successfully.',
            ]);
        $this->assertCount(5, $response->json()['data']);
        $this->assertAuthenticated();
    }

    /**
     * Test get single session.
     *
     * @return void
     */
    public function test_get_a_single_session()
    {
        // Create a user
        $user = User::factory()->create();
        $token = $user->createToken('testToken')->plainTextToken;
        $headers = ['Authorization' => "Bearer $token"];

        // Create a session
        $session = PatientSession::factory()->create([
            'user_id' => $user->id,
        ]);

        // Send get request
        $response = $this->json('GET', route('api.sessions.show', ['session' => $session->id]), [], $headers);
        $response->assertStatus(200)
            ->assertValid()
            ->assertJson([
                'success' => true,
                'data' => [
                    'id' => $session->id,
                    'date' => $session->date->format('d-m-Y'),
                    'user_id' => $user->id,
                    'patient_id' => $session->patient_id,
                    'measurements' => [],
                ],
                'message' => 'Session retrieved successfully.',
            ]);
        $this->assertAuthenticated();
    }

    /**
     * Test create a new session.
     *
     * @return void
     */
    public function test_add_a_new_session()
    {
        // Create a user
        $user = User::factory()->create();
        $token = $user->createToken('testToken')->plainTextToken;
        $headers = ['Authorization' => "Bearer $token"];

        // Create a patient
        $patient = Patient::factory()->create();

        $data = [
            'date' => '01-01-2021',
            'patient_id' => $patient->id,
        ];

        // Send post request
        $response = $this->json('POST', route('api.sessions.store'), $data, $headers);
        $response->assertStatus(200)
            ->assertValid()
            ->assertJson([
                'success' => true,
                'data' => [
                    'date' => '01-01-2021',
                    'user_id' => $user->id,
                    'patient_id' => $patient->id,
                    'measurements' => [],
                ],
                'message' => 'Session created successfully.',
            ]);
        $this->assertAuthenticated();
    }

    /**
     * Test update a session.
     *
     * @return void
     */
    public function test_update_a_session()
    {
        // Create a user
        $user = User::factory()->create();
        $token = $user->createToken('testToken')->plainTextToken;
        $headers = ['Authorization' => "Bearer $token"];

        // Create a session
        $session = PatientSession::factory()->create([
            'user_id' => $user->id,
        ]);

        $data = [
            'date' => '01-01-2020',
            'patient_id' => $session->patient_id,
        ];

        // Send post request
        $response = $this->json('PUT', route('api.sessions.update', ['session' => $session->id]), $data, $headers);
        $response->assertStatus(200)
            ->assertValid()
            ->assertJson([
                'success' => true,
                'data' => [
                    'id' => $session->id,
                    'date' => '01-01-2020',
                    'user_id' => $user->id,
                    'patient_id' => $session->patient_id,
                    'measurements' => [],
                ],
                'message' => 'Session updated successfully.',
            ]);
        $this->assertAuthenticated();
    }

    /**
     * Test delete a session.
     *
     * @return void
     */
    public function test_delete_a_session()
    {
        // Create a user
        $user = User::factory()->create();
        $token = $user->createToken('testToken')->plainTextToken;
        $headers = ['Authorization' => "Bearer $token"];

        // Create a session
        $session = PatientSession::factory()->create([
            'user_id' => $user->id,
        ]);

        // Send post request
        $response = $this->json('DELETE', route('api.sessions.destroy', ['session' => $session->id]), [], $headers);
        $response->assertStatus(200)
            ->assertJson([
                'success' => true,
                'data' => [],
                'message' => 'Session deleted successfully.',
            ]);
        $this->assertAuthenticated();
    }

    /**
     * Test validation error when creating a new session.
     *
     * @return void
     */
    public function test_validation_error_when_creating_new_session()
    {
        // Create a user
        $user = User::factory()->create();
        $token = $user->createToken('testToken')->plainTextToken;
        $headers = ['Authorization' => "Bearer $token"];

        $data = [
            'date' => 'blabla',
            'patient_id' => 5,
        ];

        // Send post request
        $response = $this->json('POST', route('api.sessions.store'), $data, $headers);
        $response->assertStatus(422)
            ->assertJson([
                'success' => false,
                'message' => 'The given data was invalid.',
                'errors' => [
                    'date' => [
                        'The date is not a valid date.',
                    ],
                    'patient_id' => [
                        'The selected patient id is invalid.',
                    ],
                ],
            ]);
        $this->assertAuthenticated();
    }
}
