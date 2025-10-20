<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use App\Models\Diagnosis;
use App\Models\MedicalRecord;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Diagnosis>
 */
class DiagnosisFactory extends Factory
{
    protected $model = Diagnosis::class;
     
    public function definition(): array
    {
        $diagnosisList = [
            'Hypertension', 'BP Monitoring', 'Bradycardia', 'Hypotension', 'Angina', 'URTI', 'Pneumonia', 'PTB', 'Bronchitis', 'Lung Pathology', 'Acute Bronchitis', 'Acute Gastroenteritis', 'GERD', 'Hemorrhoids', 'Anorexia', 'Ligament Sprain', 'Muscle Strain', 'Costochondritis', 'Soft Tissue Contusion', 'Fracture', 'Gouty Arthritis', 'Plantar Fasciitis', 'Dislocation', 'Conjunctivitis', 'Stye', 'Foreign Body', 'Stomatitis', 'Epistaxis', 'Otitis Media', 'Foreign Body Removal', 'Tension Headache', 'Migraine', 'Vertigo', 'Hyperventilation Syndrome', 'Insomnia', 'Seizure', 'Bell\'s Palsy', 'Folliculitis', 'Acne', 'Burn', 'Wound Dressing', 'Infected Wound', 'Blister Wound', 'Seborrheic Dermatitis', 'Bruise/Hematoma', 'Urinary Tract Infection', 'Renal Disease', 'Urolithiasis', 'Hypoglycemia', 'Dyslipidemia', 'Diabetes Mellitus', 'Dysmenorrhea', 'Hormonal Imbalance', 'Pregnancy', 'Leukemia', 'Blood Dyscrasia', 'Anemia', 'Lacerated Wound', 'Punctured Wound', 'Animal Bite', 'Superficial Abrasions', 'Contact Dermatitis', 'Allergic Rhinitis', 'Bronchial Asthma', 'Hypersensitivity', 'Post Traumatic Stress', 'Bipolar Disorder', 'Clinical Depression', 'Major Depressive Disorder', 'Agoraphobia', 'ADHD', 'Anxiety Disorder', 'Others'
        ];

        return [
            'medical_record_id' => MedicalRecord::inRandomOrder()->value('id') ?? 1,
            'diagnosis' => $this->faker->randomElement($diagnosisList),
            'diagnosis_notes' => $this->faker->optional()->sentence(8),
        ];
    }
}