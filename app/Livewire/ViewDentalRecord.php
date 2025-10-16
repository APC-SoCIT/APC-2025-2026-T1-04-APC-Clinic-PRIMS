<?php

namespace App\Livewire;

use Livewire\Component;
use App\Models\DentalRecord;

class ViewDentalRecord extends Component
{
    public $record;

    public function mount(DentalRecord $record)
    {
        $this->record = $record;
    }

    public function render()
    {
        return view('livewire.view-dental-record', [
            'record' => $this->record,
        ]);
    }
}