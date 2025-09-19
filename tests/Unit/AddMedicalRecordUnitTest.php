<?php

namespace Tests\Unit;

use Tests\TestCase; // ✅ Laravel TestCase
use Livewire\Livewire;
use App\Livewire\AddMedicalRecord;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Carbon\Carbon;

class AddMedicalRecordUnitTest extends TestCase
{
    public function test_calculate_age_sets_correct_value()
    {
        $dob = now()->subYears(25)->format('Y-m-d');

        Livewire::test(AddMedicalRecord::class)
            ->set('dob', $dob)
            ->call('calculateAge')
            ->assertSet('age', 25);
    }

    public function test_add_and_remove_diagnosis_works()
    {
        Livewire::test(AddMedicalRecord::class)
            ->call('addDiagnosis')
            ->assertCount('diagnoses', 2)
            ->call('removeDiagnosis', 0)
            ->assertCount('diagnoses', 1);
    }

    public function test_search_patient_resets_fields_if_not_found()
    {
        Livewire::test(AddMedicalRecord::class)
            ->set('apc_id_number', 'NONEXISTENT')
            ->call('searchPatient')
            ->assertSet('first_name', null)
            ->assertSet('email', null)
            ->assertSet('age', null);
    }
}