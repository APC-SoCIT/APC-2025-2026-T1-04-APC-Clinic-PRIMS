<?php

namespace App\Livewire;

use Livewire\Component;
use App\Models\MedicalRecord;
use App\Models\DentalRecord;
use App\Models\Patient;
use App\Models\RfidCard;
use Illuminate\Support\Facades\DB;

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
        // Latest medical record per patient
        $latestMedicalRecords = MedicalRecord::query()
            ->selectRaw('MAX(id) as id')
            ->groupBy('patient_id')
            ->pluck('id');

        $medicalRecords = MedicalRecord::with(['diagnoses', 'patient'])
            ->whereIn('id', $latestMedicalRecords)
            ->get();

        // Latest dental record per patient
        $latestDentalRecords = DentalRecord::query()
            ->selectRaw('MAX(id) as id')
            ->groupBy('patient_id')
            ->pluck('id');

        $dentalRecords = DentalRecord::with(['patient'])
            ->whereIn('id', $latestDentalRecords)
            ->get();

        // Combine unique patient IDs from both medical & dental
        $patientIds = $medicalRecords->pluck('patient_id')
            ->merge($dentalRecords->pluck('patient_id'))
            ->unique();

        // Load patients that have at least one type of record
        $this->records = Patient::whereIn('id', $patientIds)
            ->with(['medicalRecords.diagnoses', 'dentalRecords'])
            ->get();

        // Keep both for expanded display
        $this->dentalRecords = $dentalRecords;
    }


    public function searchPatient()
    {
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

    public function getPatientDentalRecords($patientId)
    {
        return $this->dentalRecords->where('patient_id', $patientId);
    }


    public function render()
    {
        return view('livewire.medical-records-table');
    }
}

