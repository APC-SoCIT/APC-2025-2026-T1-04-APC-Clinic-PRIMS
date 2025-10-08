<?php

namespace Tests\Feature;

use Tests\TestCase;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Livewire\Livewire;
use App\Livewire\AppointmentHistory;
use App\Models\User;
use App\Models\Patient;
use App\Models\Appointment;
use App\Models\Feedback;

class AppointmentHistoryTest extends TestCase
{
    use RefreshDatabase;

    protected function setUp(): void
    {
        parent::setUp();
        $this->seed();
    }

    public function test_loads_appointment_history_for_authenticated_patient()
    {
        $user = User::whereHas('patient')->first();
        $this->actingAs($user);

        Livewire::test(AppointmentHistory::class)
            ->assertViewHas('appointmentHistory')
            ->assertViewHas('hasUpcomingAppointment');
    }
}