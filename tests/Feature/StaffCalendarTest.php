<?php

namespace Tests\Feature;

use Tests\TestCase;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Livewire\Livewire;
use App\Livewire\StaffCalendar;
use App\Models\User;
use App\Models\ClinicStaff;
use App\Models\Appointment;
use App\Models\DoctorSchedule;

class StaffCalendarTest extends TestCase
{
    use RefreshDatabase;

    protected function setUp(): void
    {
        parent::setUp();
        $this->seed();
    }

    public function test_save_schedule_creates_or_updates_doctor_schedule()
    {
        $user = User::whereHas('clinicStaff')->first();
        $doctor = ClinicStaff::where('clinic_staff_role', 'doctor')->first();
        $this->actingAs($user);

        $date = now()->toDateString();
        $times = ['8:00 AM', '9:00 AM'];

        Livewire::test(StaffCalendar::class)
            ->set('selectedDoctor', $doctor->id)
            ->set('selectedDate', $date)
            ->set('selectedTimes', $times)
            ->call('saveSchedule');

        $this->assertDatabaseHas('doctor_schedules', [
            'doctor_id' => $doctor->id,
            'date' => $date,
        ]);
    }
}