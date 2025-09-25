<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\MedicalRecord;
use App\Models\Appointment;
use App\Models\Patient;
use App\Models\ClinicStaff;
use Carbon\Carbon;
use Barryvdh\DomPDF\Facade\Pdf;

class MedicalRecordController extends Controller
{
    public $archiveRecord, $appointmentId, $appointment;

    /**
     * View a single medical record.
     */
    public function view($id)
    {
        $record = MedicalRecord::with(['patient', 'diagnoses'])->findOrFail($id);
        return view('view-medical-record', compact('record'));
    }

    /**
     * Print medical record(s) associated with an appointment.
     */
    public function printMedicalRecord($id)
    {
        $record = MedicalRecord::with(['patient','diagnoses'])->findOrFail($id);

        if (!$record->patient) {
            abort(404, 'Patient not found for this medical record.');
        }

        // Decode family history JSON or use empty array
        $family_history = is_array($record->family_history)
            ? $record->family_history
            : json_decode($record->family_history, true) ?? [];

        // Ensure all default family history items are present
        $default_family_history = [
            'Bronchial Asthma',
            'Diabetes Mellitus',
            'Thyroid Disorder',
            'Cancer',
            'Hypertension',
            'Liver Disease',
            'Epilepsy'
        ];

        foreach ($default_family_history as $item) {
            if (!isset($family_history[$item])) {
                $family_history[$item] = 'No';
            }
        }

        $pdf = \PDF::loadView('pdf.medical-record-pdf', [
            'record'         => $record,
            'diagnoses'      => $record->diagnoses,
            'family_history' => $family_history,
        ])->setPaper('A4', 'portrait');

        return $pdf->stream('medical_record_' . $record->id . '.pdf');
    }

    /**
     * Create a new medical record from appointment.
     */
    public function create(Request $request)
    {
        $appointmentId = $request->appointmentId;
        $appointment = Appointment::with('patient')->findOrFail($appointmentId);

        return view('livewire.add-medical-record', [
            'patient' => $appointment->patient,
            'appointmentId' => $appointment->id,
            'email' => $appointment->patient->email,
            'apc_id_number' => $appointment->patient->apc_id_number,
            'first_name' => $appointment->patient->first_name,
            'mi' => $appointment->patient->middle_initial,
            'last_name' => $appointment->patient->last_name,
            'dob' => $appointment->patient->date_of_birth,
            'gender' => $appointment->patient->gender,
            'street_number' => $appointment->patient->street_number,
            'barangay' => $appointment->patient->barangay,
            'city' => $appointment->patient->city,
            'province' => $appointment->patient->province,
            'zip_code' => $appointment->patient->zip_code,
            'country' => $appointment->patient->country,
            'contact_number' => $appointment->patient->contact_number,
            'nationality' => $appointment->patient->nationality,
            'age' => Carbon::parse($appointment->patient->date_of_birth)->age,
        ]);
    }
}
