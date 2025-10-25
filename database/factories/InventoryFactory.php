<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use App\Models\Supply;
use App\Models\ClinicStaff;

class InventoryFactory extends Factory
{
    public function definition(): array
    {
        $supply = Supply::inRandomOrder()->first() ?? Supply::factory()->create();

        return [
            'supply_id' => $supply->id,
            'quantity_received' => $this->faker->numberBetween(20, 500),
            'date_supplied' => $this->faker->dateTimeBetween('-6 months', 'now'),
            'expiration_date' => $this->faker->boolean(80) ? $this->faker->dateTimeBetween('now', '+1 year') : null,
            'updated_by' => 1,
        ];
    }
}
