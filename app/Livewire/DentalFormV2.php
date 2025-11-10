<?php

namespace App\Livewire;

use Livewire\Component;
use App\Models\DentalRecord;
use App\Models\Patient;

class DentalFormV2 extends Component
{
    public $step = 1;
    public $substep = 1;

    public $patient_id = 2; // valid id from patients table
    public $patient_info;
    public $appointment_id;

    // Intraoral Exam
    public $oral_hygiene = [
        'plaque_level' => '',
        'remarks' => '',
    ];
    public $gingival_color;

    // Procedures
    public $procedures = [];
    public $procedure_notes;

    // Tooth chart
    public $teeth = [
        'upper' => [],
        'lower' => [],
    ];

    // Recommendation
    public $recommendation;

    // Tooth chart labels
    public $leftLabels = ['8','7','6','5','4','3','2','1'];
    public $rightLabels = ['1','2','3','4','5','6','7','8'];

    public $selectedJaw;
    public $selectedIndex;
    public $selectedToothLabel;
    public $showModal = false;

    public $toothColors = [
        'C'  => 'bg-red-500 text-white',
        'M'  => 'bg-blue-500 text-white',
        'E'  => 'bg-green-500 text-white',
        'LC' => 'bg-orange-500 text-white',
        'CR' => 'bg-purple-500 text-white',
        'UE' => 'bg-yellow-500 text-white',
    ];

    // Validation rules
    protected $rules = [
        'oral_hygiene.plaque_level' => 'required|string',
        'gingival_color' => 'required|string',
    ];

    public function mount($appointment_id = null)
    {
        $this->appointment_id = $appointment_id;

        // initialize teeth
        $this->teeth['upper'] = array_fill(0, 16, null);
        $this->teeth['lower'] = array_fill(0, 16, null);

        // Hardcoded patient info for display
        $this->patient_info = [
            'id' => '2022-140335',
            'full_name' => 'Erika Alessandra D. Daduya',
            'gender' => 'Female',
            'dob' => '10/27/2003',
            'age' => 22,
            'nationality' => 'Filipino',
            'blood_type' => 'O',
            'civil_status' => 'Single',
            'religion' => 'Born Again Christian',
            'contact_number' => '09123456789',
            'email' => 'eddaduya@student.apc.edu.ph',
            'house_no' => '00',
            'street' => 'Sesame Street',
            'barangay' => 'Magallanes',
            'city' => 'Makati City',
            'province' => 'NCR',
            'zip_code' => '1232',
            'country' => 'Philippines',
            'emergency_name' => 'Emergency',
            'emergency_number' => '09987654321',
            'emergency_relationship' => 'Parent',
        ];
    }

    public function updated($propertyName)
    {
        if ($this->step == 1) {
            $this->validateOnly($propertyName);
        }
    }

    public function nextStep()
    {
        if ($this->step == 1) {
            $this->validate(); // make sure step 1 is filled
        }
        if ($this->step < 4) $this->step++;
    }

    public function previousStep()
    {
        if ($this->step > 1) $this->step--;
    }

    public function openModal($jaw, $index)
    {
        $this->selectedJaw = $jaw;
        $this->selectedIndex = $index;
        $this->selectedToothLabel = $this->getSelectedToothLabel();
        $this->showModal = true;
    }

    public function closeModal()
    {
        $this->showModal = false;
        $this->selectedJaw = null;
        $this->selectedIndex = null;
    }

    public function selectToothCondition($status)
    {
        if (!$this->selectedJaw || $this->selectedIndex === null) return;

        if ($this->teeth[$this->selectedJaw][$this->selectedIndex] === $status) {
            $this->teeth[$this->selectedJaw][$this->selectedIndex] = null;
        } else {
            $this->teeth[$this->selectedJaw][$this->selectedIndex] = $status;
        }
    }

    public function getSelectedToothLabel()
    {
        if ($this->selectedJaw === null || $this->selectedIndex === null) return '';

        $side = $this->selectedIndex < count($this->leftLabels) ? 'Left' : 'Right';
        $indexInSide = $side === 'Left' ? $this->selectedIndex : $this->selectedIndex - count($this->leftLabels);
        $label = $side === 'Left' ? $this->leftLabels[$indexInSide] : $this->rightLabels[$indexInSide];

        return $label . ' (' . ucfirst($this->selectedJaw) . ' ' . $side . ')';
    }

    public function save()
    {
        $this->validate(); // step 1 validation only

        DentalRecord::create([
            'patient_id' => $this->patient_id,
            'oral_hygiene' => $this->oral_hygiene ?? [],
            'gingival_color' => $this->gingival_color,
            'procedures' => $this->procedures ?? [],
            'procedure_notes' => $this->procedure_notes,
            'teeth' => $this->teeth ?? ['upper' => [], 'lower' => []],
            'recommendation' => $this->recommendation,
            'appointment_id' => $this->appointment_id ?? null,
            'doctor_id' => null,
        ]);

        // Reset form locally (optional, since we are redirecting)
        $this->resetForm();

        // Redirect to same Livewire route (first step)
        return redirect()->route('medical-records')->with('success', 'Dental record saved successfully!');
    }

    private function resetForm()
    {
        $this->oral_hygiene = ['plaque_level' => '', 'remarks' => ''];
        $this->gingival_color = null;
        $this->procedures = [];
        $this->procedure_notes = null;
        $this->teeth = ['upper' => array_fill(0,16,null), 'lower' => array_fill(0,16,null)];
        $this->recommendation = null;
        $this->step = 1;
        $this->substep = 1;
    }

    public function render()
    {
        return view('livewire.dental-form-v2');
    }
}
