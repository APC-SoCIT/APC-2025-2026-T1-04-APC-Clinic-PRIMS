<?php

namespace App\Livewire;

use Livewire\Component;
use App\Models\Patient;
use App\Models\Appointment;
use App\Models\RfidCard;
use App\Models\DentalRecord;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

class DentalForm extends Component
{
    public $appointment_id, $fromStaffCalendar, $apc_id_number, $first_name, $middle_initial, $last_name, $gender, $age, $date_of_birth, $nationality, $blood_type, $civil_status, $religion, $contact_number, $email, $house_unit_number, $street, $barangay, $city, $province, $zip_code, $country, $emergency_contact_name, $emergency_contact_number, $emergency_contact_relationship;

    public $oral_hygiene = null;
    public $gingival_color = null;
    public $prophylaxis = false;
    public $recommendation = null;

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

        $patient ? $this->fillPatientDetails($patient) : $this->resetPatientFields();
    }

    private function fillPatientDetails(Patient $patient)
    {
        $this->apc_id_number = $patient->apc_id_number;
        $this->first_name = $patient->first_name;
        $this->middle_initial = $patient->middle_initial;
        $this->last_name = $patient->last_name;
        $this->gender = $patient->gender;
        $this->date_of_birth = $patient->date_of_birth;
        $this->age = $patient->date_of_birth ? Carbon::parse($patient->date_of_birth)->age : null;
        $this->nationality = $patient->nationality;
        $this->blood_type = $patient->blood_type;
        $this->civil_status = $patient->civil_status;
        $this->religion = $patient->religion;
        $this->contact_number = $patient->contact_number;
        $this->email = $patient->email;
        $this->house_unit_number = $patient->house_unit_number;
        $this->street = $patient->street;
        $this->barangay = $patient->barangay;
        $this->city = $patient->city;
        $this->province = $patient->province;
        $this->zip_code = $patient->zip_code;
        $this->country = $patient->country;
        $this->emergency_contact_name = $patient->emergency_contact_name;
        $this->emergency_contact_number = $patient->emergency_contact_number;
        $this->emergency_contact_relationship = $patient->emergency_contact_relationship;
    }

    private function resetPatientFields()
    {
        $this->apc_id_number = null;
        $this->first_name = null;
        $this->middle_initial = null;
        $this->last_name = null;
        $this->gender = null;
        $this->date_of_birth = null;
        $this->nationality = null;
        $this->blood_type = null;
        $this->civil_status = null;
        $this->religion = null;
        $this->contact_number = null;
        $this->email = null;
        $this->house_unit_number = null;
        $this->street = null;
        $this->barangay = null;
        $this->city = null;
        $this->province = null;
        $this->zip_code = null;
        $this->country = null;
        $this->emergency_contact_name = null;
        $this->emergency_contact_number = null;
        $this->emergency_contact_relationship = null;
    }

    public $teeth = [
        'upper' => [],
        'lower' => []
    ];

    public $leftLabels = ['8','7','6','5','4','3','2','1'];
    public $rightLabels = ['1','2','3','4','5','6','7','8'];

    public $showModal = false;
    public $selectedJaw = null;     // 'upper' or 'lower'
    public $selectedIndex = null;   // position index 0..15, this won't duplicate since each button has its own

    public function mount($appointment_id = null, $fromStaffCalendar = false)
    {
        // Try to load appointment if coming from calendar
        $this->appointment_id = $appointment_id;
        $this->fromStaffCalendar = in_array($fromStaffCalendar, [1, "1", true], true);

        if ($appointment_id) {
            $appointment = \App\Models\Appointment::with('patient')->find($appointment_id);
            if ($appointment && $appointment->patient) {
                $this->fillPatientDetails($appointment->patient);
            }
        }

        // initialize teeth arrays (keep your original logic)
        for ($i = 0; $i < 16; $i++) {
            $this->teeth['upper'][$i] = null;
            $this->teeth['lower'][$i] = null;
        }
    }

    // open modal for a specific jaw + position index (unique per jaw)
    public function openModal($jaw, $index)
    {
        // ensure index is integer
        $this->selectedJaw = $jaw;
        $this->selectedIndex = (int) $index;
        $this->showModal = true;
    }

    public function closeModal()
    {
        $this->showModal = false;
        $this->selectedJaw = null;
        $this->selectedIndex = null;
    }

    // set the status for the selected position (overwrites previous)
    public function selectToothCondition($status)
    {
        if (!$this->selectedJaw || $this->selectedIndex === null) return;

        $this->teeth[$this->selectedJaw][$this->selectedIndex] = $status;
        $this->closeModal();
    }

    public $statusMessage = null;

    public function submit()
    {
    // Basic validation: require ID + (adjust rules as needed)
    $this->validate([
        'oral_hygiene'   => 'nullable|string',
        'gingival_color' => 'nullable|string',
        'prophylaxis'    => 'boolean',
        'recommendation' => 'nullable|string',
    ]);

    // find patient id if APC id exists
    $patient = null;
    if (!empty($this->apc_id_number)) {
        $patient = Patient::where('apc_id_number', $this->apc_id_number)->first();
    }

    DB::beginTransaction();
    try {
        $record = DentalRecord::create([
            'patient_id'      => $patient ? $patient->id : null,
            'oral_hygiene'    => $this->oral_hygiene,
            'gingival_color'  => $this->gingival_color,
            'prophylaxis'     => (bool) $this->prophylaxis,
            'teeth'           => $this->teeth,        // JSON cast in model
            'recommendation'  => $this->recommendation,
        ]);

        DB::commit();

        // reset selections but keep patient visible
        $this->resetAfterSave();

        // redirect with toast (keeps your current behaviour)
        return redirect()
            ->route('medical-records')
            ->with('toast', [
                'style' => 'success',
                'message' => 'Record saved successfully!'
            ]);
        } catch (\Throwable $e) {
            DB::rollBack();
            \Log::error('DentalForm save failed: '.$e->getMessage());
            $this->statusMessage = 'Save failed: '.$e->getMessage();
        }
    }

    protected function resetAfterSave()
    {
        $this->oral_hygiene = null;
        $this->gingival_color = null;
        $this->prophylaxis = false;
        $this->recommendation = null;
        $this->showModal = false;

        // clear teeth selections
        for ($i = 0; $i < 16; $i++) {
            $this->teeth['upper'][$i] = null;
            $this->teeth['lower'][$i] = null;
        }
    }


    public function render()
    {
        // pass arrays to view to map index -> visible label
        $upper = array_merge($this->leftLabels, $this->rightLabels);
        $lower = array_merge($this->leftLabels, $this->rightLabels);

        return view('livewire.dental-form', compact('upper','lower'));
    }
}