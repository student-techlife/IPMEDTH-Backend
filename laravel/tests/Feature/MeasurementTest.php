<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use App\Models\Measurement;
use App\Models\Patient;
use App\Models\Session;
use App\Models\User;
use Tests\TestCase;

class MeasurementTest extends TestCase
{
    /**
     * Test get all measurements.
     *
     * @return void
     */
    public function test_get_all_measurements()
    {
        // Create a user
        $user = User::factory()->create();
        $token = $user->createToken('testToken')->plainTextToken;
        $headers = ['Authorization' => "Bearer $token"];

        // Create multiple measurements
        Measurement::factory()->count(5)->create();

        // Send get request
        $response = $this->json('GET', route('api.measurements.index'), [], $headers);
        $response->assertStatus(200)
            ->assertValid()
            ->assertJson([
                'success' => true,
                'data' => [],
                'message' => 'All measurements retrieved successfully.',
            ]);
        $this->assertCount(5, $response->json()['data']);
        $this->assertAuthenticated();
    }

    /**
     * Test get single measurement.
     *
     * @return void
     */
    public function test_get_a_single_measurement()
    {
        // Create a user
        $user = User::factory()->create();
        $token = $user->createToken('testToken')->plainTextToken;
        $headers = ['Authorization' => "Bearer $token"];

        // Create a session
        $session = Session::factory()->create([
            'user_id' => $user->id,
        ]);

        // Create a measurement
        $measurement = Measurement::factory()->create([
            'user_id' => $user->id,
            'session_id' => $session->id,
        ]);

        // Send get request
        $response = $this->json('GET', route('api.measurements.show', ['measurement' => $measurement->id]), [], $headers);
        $response->assertStatus(200)
            ->assertValid()
            ->assertJson([
                'success' => true,
                'data' => [
                    'id' => $measurement->id,
                    'user_id' => $user->id,
                    'session_id' => $session->id,
                    'hand_view' => $measurement->hand_view,
                    'hand_type' => $measurement->hand_type,
                    'hand_score' => $measurement->hand_score,
                ],
                'message' => 'Measurement retrieved successfully.',
            ]);
        $this->assertAuthenticated();
    }

    /**
     * Test create a new measurement.
     *
     * @return void
     */
    public function test_add_a_new_measurement()
    {
        // Create a user
        $user = User::factory()->create();
        $token = $user->createToken('testToken')->plainTextToken;
        $headers = ['Authorization' => "Bearer $token"];

        // Create a session
        $session = Session::factory()->create([
            'user_id' => $user->id,
        ]);

        $data = [
            'session_id' => $session->id,
            'hand_type' => 'left',
            'hand_view' => 'thumb_side',
            'hand_score' => '0.85',
            'finger_thumb' => '{"finger_thumb": "blabla"}',
            'finger_index' => '{"finger_index": "blabla"}',
            'finger_middle' => '{"finger_middle": "blabla"}',
            'finger_4' => '{"finger_4": "blabla"}',
            'finger_5' => '{"finger_5": "blabla"}',
        ];

        // Send post request
        $response = $this->json('POST', route('api.measurements.store'), $data, $headers);
        $response->assertStatus(200)
            ->assertValid()
            ->assertJson([
                'success' => true,
                'data' => [
                    'user_id' => $user->id,
                    'session_id' => $session->id,
                    'hand_type' => 'left',
                    'hand_view' => 'thumb_side',
                    'hand_score' => '0.85',
                    'finger_thumb' => '{"finger_thumb": "blabla"}',
                ],
                'message' => 'Measurement created successfully.',
            ]);
        $this->assertAuthenticated();
    }

    /**
     * Test update a measurement.
     *
     * @return void
     */
    public function test_update_a_measurement()
    {
        // Create a user
        $user = User::factory()->create();
        $token = $user->createToken('testToken')->plainTextToken;
        $headers = ['Authorization' => "Bearer $token"];

        // Create a session
        $sessions = Session::factory()->count(2)->create([
            'user_id' => $user->id,
        ]);

        // Create a measurement
        $measurement = Measurement::factory()->create([
            'user_id' => $user->id,
            'session_id' => $sessions[0]->id,
        ]);

        $data = [
            'id' => $measurement->id,
            'session_id' => $sessions[1]->id,
            'hand_type' => 'right',
            'hand_view' => 'pink_side',
            'hand_score' => '0.55',
            'finger_thumb' => '{"finger_thumb": "working"}',
            'finger_index' => '{"finger_index": "blabla"}',
            'finger_middle' => '{"finger_middle": "blabla"}',
            'finger_4' => '{"finger_4": "blabla"}',
            'finger_5' => '{"finger_5": "blabla"}',
        ];

        // Send post request
        $response = $this->json('PUT', route('api.measurements.update', ['measurement' => $measurement->id]), $data, $headers);
        $response->assertStatus(200)
            ->assertValid()
            ->assertJson([
                'success' => true,
                'data' => [
                    'id' => $measurement->id,
                    'user_id' => $user->id,
                    'session_id' => $sessions[1]->id,
                    'hand_type' => 'right',
                    'hand_view' => 'pink_side',
                    'hand_score' => '0.55',
                    'finger_thumb' => '{"finger_thumb": "working"}',
                ],
                'message' => 'Measurement updated successfully.',
            ]);
        $this->assertAuthenticated();
    }

    /**
     * Test delete a measurement.
     *
     * @return void
     */
    public function test_delete_a_measurement()
    {
        // Create a user
        $user = User::factory()->create();
        $token = $user->createToken('testToken')->plainTextToken;
        $headers = ['Authorization' => "Bearer $token"];

        // Create a session
        $session = Session::factory()->create([
            'user_id' => $user->id,
        ]);

        // Create a measurement
        $measurement = Measurement::factory()->create([
            'user_id' => $user->id,
            'session_id' => $session->id,
        ]);

        // Send post request
        $response = $this->json('DELETE', route('api.measurements.destroy', ['measurement' => $measurement->id]), [], $headers);
        $response->assertStatus(200)
            ->assertValid()
            ->assertJson([
                'success' => true,
                'data' => [],
                'message' => 'Measurement deleted successfully.',
            ]);
        $this->assertAuthenticated();
    }

    /**
     * Test validation error when creating a new measurement.
     *
     * @return void
     */
    public function test_validation_error_when_creating_new_measurement()
    {
        // Create a user
        $user = User::factory()->create();
        $token = $user->createToken('testToken')->plainTextToken;
        $headers = ['Authorization' => "Bearer $token"];

        // Create a session
        $session = Session::factory()->create([
            'user_id' => $user->id,
        ]);

        $data = [
            'session_id' => $session->id,
            'hand_type' => 'up',
            'hand_view' => 'side',
            'hand_score' => '4',
            'finger_thumb' => '{"finger_thumb": "blabla"}',
        ];

        // Send post request
        $response = $this->json('POST', route('api.measurements.store'), $data, $headers);
        $response->assertStatus(422)
            ->assertJson([
                'success' => false,
                'message' => 'The given data was invalid.',
                'errors' => [
                    'hand_type' => [
                        'The selected hand type is invalid, choose between left or right.',
                    ],
                    'hand_view' => [
                        'The selected hand view is invalid, choose between thumb_side, pink_side, finger_side or back_side.',
                    ],
                    'hand_score' => [
                        'The hand score must not be greater than 1.',
                    ],
                    'finger_index' => [
                        'The finger index field is required.',
                    ],
                ],
            ]);
        $this->assertAuthenticated();
    }
}
