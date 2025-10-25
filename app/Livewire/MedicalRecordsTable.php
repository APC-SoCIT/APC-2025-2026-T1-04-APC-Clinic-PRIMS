<?php

namespace App\Livewire;

use Livewire\Component;
use Livewire\WithPagination;
use App\Models\MedicalRecord;
use App\Models\DentalRecord;
use App\Models\Patient;

class MedicalRecordsTable extends Component
{
    use WithPagination;

    protected $paginationTheme = 'tailwind';

    public $apc_id_number = ''; 
    public $expandedPatient = null;

    protected $listeners = ['recordAdded' => '$refresh'];

    public function updatingApcIdNumber()
    {
        $this->resetPage();
    }

    public function searchPatient()
    {
        $this->resetPage(); // Make sure it starts from page 1
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
        return DentalRecord::where('patient_id', $patientId)
            ->orderByDesc('created_at')
            ->get();
    }

    public function render()
    {
        $latestMedicalRecords = MedicalRecord::query()
            ->selectRaw('MAX(id) as id')
            ->groupBy('patient_id')
            ->pluck('id');

        $medicalRecords = MedicalRecord::with(['diagnoses', 'patient'])
            ->whereIn('id', $latestMedicalRecords)
            ->get();

        $latestDentalRecords = DentalRecord::query()
            ->selectRaw('MAX(id) as id')
            ->groupBy('patient_id')
            ->pluck('id');

        $dentalRecords = DentalRecord::with(['patient'])
            ->whereIn('id', $latestDentalRecords)
            ->get();

        $patientIds = $medicalRecords->pluck('patient_id')
            ->merge($dentalRecords->pluck('patient_id'))
            ->unique();

        $query = Patient::whereIn('id', $patientIds)
            ->with(['medicalRecords.diagnoses', 'dentalRecords']);

        if (!empty($this->apc_id_number)) {
            $term = '%' . str_replace(' ', '%', $this->apc_id_number) . '%';
            $query->where(function ($q) use ($term) {
                $q->where('apc_id_number', 'like', $term)
                  ->orWhere('first_name', 'like', $term)
                  ->orWhere('last_name', 'like', $term)
                  ->orWhere('email', 'like', $term);
            });
        }

        $records = $query->orderBy('last_name')->paginate(10);

        return view('livewire.medical-records-table', [
            'records' => $records,
        ]);
    }
}
