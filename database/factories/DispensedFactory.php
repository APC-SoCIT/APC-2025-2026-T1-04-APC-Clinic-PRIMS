<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use App\Models\Inventory;
use App\Models\Patient;
use App\Models\ClinicStaff;

class DispensedFactory extends Factory
{
    public function definition(): array
    {
        $inventory = Inventory::inRandomOrder()->first() ?? Inventory::factory()->create();
        $patient = Patient::inRandomOrder()->first() ?? Patient::factory()->create();

        return [
            'inventory_id' => $inventory->id,
            'patient_id' => $patient->id,
            'quantity_dispensed' => $this->faker->numberBetween(1, min(10, $inventory->quantity_received)),
            'date_dispensed' => $this->faker->dateTimeBetween($inventory->date_supplied, 'now'),
            'dispensed_by' => 1,
        ];
    }
}
