<?php

namespace Tests\Unit;

use Tests\TestCase;
use App\Livewire\StaffCalendar;

class StaffCalendarUnitTest extends TestCase
{
    public function test_toggle_time_adds_and_removes_time()
    {
        $component = new StaffCalendar();
        $component->selectedTimes = ['8:00 AM'];
        $component->toggleTime('9:00 AM');
        $this->assertContains('9:00 AM', $component->selectedTimes);
        $component->toggleTime('8:00 AM');
        $this->assertNotContains('8:00 AM', $component->selectedTimes);
    }

    public function test_cancel_editing_schedule_resets_fields()
    {
        $component = new StaffCalendar();
        $component->isEditingSchedule = true;
        $component->selectedDoctor = 1;
        $component->selectedTimes = ['8:00 AM'];
        $component->stopPolling = true;

        $component->cancelEditingSchedule();

        $this->assertFalse($component->isEditingSchedule);
        $this->assertNull($component->selectedDoctor);
        $this->assertEquals([], $component->selectedTimes);
        $this->assertFalse($component->stopPolling);
    }
}