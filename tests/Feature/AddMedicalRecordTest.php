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

}
