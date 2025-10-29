<?php

namespace App\Livewire;

use Livewire\Component;
use App\Models\Patient;
use App\Models\MedicalRecord;
use App\Models\Diagnosis;
use App\Models\PhysicalExamination;
use App\Models\Appointment;

class MedicalRecordFormV2 extends Component
{
    public $step = 1;
    public $substep = 1;

    public $apc_id_number, $first_name, $middle_initial, $last_name, $gender, $age, $date_of_birth, $nationality, $blood_type, $civil_status, $religion, $contact_number, $email, $house_unit_number, $street, $barangay, $city, $province, $zip_code, $country, $emergency_contact_name, $emergency_contact_number, $emergency_contact_relationship;
    public $reason, $description, $allergies, $medications, $weight, $height, $blood_pressure, $heart_rate, $respiratory_rate, $temperature, $bmi, $o2sat, $prescription;
    public $appointment_id;
    public $showErrorModal = false;
    public $errorMessage = '';
    public $fromStaffCalendar = false;
    public $physical_examinations = [];
    public $sections = [
        'General Appearance', 'Skin', 'Head and Scalp', 'Eyes (OD)', 'Eyes (OS)', 
        'Corrected (OD)', 'Corrected (OS)', 'Pupils', 'Ears, Eardrums', 'Nose, Sinuses', 
        'Mouth, Throat', 'Neck, Thyroid', 'Chest, Breast, Axilla', 
        'Heart- Cardiovascular', 'Lungs- Respiratory', 'Abdomen', 'Back, Flanks', 
        'Musculoskeletal', 'Extremities', 'Reflexes', 'Neurological'
    ];

    public $past_medical_history = [
        'Mumps' => null, 'Heart Disorder' => null, 'Bleeding Problem' => null, 'Hepatitis' => null,
        'Chicken Pox' => null, 'Dengue' => null, 'Kidney Disease' => null, 'Covid-19' => null
    ];

    public $family_history = [
        'Bronchial Asthma' => null, 'Diabetes Mellitus' => null, 'Thyroid Disorder' => null, 
        'Cancer' => null, 'Hypertension' => null, 'Liver Disease' => null, 'Epilepsy' => null
    ];

    public $personal_history = [
        'sticks_per_day' => null, 'packs_per_year' => null, 'Vape' => null, 'Alcohol' => null
    ];

    public $obgyne_history = [
        'LNMP' => null, 'OB Score' => null, 'Date of Last Delivery' => null
    ];

    public $hospitalization = null;
    public $operation = null;

    public $immunizations = [
        'COVID-19 1st' => null, 'COVID-19 2nd' => null, 'Booster 1' => null, 'Booster 2' => null, 'Hepa B' => null, 'HPV' => null, 'FLU VAC' => null
    ];
    
    public $diagnoses = [
        ['diagnosis' => '', 'notes' => '']
    ];
    public $diagnosisOptions = [
        'Hypertension', 'BP Monitoring', 'Bradycardia', 'Hypotension', 'Angina', 'URTI', 'Pneumonia', 'PTB', 'Bronchitis', 'Lung Pathology', 'Acute Bronchitis', 'Acute Gastroenteritis', 'GERD', 'Hemorrhoids', 'Anorexia', 'Ligament Sprain', 'Muscle Strain', 'Costochondritis', 'Soft Tissue Contusion', 'Fracture', 'Gouty Arthritis', 'Plantar Fasciitis', 'Dislocation', 'Conjunctivitis', 'Stye', 'Foreign Body', 'Stomatitis', 'Epistaxis', 'Otitis Media', 'Foreign Body Removal', 'Tension Headache', 'Migraine', 'Vertigo', 'Hyperventilation Syndrome', 'Insomnia', 'Seizure', 'Bell\'s Palsy', 'Folliculitis', 'Acne', 'Burn', 'Wound Dressing', 'Infected Wound', 'Blister Wound', 'Seborrheic Dermatitis', 'Bruise/Hematoma', 'Urinary Tract Infection', 'Renal Disease', 'Urolithiasis', 'Hypoglycemia', 'Dyslipidemia', 'Diabetes Mellitus', 'Dysmenorrhea', 'Hormonal Imbalance', 'Pregnancy', 'Leukemia', 'Blood Dyscrasia', 'Anemia', 'Lacerated Wound', 'Punctured Wound', 'Animal Bite', 'Superficial Abrasions', 'Contact Dermatitis', 'Allergic Rhinitis', 'Bronchial Asthma', 'Hypersensitivity', 'Post Traumatic Stress', 'Bipolar Disorder', 'Clinical Depression', 'Major Depressive Disorder', 'Agoraphobia', 'ADHD', 'Anxiety Disorder', 'Others'
    ];

    public function updated($property)
    {
        if (in_array($property, ['weight', 'height'])) {
            $this->calculateBmi();
        }
    }

    private function calculateBmi()
    {
        if ($this->weight && $this->height) {
            $heightInMeters = $this->height / 100;
            if ($heightInMeters > 0) {
                $this->bmi = round($this->weight / ($heightInMeters ** 2), 2);
            }
        }
    }

    public function addDiagnosis()
    {
        $this->diagnoses[] = ['diagnosis' => '', 'notes' => ''];
    }

    public function removeDiagnosis($index)
    {
        unset($this->diagnoses[$index]);
        $this->diagnoses = array_values($this->diagnoses); // reindex
    }

