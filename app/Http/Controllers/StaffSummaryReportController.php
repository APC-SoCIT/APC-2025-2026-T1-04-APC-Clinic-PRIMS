<?php

namespace App\Http\Controllers;

use App\Models\Appointment;
use App\Models\Dispensed;
use App\Models\MedicalRecord;
use App\Models\Diagnosis;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Barryvdh\DomPDF\Facade\Pdf;
use Carbon\Carbon;

class StaffSummaryReportController extends Controller
{
    /**
     * Display the summary report dashboard.
     */
    public function index(Request $request)
{
    $user = Auth::user();
    if (!$user || !$user->hasRole('clinic staff')) {
        abort(403);
    }

    $month = $request->input('month', Carbon::now()->month);
    $year = $request->input('year', Carbon::now()->year);

    // Appointment Summary (Patients Only)
    $attendedCount = Appointment::where('status', 'completed')
        ->whereMonth('appointment_date', $month)
        ->whereYear('appointment_date', $year)
        ->count();

    $cancelledCount = Appointment::where('status', 'cancelled')
        ->whereMonth('appointment_date', $month)
        ->whereYear('appointment_date', $year)
        ->count();

    $totalAppointments = $attendedCount + $cancelledCount;
    $totalPatients = MedicalRecord::join('patients', 'medical_records.patient_id', '=', 'patients.id')
        ->whereMonth('medical_records.created_at', $month)
        ->whereYear('medical_records.created_at', $year)
        ->whereNull('medical_records.archived_at')
        ->distinct('patients.apc_id_number')
        ->count('patients.apc_id_number');

    // Most Prescribed Medications
    $medications = Dispensed::select('inventory_id', \DB::raw('SUM(quantity_dispensed) as total_dispensed'))
        ->whereMonth('date_dispensed', $month)
        ->whereYear('date_dispensed', $year)
        ->groupBy('inventory_id')
        ->orderByDesc('total_dispensed')
        ->take(5)
        ->with(['inventory.supply'])
        ->get()
        ->map(function ($dispensed) {
            return [
                'name' => $dispensed->inventory->supply->name,
                'quantity_dispensed' => $dispensed->total_dispensed,
            ];
        });

    // Common Diagnoses
    $commonDiagnoses = Diagnosis::select('diagnosis', \DB::raw('COUNT(*) as count'))
        ->whereMonth('created_at', $month)
        ->whereYear('created_at', $year)
        ->groupBy('diagnosis')
        ->orderByDesc('count')
        ->take(5)
        ->get();

    // Patient Demographics by Age Group
    $ageGroups = [
        '15-18'  => 0,
        '19-25'  => 0,
        '26-35'  => 0,
        '36-50'  => 0,
        '51+'    => 0,
    ];

    $medicalRecords = MedicalRecord::whereMonth('created_at', $month)
        ->whereYear('created_at', $year)
        ->with('patient')
        ->get();

    foreach ($medicalRecords as $record) {
        $age = $record->patient->birthdate->age ?? null;

        if ($age !== null) {
            if ($age >= 15 && $age <= 18) {
                $ageGroups['15-18']++;
            } elseif ($age >= 19 && $age <= 25) {
                $ageGroups['19-25']++;
            } elseif ($age >= 26 && $age <= 35) {
                $ageGroups['26-35']++;
            } elseif ($age >= 36 && $age <= 50) {
                $ageGroups['36-50']++;
            } else {
                $ageGroups['51+']++;
            }
        }
    }

    $chartAgeGroups = collect($ageGroups)->map(function ($count, $label) {
        return ['label' => $label, 'count' => $count];
    })->values();

    // 🔹 NEW: Incoming (approved + future) appointments
    $incomingAppointments = Appointment::with(['patient', 'doctor'])
        ->where('status', 'approved')
        ->whereDate('appointment_date', '>=', Carbon::today())
        ->orderBy('appointment_date', 'asc')
        ->take(5) // limit to 5 for dashboard preview
        ->get();

    return view('staff-summary-report', [
        'attendedCount'     => $attendedCount,
        'cancelledCount'    => $cancelledCount,
        'totalPatients'     => $totalPatients,
        'medications'       => $medications,
        'diagnoses'         => $commonDiagnoses,
        'ageGroups'         => $chartAgeGroups,
        'selectedMonth'     => $month,
        'selectedYear'      => $year,
        'incomingAppointments' => $incomingAppointments, // 🔹 pass to blade
    ]);
}
    
    /**
     * Generate PDF accomplishment report.
     */
    public function generateAccomplishmentReport(Request $request)
    {
        $type = $request->input('type', 'monthly');
        $year = $request->input('year', Carbon::now()->year);
        $month = $type === 'monthly' ? $request->input('month') : null;
        if ($type === 'monthly' && !$month) {
            $month = Carbon::now()->month; 
        }

        $attendedCount = Appointment::when($month, fn($q) => $q->whereMonth('appointment_date', $month))
            ->whereYear('appointment_date', $year)
            ->where('status', 'completed')
            ->count();

        $cancelledCount = Appointment::when($month, fn($q) => $q->whereMonth('appointment_date', $month))
            ->whereYear('appointment_date', $year)
            ->where('status', 'cancelled')
            ->count();

        $totalPatients = MedicalRecord::join('patients', 'medical_records.patient_id', '=', 'patients.id')
            ->when($month, fn($q) => $q->whereMonth('medical_records.created_at', $month))
            ->whereYear('medical_records.created_at', $year)
            ->whereNull('medical_records.archived_at')
            ->distinct('patients.apc_id_number')
            ->count('patients.apc_id_number');

        $allDiagnoses = [
            'Cardiology' => ['Hypertension', 'BP Monitoring', 'Bradycardia', 'Hypotension', 'Angina'],
            'Pulmonology' => ['URTI', 'Pneumonia', 'PTB', 'Bronchitis', 'Lung Pathology'],
            'Gastroenterology' => ['Acute Gastroenteritis', 'GERD', 'Hemorrhoids', 'Anorexia'],
            'Neurology' => ['Tension Headache', 'Migraine', 'Vertigo', 'Insomnia'],
            'Endocrinology' => ['Diabetes Mellitus', 'Dyslipidemia'],
            'Nephrology' => ['Urinary Tract Infection'],
        ];

        $existingDiagnoses = Diagnosis::when($month, fn($q) => $q->whereMonth('created_at', $month))
            ->whereYear('created_at', $year)
            ->select('diagnosis', \DB::raw('COUNT(*) as count'))
            ->groupBy('diagnosis')
            ->pluck('count', 'diagnosis')
            ->toArray();

        $categorizedDiagnoses = [];
        foreach ($allDiagnoses as $category => $diagList) {
            foreach ($diagList as $diagName) {
                $categorizedDiagnoses[$category][] = [
                    'name' => $diagName,
                    'count' => $existingDiagnoses[$diagName] ?? 0,
                ];
            }
        }

        $staffName = Auth::user()->name;

        $pdf = Pdf::loadView('pdf.report', compact(
            'month',
            'year',
            'type',
            'totalPatients',
            'attendedCount',
            'cancelledCount',
            'staffName',
            'categorizedDiagnoses'
        ));

        return $pdf->stream('accomplishment-report.pdf');
    }
}