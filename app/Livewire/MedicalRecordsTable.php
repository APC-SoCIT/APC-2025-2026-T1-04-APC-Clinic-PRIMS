<?php

namespace App\Livewire;

use Livewire\Component;
use App\Models\MedicalRecord;

class MedicalRecordsTable extends Component
{
    public $records;
    public $expandedPatient = null;

    protected $listeners = ['recordAdded' => 'loadRecords'];

    public function mount()
    {
        $this->loadRecords();
    }

    public function loadRecords()
    {
        // Get the latest record per patient
        $latestRecords = MedicalRecord::query()
            ->selectRaw('MAX(id) as id')
            ->groupBy('patient_id')
            ->pluck('id');

        $this->records = MedicalRecord::with(['diagnoses', 'patient'])
            ->whereIn('id', $latestRecords)
            ->orderByDesc('last_visited')
            ->get();
    }

    public function toggleExpand($patientId)
    {
        $this->expandedPatient = $this->expandedPatient === $patientId ? null : $patientId;
    }

    public function getPatientRecords($patientId)
    {
        return MedicalRecord::where('patient_id', $patientId)
            ->orderByDesc('last_visited')
            ->with(['diagnoses', 'patient'])
            ->get();
    }

    public function render()
    {
        return view('livewire.medical-records-table');
    }
}

