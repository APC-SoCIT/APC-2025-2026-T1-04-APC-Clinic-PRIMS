<?php

namespace App\Livewire;

use Livewire\Component;
use App\Models\DentalRecord;
use Illuminate\Support\Facades\DB;

class DentalFormV2 extends Component
{
    public $step = 1;
    public $substep = 1;

    public $showErrorModal = false;
    public $errorMessage = '';

    public $patient_id, $appointment_id;


    // Intraoral Exam + Procedures fields
    public $oral_hygiene = [
        'plaque_level' => '',
        'remarks' => '',
    ];

    public $procedures = [];
    public $teeth = [
        'upper' => [],
        'lower' => [],
    ];

    public $gingival_color, $procedure_notes;

    // Recommendation (if any)
    public $recommendation;

    // Tooth chart
    public $leftLabels = ['8','7','6','5','4','3','2','1'];
    public $rightLabels = ['1','2','3','4','5','6','7','8'];

    public function mount()
    {
        // Initialize teeth arrays in the constructor
        $this->teeth = [
            'upper' => array_fill(0, 16, null),
            'lower' => array_fill(0, 16, null),
        ];
    }

    public $toothColors = [
        'C'  => 'bg-red-500 text-white',       // Caries
        'M'  => 'bg-blue-500 text-white',      // Missing
        'E'  => 'bg-green-500 text-white',     // Extraction
        'LC' => 'bg-orange-500 text-white',    // Lesion/Cavity
        'CR' => 'bg-purple-500 text-white',    // Crown
        'UE' => 'bg-yellow-500 text-white',    // Unerupted
    ];

    public $selectedJaw, $selectedIndex, $showModal = false;
    public $selectedToothLabel;


    public function getSelectedToothLabel()
    {
        if ($this->selectedJaw === null || $this->selectedIndex === null) return '';

        $side = $this->selectedIndex < count($this->leftLabels) ? 'Left' : 'Right';
        $indexInSide = $side === 'Left' ? $this->selectedIndex : $this->selectedIndex - count($this->leftLabels);
        $label = $side === 'Left' ? $this->leftLabels[$indexInSide] : $this->rightLabels[$indexInSide];

        return $label . ' (' . ucfirst($this->selectedJaw) . ' ' . $side . ')';
    }


    public function nextStep() {
        if ($this->step < 5) $this->step++;
    }

    public function previousStep() {
        if ($this->step > 1) $this->step--;
    }

    public function setSubstep($index)
    {
        $this->substep = $index;
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

    public function closeModalWithSave()
    {
        $this->showModal = false;
    }


    public function selectToothCondition($status)
    {
        if (!$this->selectedJaw || $this->selectedIndex === null) return;

        // If the same status is clicked, deselect it
        if ($this->teeth[$this->selectedJaw][$this->selectedIndex] === $status) {
            $this->teeth[$this->selectedJaw][$this->selectedIndex] = null;
        } else {
            $this->teeth[$this->selectedJaw][$this->selectedIndex] = $status;
        }
    }

    public function save()
    {
        // Validate required fields
        $this->validate();

        try {
            DentalRecord::create([
                'patient_id' => $this->patient_id, 
                'oral_hygiene' => $this->oral_hygiene,
                'gingival_color' => $this->gingival_color,
                'procedures' => $this->procedures,
                'procedure_notes' => $this->procedure_notes,
                'teeth' => $this->teeth,
                'recommendation' => $this->recommendation,
                'appointment_id' => $this->appointment_id ?? null,
                'doctor_id' => auth()->id(), 
            ]);

            // Reset form after saving
            $this->reset([
                'oral_hygiene', 
                'gingival_color', 
                'procedures', 
                'recommendation', 
                'teeth'
            ]);

            $this->mount(); // re-init teeth arrays
            $this->step = 1;
            $this->substep = 1;

            session()->flash('success', 'Dental record saved successfully!');
        
        } catch (\Exception $e) {
            $this->showErrorModal = true;
            $this->errorMessage = "Error saving record: " . $e->getMessage();
        }
    }

    protected $fillable = [
        'patient_id',
        'oral_hygiene',
        'gingival_color',
        'procedures',
        'procedure_notes',
        'teeth',
        'recommendation',
        'appointment_id',
        'doctor_id',
    ];

    protected $rules = [
        'oral_hygiene.plaque_level' => 'required|string',
        'gingival_color' => 'required|string',

        'procedures' => 'required|array|min:1',
    ];

    public function render()
    {
        return view('livewire.dental-form-v2');
    }
}
