<?php

namespace App\Livewire;

use Livewire\Component;
use App\Models\Patient;
use App\Models\RfidCard;
use Carbon\Carbon;

class DentalForm extends Component
{
    public $apc_id_number, $email, $first_name, $mi, $last_name, $contact_number,
           $dob, $age, $gender, $street_number, $barangay, $city,
           $province, $zip_code, $country, $nationality;

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

        if ($patient) {
            $this->email = $patient->email;
            $this->first_name = $patient->first_name;
            $this->mi = $patient->middle_initial;
            $this->last_name = $patient->last_name;
            $this->dob = $patient->date_of_birth;
            $this->gender = $patient->gender;
            $this->street_number = $patient->street_number;
            $this->barangay = $patient->barangay;
            $this->city = $patient->city;
            $this->province = $patient->province;
            $this->zip_code = $patient->zip_code;
            $this->country = $patient->country;
            $this->contact_number = $patient->contact_number;
            $this->nationality = $patient->nationality;
            $this->calculateAge();
        } else {
            $this->resetPatientFields();
        }
    }

    private function resetPatientFields()
    {
        $this->email = null; $this->first_name = null; $this->mi = null; $this->last_name = null;
        $this->dob = null; $this->age = null; $this->gender = null; $this->street_number = null;
        $this->barangay = null; $this->city = null; $this->province = null; $this->zip_code = null;
        $this->country = null; $this->contact_number = null; $this->nationality = null;
    }

    public function calculateAge()
    {
        $this->age = $this->dob ? Carbon::parse($this->dob)->age : null;
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

    public function mount()
    {
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
        // For testing: don't save to DB yet. Just set a message we can show in the UI.
        $this->statusMessage = 'Submitted successfully';

        // close modal just in case
        $this->showModal = false;

        // Optionally, you can still flash if you prefer:
        // session()->flash('success', 'Dental record submitted successfully!');
    }


    public function render()
    {
        // pass arrays to view to map index -> visible label
        $upper = array_merge($this->leftLabels, $this->rightLabels);
        $lower = array_merge($this->leftLabels, $this->rightLabels);

        return view('livewire.dental-form', compact('upper','lower'));
    }
}
