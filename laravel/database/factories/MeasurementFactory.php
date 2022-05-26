<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use App\Models\Session;
use App\Models\User;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Measurement>
 */
class MeasurementFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition()
    {
        return [
            'user_id' => User::factory(),
            'session_id' => Session::factory(),
            'hand_view' => $this->faker->randomElement(['thumb_side', 'pink_side', 'finger_side', 'back_side']),
            'hand_type' => $this->faker->randomElement(['left', 'right']),
            'hand_score' => $this->faker->randomFloat(2, 0, 1),
            'finger_1' => json_encode(['thing' => rand(11,99), 'other' => rand(11,99)]),
            'finger_2' => json_encode(['thing' => rand(11,99), 'other' => rand(11,99)]),
            'finger_3' => json_encode(['thing' => rand(11,99), 'other' => rand(11,99)]),
            'finger_4' => json_encode(['thing' => rand(11,99), 'other' => rand(11,99)]),
            'finger_5' => json_encode(['thing' => rand(11,99), 'other' => rand(11,99)]),
        ];
    }
}
