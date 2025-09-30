<?php

namespace Tests\Feature;

use Tests\TestCase;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Livewire\Livewire;
use App\Livewire\AddMedicalRecord;
use App\Models\Patient;
use App\Models\Appointment;

class AddMedicalRecordTest extends TestCase
{
    use RefreshDatabase;

    protected function setUp(): void
    {
        parent::setUp();
        $this->seed(); // seeds both UserSeeder and PatientSeeder
    }

    public function test_mount_prefills_patient_data_from_appointment()
    {
        $patient = Patient::where('apc_id_number', '2022-140224')->first();

        $appointment = Appointment::create([
            'patient_id' => $patient->id,
            'appointment_date' => now(),
            'reason_for_visit' => 'Checkup', // added
            'status' => 'pending',
        ]);

        Livewire::test(AddMedicalRecord::class, ['appointment_id' => $appointment->id])
            ->assertSet('first_name', $patient->first_name)
            ->assertSet('apc_id_number', $patient->apc_id_number);
    }

    public function test_search_patient_finds_patient_by_apc_id_number()
    {
        $patient = Patient::where('apc_id_number', '2022-140224')->first();

        Livewire::test(AddMedicalRecord::class)
            ->set('apc_id_number', $patient->apc_id_number)
            ->call('searchPatient')
            ->assertSet('first_name', $patient->first_name)
            ->assertSet('email', $patient->email);
    }

    public function test_submit_medical_record_saves_to_database()
    {
        $patient = Patient::first();

        // Create appointment manually
        $appointment = Appointment::create([
            'patient_id' => $patient->id,
            'appointment_date' => now(),
            'reason_for_visit' => 'Headache',
            'status' => 'pending',
        ]);

        Livewire::test('add-medical-record', [
            'appointment_id' => $appointment->id,
        ])
            ->set('fromStaffCalendar', true) // ✅ required so appointment gets updated
            ->set('email', $patient->email)
            ->set('apc_id_number', $patient->apc_id_number)
            ->set('first_name', $patient->first_name)
            ->set('last_name', $patient->last_name)
            ->set('dob', $patient->dob ?? '2000-01-01')
            ->set('age', 24)
            ->set('gender', 'Male')
            ->set('contact_number', '09123456789')
            ->set('street_number', '123')
            ->set('barangay', 'San Isidro')
            ->set('city', 'Makati')
            ->set('province', 'Metro Manila')
            ->set('zip_code', '1234')
            ->set('country', 'Philippines')
            ->set('nationality', 'Filipino')
            ->set('reason', 'Headache')
            ->set('description', 'Patient complains of severe headache')
            ->set('diagnoses', [
                ['diagnosis' => 'Migraine', 'notes' => 'Recurring'],
            ])
            ->set('prescription', 'Paracetamol 500mg')
            ->call('submit');

        $this->assertDatabaseHas('medical_records', [
            'apc_id_number' => $patient->apc_id_number,
            'reason' => 'Headache',
            'description' => 'Patient complains of severe headache',
            'appointment_id' => $appointment->id,
        ]);

        $this->assertDatabaseHas('diagnoses', [
            'diagnosis' => 'Migraine',
            'diagnosis_notes' => 'Recurring',
        ]);

        $this->assertDatabaseHas('appointments', [
            'id' => $appointment->id,
            'status' => 'completed',
        ]);
    }

}
