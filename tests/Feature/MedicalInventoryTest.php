<?php

namespace Tests\Feature;

use Tests\TestCase;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Livewire\Livewire;
use App\Livewire\MedicalInventory;
use App\Models\Inventory;
use App\Models\Supply;

class MedicalInventoryTest extends TestCase
{
    use RefreshDatabase;

    protected function setUp(): void
    {
        parent::setUp();
        $this->seed();
    }

    public function test_inventory_list_renders()
    {
        Livewire::test(MedicalInventory::class)
            ->assertViewHas('inventory')
            ->assertViewHas('inventoryWithTrashed');
    }

    public function test_sorting_changes_order()
    {
        Livewire::test(MedicalInventory::class)
            ->call('sortBy', 'supplies.name')
            ->assertSet('sortField', 'supplies.name')
            ->assertSet('sortDirection', 'desc');
    }

}