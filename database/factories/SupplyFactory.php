<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

class SupplyFactory extends Factory
{
    public function definition(): array
    {
        $categories = ['Medicine', 'First Aid', 'Vaccine', 'Medical Equipment'];
        $dosageForms = ['Tablet', 'Capsule', 'Syrup', 'Injection', 'Ointment'];

        return [
            'name' => $this->faker->word() . ' ' . $this->faker->randomElement(['Paracetamol', 'Ibuprofen', 'Amoxicillin', 'Vitamin C', 'Betadine']),
            'brand' => $this->faker->randomElement(['Pfizer', 'GSK', 'Unilab', 'Johnson & Johnson', null]),
            'category' => $this->faker->randomElement($categories),
            'dosage_strength' => $this->faker->randomElement(['250mg', '500mg', '1000mg', '10ml', '50ml']),
            'dosage_form' => $this->faker->randomElement($dosageForms),
        ];
    }
}
