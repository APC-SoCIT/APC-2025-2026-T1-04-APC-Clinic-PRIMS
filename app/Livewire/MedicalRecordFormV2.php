<?php

namespace App\Livewire;

use Livewire\Component;

class MedicalRecordFormV2 extends Component
{
    // uncomment when patient is connected here
    // public $appointment_id, $apc_id_number, $first_name, $middle_initial, $last_name, $gender, $age, $date_of_birth, $nationality, $blood_type, $civil_status, $religion, $contact_number, $email, $house_unit_number, $street, $barangay, $city, $province, $zip_code, $country, $emergency_contact_name, $emergency_contact_number, $emergency_contact_relationship;
    
    public $reason, $description, $allergies, $medications, $hospitalization, $operation, $weight, $height, $blood_pressure, $heart_rate, $respiratory_rate, $temperature, $bmi, $o2sat, $prescription;
    
    public $step = 1;
    public $substep = 1;
    public $hasHepatitis = false;
    public $hepatitis_type = null;
    public $showErrorModal = false;
    public $errorMessage = '';

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
    public $immunizations = [
        'COVID-19 1st' => null, 'COVID-19 2nd' => null, 'Booster 1' => null, 'Booster 2' => null, 'Hepa B' => null, 'HPV' => null, 'FLU VAC' => null
    ];
    public $physical_examinations = [];
    public $sections = [
        'General Appearance', 'Skin', 'Head and Scalp', 'Eyes (OD)', 'Eyes (OS)', 
        'Corrected (OD)', 'Corrected (OS)', 'Pupils', 'Ears, Eardrums', 'Nose, Sinuses', 
        'Mouth, Throat', 'Neck, Thyroid', 'Chest, Breast, Axilla', 
        'Heart- Cardiovascular', 'Lungs- Respiratory', 'Abdomen', 'Back, Flanks', 
        'Musculoskeletal', 'Extremities', 'Reflexes', 'Neurological'
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

    public function nextStep() {
        if ($this->step < 5) $this->step++;
    }

    public function previousStep() {
        if ($this->step > 1) $this->step--;
    }

    public function submitMedicalRecord() {
        // Save logic here
        // e.g. MedicalRecord::create([...])
    }
    public function render()
    {
        return view('livewire.medical-record-form-v2');
    }
}
