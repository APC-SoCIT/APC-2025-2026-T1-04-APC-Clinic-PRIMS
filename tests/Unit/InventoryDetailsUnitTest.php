<?php

namespace Tests\Unit;

use Tests\TestCase;
use App\Livewire\InventoryDetails;
use App\Models\Inventory;
use App\Models\Patient;
use Illuminate\Foundation\Testing\RefreshDatabase;

class InventoryDetailsUnitTest extends TestCase
{
    public function test_open_and_close_modals()
    {
        $component = new InventoryDetails();
        $component->openDispenseModal();
        $this->assertTrue($component->showDispenseModal);
        $component->closeDispenseModal();
        $this->assertFalse($component->showDispenseModal);

        $component->openDisposeModal();
        $this->assertTrue($component->showDisposeModal);
    }
}