    public function nextStep()
    {
        if ($this->step === 1) {
            $this->validate([
                'reason' => 'required|string',
                'description' => 'required|string|min:5',
            ]);
        }

        if ($this->step === 3) {
            $this->validate([
                'weight' => 'required|numeric|min:1',
                'height' => 'required|numeric|min:1',
                'blood_pressure' => 'required|string',
                'heart_rate' => 'required|numeric|min:1',
                'respiratory_rate' => 'required|numeric|min:1',
                'temperature' => 'required|numeric|min:1',
                'o2sat' => 'required|numeric|min:1',
                'physical_examinations.*.normal' => 'nullable|boolean',
                'physical_examinations.*.findings' => 'nullable|string',
            ]);

            $invalid = collect($this->physical_examinations)
                ->filter(fn($row) => empty($row['normal']) && empty($row['findings']))
                ->isNotEmpty();

            $this->addError('physical_examinations', 'Please check normal or input findings for every row.');
                return;
        }

        if ($this->step < 4) {
            $this->step++;
        }
    }


    public function previousStep() {
        if ($this->step > 1) $this->step--;
    }

    public function rules()
    {
        return [
            'physical_examinations.*.normal' => 'nullable|boolean',
            'physical_examinations.*.findings' => 'nullable|string',
        ];
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

    public function submitMedicalRecord() 
    {
        $this->validate([
            'apc_id_number' => 'required|exists:patients,apc_id_number',
            'reason' => 'required|not_in:""',
            'description' => 'required|string|min:1|max:1000',
        ]);

        $this->personal_history['sticks_per_day'] = $this->personal_history['sticks_per_day'] ?: 'N/A';
        $this->personal_history['packs_per_year'] = $this->personal_history['packs_per_year'] ?: 'N/A';

        // physical examination vitals validation
        if (
            empty($this->weight) ||
            empty($this->height) ||
            empty($this->blood_pressure) ||
            empty($this->heart_rate) ||
            empty($this->respiratory_rate) ||
            empty($this->temperature) || 
            empty($this->o2sat)
        ) {
            $this->errorMessage = 'Please fill out all <strong>Physical Examination vitals</strong>.';
            $this->showErrorModal = true;
            return;
        }

        // physical examinations table validation
        foreach ($this->sections as $section) {
            $row = $this->physical_examinations[$section] ?? ['normal' => null, 'findings' => ''];

            $normal = !empty($row['normal']);
            $findings = trim($row['findings'] ?? '');

            if (!$normal && $findings === '') {
                $this->errorMessage = 'Please fill out the <strong>Physical Examination</strong> table completely.';
                $this->showErrorModal = true;
                return;
            }
        }

        $patient = Patient::where('apc_id_number', $this->apc_id_number)->firstOrFail();
        $clinicStaff = \App\Models\ClinicStaff::where('user_id', auth()->id())->first();

        $medicalRecord = MedicalRecord::create([
            'patient_id' => $patient->id,
            'appointment_id' => $this->appointment_id,
            'reason' => $this->reason,
            'description' => $this->description,
            'allergies' => $this->allergies,
            'medications' => $this->medications,
            'past_medical_history' => json_encode($this->past_medical_history),
            'family_history' => json_encode($this->family_history),
            'personal_history' => json_encode($this->personal_history),
            'obgyne_history' => json_encode($this->obgyne_history),
            'hospitalization' => $this->hospitalization,
            'operation' => $this->operation,
            'immunizations' => json_encode($this->immunizations),
            'weight' => $this->weight,
            'height' => $this->height,
            'blood_pressure' => $this->blood_pressure,
            'heart_rate' => $this->heart_rate,
            'respiratory_rate' => $this->respiratory_rate,
            'temperature' => $this->temperature,
            'bmi' => $this->bmi,
            'o2sat' => $this->o2sat,
            'last_visited' => now(),
            // If structured prescriptions have meaningful data, prefer saving them as JSON.
            'prescription' => $this->buildPrescriptionPayload(),
            'doctor_id' => $clinicStaff?->id,
        ]);

        foreach ($this->diagnoses as $diag) {
            if (!empty($diag['diagnosis'])) {
                Diagnosis::create([
                    'medical_record_id' => $medicalRecord->id,
                    'diagnosis' => $diag['diagnosis'],
                    'diagnosis_notes' => $diag['notes'] ?? null,
                ]);
            }
        }

        foreach ($this->physical_examinations as $section => $data) {
            PhysicalExamination::create([
                'medical_record_id' => $medicalRecord->id,
                'section' => $section,
                'normal' => !empty($data['normal']),
                'findings' => $data['findings'] ?? null,
            ]);
        }

        if ($this->fromStaffCalendar && $this->appointment_id) {
            Appointment::where('id', $this->appointment_id)->update(['status' => 'completed']);
        }

        $this->reset();
        $this->physical_examinations = [];
        $this->diagnoses = [];
        $this->dispatch('recordAdded');

        return redirect()
            ->route('medical-records')
            ->with('toast', [
                'style' => 'success',
                'message' => 'Record saved successfully!'
                ]);

    }

    public function render()
    {
        return view('livewire.medical-record-form-v2', [
            'buttonLabel' => $this->fromStaffCalendar ? 'Complete Appointment' : 'Submit',
        ]);
    }
}
