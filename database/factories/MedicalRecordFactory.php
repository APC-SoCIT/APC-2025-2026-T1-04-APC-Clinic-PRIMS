<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use App\Models\MedicalRecord;
use App\Models\Appointment;
use App\Models\Patient;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Model>
 */
class MedicalRecordFactory extends Factory
{
    protected $model = MedicalRecord::class;

    public function definition()
    {
        $faker = $this->faker;

        // 70% chance to link to an appointment, 30% chance to be independent
        $appointmentId = $faker->boolean(70) ? Appointment::inRandomOrder()->value('id') : null;

        // Doctor IDs 2-4 only (as requested)
        $doctorId = $faker->boolean(80) ? $faker->numberBetween(2, 4) : null;

        $weight = $faker->numberBetween(45, 90); // kg
        $height = $faker->numberBetween(150, 185); // cm
        $bmi = round($weight / pow($height / 100, 2), 1);

        return [
            'patient_id' => Patient::inRandomOrder()->value('id'),
            'reason' => $faker->randomElement([
                'Consultation', 'Fever', 'Headache', 'Injury','Other'
            ]),
            'description' => $faker->sentence(10),
            'last_visited' => $faker->dateTimeBetween('-2 years', 'now'),
            'allergies' => $faker->optional()->sentence(4),
            'medications' => $faker->optional()->sentence(4),
            'past_medical_history' => json_encode([
                'Mumps' => $faker->randomElement(['Yes', 'No']),
                'Heart Disorder' => $faker->randomElement(['Yes', 'No']),
                'Bleeding Problem' => $faker->randomElement(['Yes', 'No']),
                'Hepatitis' => $faker->randomElement(['A', 'B', 'C', 'D', 'None']),
                'Chicken Pox' => $faker->randomElement(['Yes', 'No']),
                'Dengue' => $faker->randomElement(['Yes', 'No']),
                'Kidney Disease' => $faker->randomElement(['Yes', 'No']),
                'Covid-19' => $faker->randomElement(['Yes', 'No']),
            ]),
            'family_history' => json_encode([
                'Bronchial Asthma' => $faker->randomElement(['Yes', 'No']),
                'Diabetes Mellitus' => $faker->randomElement(['Yes', 'No']),
                'Thyroid Disorder' => $faker->randomElement(['Yes', 'No']),
                'Cancer' => $faker->randomElement(['Yes', 'No']),
                'Hypertension' => $faker->randomElement(['Yes', 'No']),
                'Liver Disease' => $faker->randomElement(['Yes', 'No']),
                'Epilepsy' => $faker->randomElement(['Yes', 'No']),
            ]),
            'personal_history' => json_encode([
                'Vape' => $faker->randomElement(['Yes', 'No']),
                'Alcohol' => 'N/A',
            ]),
            'obgyne_history' => json_encode([
                'LNMP' => $faker->optional()->date(),
                'OB Score' => $faker->optional()->randomElement(['G0P0', 'G1P0', 'G2P1', 'N/A']),
                'Date of Last Delivery' => $faker->optional()->date(),
            ]),
            'hospitalization' => $faker->optional()->sentence(6),
            'operation' => $faker->optional()->sentence(6),
            'immunizations' => json_encode([
                'COVID-19 1st' => $faker->randomElement(['Yes', 'No']),
                'COVID-19 2nd' => $faker->randomElement(['Yes', 'No']),
                'Booster 1' => $faker->randomElement(['Yes', 'No']),
                'Booster 2' => $faker->randomElement(['Yes', 'No']),
            ]),
            'weight' => $weight,
            'height' => $height,
            'blood_pressure' => $faker->numberBetween(100, 130) . '/' . $faker->numberBetween(70, 90),
            'heart_rate' => $faker->numberBetween(60, 100),
            'respiratory_rate' => $faker->numberBetween(12, 20),
            'temperature' => $faker->randomFloat(1, 36.0, 39.0),
            'bmi' => $bmi,
            'o2sat' => $faker->numberBetween(94, 100),
            'prescription' => $faker->sentence(5),
            'appointment_id' => $appointmentId,
            'doctor_id' => $doctorId,
            'archived_at' => null,
        ];
    }

    public function configure()
    {
        return $this->afterCreating(function ($record) {
            \App\Models\Diagnosis::factory(rand(1, 3))->create([
                'medical_record_id' => $record->id,
            ]);
        });
    }

}