<?php

namespace Tests\Feature;

use Tests\TestCase;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Livewire\Livewire;
use App\Livewire\PatientCalendar;
use App\Models\User;
use App\Models\Patient;
use App\Models\ClinicStaff;
use App\Models\DoctorSchedule;
use App\Models\Appointment;

class PatientCalendarTest extends TestCase
{
    use RefreshDatabase;

    protected function setUp(): void
    {
        parent::setUp();
        $this->seed();
    }

    public function test_component_renders_for_authenticated_patient()
    {
        $user = User::whereHas('patient')->first();
        $this->actingAs($user);

        Livewire::test(PatientCalendar::class)
            ->assertViewIs('livewire.patient-calendar')
            ->assertSet('patient.id', $user->patient->id);
    }
}