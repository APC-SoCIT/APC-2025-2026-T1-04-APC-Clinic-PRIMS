<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Patient>
 */
class PatientFactory extends Factory
{
    protected $model = \App\Models\Patient::class;

    public function definition(): array
    {
        return [
            'user_id' => \App\Models\User::factory(),
            'apc_id_number' => $this->faker->unique()->numerify('2025-#####'),
            'first_name' => $this->faker->firstName(),
            'middle_initial' => strtoupper($this->faker->randomLetter()),
            'last_name' => $this->faker->lastName(),
            'gender' => $this->faker->randomElement(['Male', 'Female']),
            'date_of_birth' => $this->faker->date('Y-m-d', '2005-01-01'),
            'nationality' => 'Filipino',
            'blood_type' => $this->faker->randomElement(['A', 'B', 'AB', 'O']),
            'civil_status' => $this->faker->randomElement(['Single', 'Married']),
            'religion' => $this->faker->randomElement(['Roman Catholic', 'Christian', 'Muslim']),
            'contact_number' => '09' . $this->faker->numerify('#########'),
            'email' => $this->faker->unique()->safeEmail(),
            'house_unit_number' => $this->faker->buildingNumber(),
            'street' => $this->faker->streetName(),
            'barangay' => 'Barangay ' . $this->faker->randomDigitNotNull(),
            'city' => $this->faker->city(),
            'province' => 'NCR',
            'zip_code' => $this->faker->numerify('####'),
            'country' => 'Philippines',
            'emergency_contact_name' => $this->faker->name(),
            'emergency_contact_number' => '09' . $this->faker->numerify('#########'),
            'emergency_contact_relationship' => $this->faker->randomElement(['Parent', 'Sibling', 'Friend']),
        ];
    }
}
