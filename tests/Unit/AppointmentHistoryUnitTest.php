<?php

namespace Tests\Unit;

use PHPUnit\Framework\TestCase;
use App\Livewire\AppointmentHistory;
use Livewire\Livewire;


class AppointmentHistoryUnitTest extends TestCase
{
    public function test_toggle_expand_toggles_expanded_row()
    {
        $component = new AppointmentHistory();

        $component->toggleExpand(1);
        $this->assertEquals(1, $component->expandedRow);

        $component->toggleExpand(1);
        $this->assertNull($component->expandedRow);
    }

    public function test_confirm_cancel_sets_modal_and_id()
    {
        $component = new AppointmentHistory();

        $component->confirmCancel(5);

        $this->assertTrue($component->showCancelModal);
        $this->assertEquals(5, $component->cancelAppointmentId);
    }

    public function test_set_rating_updates_rating_value()
    {
        $component = new AppointmentHistory();

        $component->setRating(4);
        $this->assertEquals(4, $component->rating);
    }

    public function test_open_feedback_modal_sets_correct_properties()
    {
        $component = new AppointmentHistory();

        $component->openFeedbackModal(10);

        $this->assertTrue($component->showFeedbackModal);
        $this->assertEquals(10, $component->feedbackAppointmentId);
        $this->assertEquals(10, $component->appointmentId);
    }

    public function test_close_feedback_modal_resets_modal_state()
    {
        $component = new AppointmentHistory();
        $component->rating = 3;
        $component->showFeedbackModal = true;
        $component->feedbackAppointmentId = 7;

        $component->closeFeedbackModal();

        $this->assertFalse($component->showFeedbackModal);
        $this->assertNull($component->feedbackAppointmentId);
        $this->assertEquals(0, $component->rating);
    }

}
