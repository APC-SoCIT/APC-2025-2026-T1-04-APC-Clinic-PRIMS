<?php

namespace Tests\Unit;

use Tests\TestCase;
use App\Livewire\PatientCalendar;

class PatientCalendarUnitTest extends TestCase
{
    public function test_reset_selection_clears_fields()
    {
        $component = new PatientCalendar();
        $component->selectedDate = '2024-10-10';
        $component->selectedTime = '8:00 AM';
        $component->selectedDoctor = (object)['id' => 1];
        $component->reasonForVisit = 'Test';
        $component->availableTimes = ['8:00 AM'];
        $component->isConfirming = true;

        $component->resetSelection();

        $this->assertNull($component->selectedDate);
        $this->assertNull($component->selectedTime);
        $this->assertNull($component->selectedDoctor);
        $this->assertNull($component->reasonForVisit);
        $this->assertEquals([], $component->availableTimes);
        $this->assertFalse($component->isConfirming);
    }
}