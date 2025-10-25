<?php

namespace Tests\Unit;

use Tests\TestCase; // ✅ Laravel TestCase
use Livewire\Livewire;
use App\Livewire\AddMedicalRecord;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Carbon\Carbon;

class AddMedicalRecordUnitTest extends TestCase
{
    public function test_it_calculates_bmi_correctly()
    {
        $component = new AddMedicalRecord();

        $component->weight = 70; // kg
        $component->height = 170; // cm

        // Trigger BMI calculation
        $component->updated('weight');

        $this->assertEquals(24.22, $component->bmi);
    }

    public function test_it_does_not_crash_when_height_is_zero()
    {
        $component = new AddMedicalRecord();

        $component->weight = 70;
        $component->height = 0;
        $component->updated('height');

        $this->assertNull($component->bmi); // or remains unset
    }

    public function test_it_returns_validation_rules()
    {
        $component = new AddMedicalRecord();
        $rules = $component->rules();

        $this->assertArrayHasKey('physical_examinations.*.normal', $rules);
        $this->assertArrayHasKey('physical_examinations.*.findings', $rules);
    }

    public function test_it_can_add_and_remove_diagnosis_entries()
    {
        $component = new AddMedicalRecord();

        $this->assertCount(0, $component->diagnoses);

        $component->addDiagnosis();
        $this->assertCount(1, $component->diagnoses);

        $component->addDiagnosis();
        $this->assertCount(2, $component->diagnoses);

        $component->removeDiagnosis(0);
        $this->assertCount(1, $component->diagnoses);
    }

}