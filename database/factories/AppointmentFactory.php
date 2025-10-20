<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use App\Models\Patient;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Appointment>
 */
class AppointmentFactory extends Factory
{
    
    public function definition(): array
    {
        $statuses = ['pending', 'approved', 'declined', 'cancelled', 'completed'];
        $status = $this->faker->randomElement($statuses);

        return [
            'appointment_date' => $this->faker->dateTimeBetween('-1 month', '+1 month'),
            'status' => $status,
            'reason_for_visit' => $this->faker->sentence(6),
            'cancellation_reason' => $status === 'cancelled' ? $this->faker->sentence(4) : null,
            'declination_reason' => $status === 'declined' ? $this->faker->sentence(4) : null,
            'patient_id' => Patient::inRandomOrder()->first()?->id ?? Patient::factory(),
            'clinic_staff_id' => $this->faker->randomElement([2, 3, 4]),
            'status_updated_by' => 1,
        ];
    }
}
