<?php

namespace App\Livewire;

use Livewire\Component;
use App\Models\MedicalRecord;
use App\Models\DentalRecord;
use App\Models\Patient;
use App\Models\RfidCard;

class MedicalRecordsTable extends Component
{
    public $records;
    public $dentalRecords; 
    public $expandedPatient = null;

    public $apc_id_number;
    public $patient;

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

        // load dental records (no schema change needed)
        $this->dentalRecords = DentalRecord::with('patient')
            ->orderByDesc('created_at') // adjust if dental has a date field
            ->get();
    }

    public function searchPatient()
    {
        if (empty($this->apc_id_number)) {
            return $this->resetPatientFields();
        }

        $patient = Patient::where('apc_id_number', $this->apc_id_number)->first();

        if (!$patient) {
            $card = RfidCard::with('patient')
                ->where('rfid_uid', $this->apc_id_number)
                ->first();

            if ($card && $card->patient) {
                $patient = $card->patient;
                $this->apc_id_number = $patient->apc_id_number;
            }
        }
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

