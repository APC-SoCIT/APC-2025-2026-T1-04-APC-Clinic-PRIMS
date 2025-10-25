<?php

namespace Database\Factories;

use App\Models\User;
use App\Models\Appointment;
use Illuminate\Database\Eloquent\Factories\Factory;

class FeedbackFactory extends Factory
{
    public function definition(): array
    {
        return [
            'user_id' => $this->faker->boolean(80) ? User::inRandomOrder()->value('id') : null, // 80% chance of having a user
            'appointment_id' => Appointment::inRandomOrder()->value('id'),
            'type' => $this->faker->randomElement(['booking', 'consultation']),
            'emoji' => $this->faker->optional()->randomElement(['sad', 'flat', 'happy']),
            'rating' => $this->faker->numberBetween(1, 5),
            'anonymous' => $this->faker->boolean(20), // 20% chance to be anonymous
            'comment' => $this->faker->optional()->sentence(10),
        ];
    }
}
