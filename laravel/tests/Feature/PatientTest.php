<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use App\Models\Patient;
use App\Models\User;
use Tests\TestCase;

class PatientTest extends TestCase
{
    /**
     * Test get all patients.
     *
     * @return void
     */
    public function test_get_all_patients()
    {
        // Create a user
        $user = User::factory()->create();
        $token = $user->createToken('testToken')->plainTextToken;
        $headers = ['Authorization' => "Bearer $token"];

        // Create multiple patients
        Patient::factory()->count(5)->create();

        // Send get request
        $response = $this->json('GET', route('api.patients.index'), [], $headers);
        $response->assertStatus(200)
            ->assertValid()
            ->assertJson([
                'success' => true,
                'data' => [],
                'message' => 'All patients retrieved successfully.',
            ]);
        $this->assertCount(5, $response->json()['data']);
        $this->assertAuthenticated();
    }

    /**
     * Test get single patient.
     *
     * @return void
     */
    public function test_get_a_single_patient()
    {
        // Create a user
        $user = User::factory()->create();
        $token = $user->createToken('testToken')->plainTextToken;
        $headers = ['Authorization' => "Bearer $token"];

        // Create a patient
        $patient = Patient::factory()->create();

        // Send get request
        $response = $this->json('GET', route('api.patients.show', ['patient' => $patient->id]), [], $headers);
        $response->assertStatus(200)
            ->assertValid()
            ->assertJson([
                'success' => true,
                'data' => [
                    'id' => 1,
                    'name' => $patient->name,
                    'date_of_birth' => $patient->date_of_birth->format('d-m-Y'),
                    'email' => $patient->email,
                    'sessions' => [],
                ],
                'message' => 'Patient retrieved successfully.',
            ]);
        $this->assertAuthenticated();
    }

    /**
     * Test create a new patient.
     *
     * @return void
     */
    public function test_add_a_new_patient()
    {
        // Create a user
        $user = User::factory()->create();
        $token = $user->createToken('testToken')->plainTextToken;
        $headers = ['Authorization' => "Bearer $token"];

        $data = [
            'name' => 'New Patient',
            'date_of_birth' => '01-01-2002',
            'email' => 'test@ipmedth.nl',
        ];

        // Send post request
        $response = $this->json('POST', route('api.patients.store'), $data, $headers);
        $response->assertStatus(200)
            ->assertValid()
            ->assertJson([
                'success' => true,
                'data' => [
                    'id' => 1,
                    'name' => $data['name'],
                    'date_of_birth' => $data['date_of_birth'],
                    'email' => $data['email'],
                    'sessions' => [],
                ],
                'message' => 'Patient created successfully.',
            ]);
        $this->assertAuthenticated();
    }

    /**
     * Test update a patient.
     *
     * @return void
     */
    public function test_update_a_patient()
    {
        // Create a user
        $user = User::factory()->create();
        $token = $user->createToken('testToken')->plainTextToken;
        $headers = ['Authorization' => "Bearer $token"];

        // Create a patient
        $patient = Patient::factory()->create();

        $data = [
            'name' => 'Test Patient',
            'date_of_birth' => '01-01-2000',
            'email' => 'test@ipmedth.nl',
        ];

        // Send post request
        $response = $this->json('PUT', route('api.patients.update', ['patient' => $patient->id]), $data, $headers);
        $response->assertStatus(200)
            ->assertValid()
            ->assertJson([
                'success' => true,
                'data' => [
                    'id' => $patient->id,
                    'name' => $data['name'],
                    'date_of_birth' => $data['date_of_birth'],
                    'email' => $data['email'],
                    'sessions' => [],
                ],
                'message' => 'Patient updated successfully.',
            ]);
        $this->assertAuthenticated();
    }

    /**
     * Test delete a patient.
     *
     * @return void
     */
    public function test_delete_a_patient()
    {
        // Create a user
        $user = User::factory()->create();
        $token = $user->createToken('testToken')->plainTextToken;
        $headers = ['Authorization' => "Bearer $token"];

        // Create a patient
        $patient = Patient::factory()->create();

        // Send post request
        $response = $this->json('DELETE', route('api.patients.destroy', ['patient' => $patient->id]), [], $headers);
        $response->assertStatus(200)
            ->assertJson([
                'success' => true,
                'data' => [],
                'message' => 'Patient deleted successfully.',
            ]);
        $this->assertAuthenticated();
    }

    /**
     * Test validation error when creating a new patient.
     *
     * @return void
     */
    public function test_validation_error_when_creating_new_patient()
    {
        // Create a user
        $user = User::factory()->create();
        $token = $user->createToken('testToken')->plainTextToken;
        $headers = ['Authorization' => "Bearer $token"];

        $data = [
            'name' => 'Test Patient',
            'date_of_birth' => '01-01-2000',
            'email' => '',
        ];

        // Send post request
        $response = $this->json('POST', route('api.patients.store'), $data, $headers);
        $response->assertStatus(422)
            ->assertJson([
                'success' => false,
                'message' => 'The given data was invalid.',
                'errors' => [
                    'email' => ['The email field is required.'],
                ],
            ]);
    }
}
