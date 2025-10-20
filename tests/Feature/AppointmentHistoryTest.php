<?php

namespace Tests\Feature;

use Tests\TestCase;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Livewire\Livewire;
use App\Livewire\AppointmentHistory;
use App\Models\User;
use App\Models\Patient;
use App\Models\Appointment;
use Carbon\Carbon;

class AppointmentHistoryTest extends TestCase
{
    use RefreshDatabase;

    protected function setUp(): void
    {
        parent::setUp();
        $this->seed(); // Make sure this creates a user with a patient
    }

    public function test_loads_appointment_history_for_authenticated_patient()
    {
        // Get a user with a related patient. If none, create one.
        $user = User::whereHas('patient')->first();

        if (!$user) {
            $user = User::factory()->create();
            Patient::factory()->create(['user_id' => $user->id]);
        }

        $this->actingAs($user);

        // Create at least one appointment for this patient to avoid null errors
        Appointment::factory()->create([
            'patient_id' => $user->patient->id,
            'appointment_date' => Carbon::now()->addDay(),
            'status' => 'approved'
        ]);

        Livewire::test(AppointmentHistory::class)
            ->assertViewHasAll(['appointmentHistory', 'hasUpcomingAppointment']);

    }
}
