<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Medical Examination Report - {{ $record->patient->first_name ?? 'N/A' }} {{ $record->patient->last_name ?? '' }}</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            font-size: 12px;
            margin: 20px;
        }
        .header {
            text-align: center;
            margin-bottom: 20px;
        }
        .header h2 {
            margin: 0;
            font-size: 18px;
        }
        .header p {
            margin: 2px 0;
            font-size: 12px;
        }
        table {
            width: 100%;
            border-collapse: collapse;
            margin-bottom: 15px;
        }
        td, th {
            border: 1px solid #000;
            padding: 6px;
            vertical-align: top;
        }
        .section-title {
            font-weight: bold;
            margin-top: 15px;
            margin-bottom: 5px;
            font-size: 14px;
        }
    </style>
</head>
<body>

    <!-- Header -->
    <div class="header">
        <h2>Asia Pacific College Medical Clinic</h2>
        <p>#3 Humabon Place, Magallanes Village, Makati City</p>
        <p>Tel. no. 852-9232 loc.420 | Mobile: (+63) 917 832 5385</p>
        <p>Email: clinic@apc.edu.ph</p>
        <h2>Medical Examination Report</h2>
    </div>

    <!-- Patient Information -->
    <table>
        <tr>
            <th>Name</th>
            <td>{{ $record->patient->last_name ?? 'N/A' }}, {{ $record->patient->first_name ?? '' }} {{ $record->patient->middle_initial ?? '' }}</td>
            <th>Sex</th>
            <td>{{ $record->patient->gender ?? 'N/A' }}</td>
            <th>Age</th>
            <td>{{ \Carbon\Carbon::parse($record->patient->date_of_birth ?? now())->age }}</td>
        </tr>
        <tr>
            <th>Date of Birth</th>
            <td>{{ \Carbon\Carbon::parse($record->patient->date_of_birth ?? now())->format('F j, Y') }}</td>
            <th>Nationality</th>
            <td>{{ $record->patient->nationality ?? 'N/A' }}</td>
            <th>Blood Type</th>
            <td>{{ $record->patient->blood_type ?? 'N/A' }}</td>
        </tr>
        <tr>
            <th>Religion</th>
            <td>{{ $record->patient->religion ?? 'N/A' }}</td>
            <th>Status</th>
            <td colspan="3">{{ $record->patient->civil_status ?? 'N/A' }}</td>
        </tr>
        <tr>
            <th>Present Address</th>
            <td colspan="5">
                {{ $record->patient->house_unit_number ?? '' }} {{ $record->patient->street ?? '' }}, {{ $record->patient->barangay ?? '' }}, {{ $record->patient->city ?? '' }}, {{ $record->patient->province ?? '' }} {{ $record->patient->zip_code ?? '' }}, {{ $record->patient->country ?? '' }}
            </td>
        </tr>
        <tr>
            <th>Emergency Contact</th>
            <td colspan="5">{{ $record->patient->emergency_contact_name ?? 'N/A' }} - {{ $record->patient->emergency_contact_number ?? 'N/A' }}</td>
        </tr>
    </table>

    <!-- Medical History -->
    <div class="section-title">I. MEDICAL HISTORY</div>
    <table>
        <tr>
            <th>Past Medical History</th>
            <td>
                {{ $record->allergies ? "Allergies: $record->allergies" : '' }}<br>
                @php $pmh = json_decode($record->past_medical_history, true) ?? []; @endphp
                @foreach($pmh as $condition => $value)
                    @if($value === 'Yes')
                        {{ $condition }}<br>
                    @elseif($condition === 'Hepatitis' && $value)
                        Hepatitis {{ $value }}<br>
                    @endif
                @endforeach
            </td>
        </tr>
        <tr>
            <th>Family History</th>
            <td>
                @php 
                    $fh = json_decode($record->family_history, true) ?? []; 

                    $default_family_history = [
                        'Bronchial Asthma',
                        'Diabetes Mellitus',
                        'Thyroid Disorder',
                        'Cancer',
                        'Hypertension',
                        'Liver Disease',
                        'Epilepsy'
                    ];
                @endphp

                @foreach($default_family_history as $item)
                    @php
                        // Try to get value from JSON, fallback to 'No'
                        $key = str_replace(' ', '_', strtolower($item)); 
                        $value = $fh[$key] ?? $fh[$item] ?? 'No';
                        $value = ucfirst(strtolower($value)); // Ensure Yes/No capitalization
                    @endphp
                    {{ $item }}: {{ $value }}<br>
                @endforeach
            </td>
        </tr>
            <th>Personal & Social History</th>
            <td>
                @php $ph = json_decode($record->personal_history, true) ?? []; @endphp
                Smoking: {{ $ph['Smoke'] ?? 'N/A' }}<br>
                Alcohol: {{ $ph['Alcohol'] ?? 'N/A' }}<br>
                Vape: {{ $ph['Vape'] ?? 'N/A' }}<br>
                Medications: {{ $record->medications ?? 'N/A' }}
            </td>
        </tr>
    </table>

    <!-- Immunizations -->
    <div class="section-title">II. IMMUNIZATIONS</div>
    @php $immunizations = json_decode($record->immunizations, true) ?? []; @endphp
    <table>
        <tr>
            <th>Hepa B</th>
            <td>{{ $immunizations['Hepa B'] ?? 'N/A' }}</td>
            <th>HPV</th>
            <td>{{ $immunizations['HPV'] ?? 'N/A' }}</td>
            <th>Flu Vac</th>
            <td>{{ $immunizations['FLU VAC'] ?? 'N/A' }}</td>
        </tr>
        <tr>
            <th>Covid-19 (1st, 2nd, Booster)</th>
            <td colspan="5">{{ $immunizations['COVID-19 1st'] ?? 'N/A' }} / {{ $immunizations['COVID-19 2nd'] ?? 'N/A' }} / {{ $immunizations['Booster 1'] ?? 'N/A' }} / {{ $immunizations['Booster 2'] ?? 'N/A' }}</td>
        </tr>
    </table>

    <div class="section-title">III. PHYSICAL EXAMINATION</div>

    <!-- Vitals Table -->
    <table>
        <tr>
            <th>Height</th><td>{{ $record->height ?? 'N/A' }}</td>
            <th>Weight</th><td>{{ $record->weight ?? 'N/A' }}</td>
            <th>BMI</th><td>{{ $record->bmi ?? 'N/A' }}</td>
        </tr>
        <tr>
            <th>BP</th><td>{{ $record->blood_pressure ?? 'N/A' }}</td>
            <th>HR</th><td>{{ $record->heart_rate ?? 'N/A' }}</td>
            <th>RR</th><td>{{ $record->respiratory_rate ?? 'N/A' }}</td>
        </tr>
        <tr>
            <th>Temperature</th>
            <td>{{ $record->temperature ?? 'N/A' }}</td>
            <th>O2 Sat</th>
            <td colspan="3">{{ $record->o2sat ?? 'N/A' }}</td>
        </tr>
    </table>

    <!-- Detailed Physical Examination Findings -->
    <table>
        <tr>
            <th style="width:25%">Exam</th>
            <th style="width:15%">Status</th>
            <th style="width:60%">Findings</th>
        </tr>
        @foreach($record->physicalExaminations as $exam)
        <tr>
            <td>{{ $exam->section }}</td>
            <td>{{ $exam->normal ? 'Normal' : 'Abnormal' }}</td>
            <td>{{ $exam->findings ?? 'N/A' }}</td>
        </tr>
        @endforeach
    </table>

    <!-- Diagnosis -->
    <div class="section-title">Diagnosis & Notes</div>
    <table>
        @foreach($record->diagnoses as $diag)
        <tr>
            <td>{{ $diag->diagnosis }}</td>
            <td>{{ $diag->diagnosis_notes ?? '' }}</td>
        </tr>
        @endforeach
    </table>

    <!-- Prescription -->
    <div class="section-title">Prescription</div>
   

    <!-- Authorization -->
    <p>
        I hereby authorize this clinic and its officially designated examining physician to furnish information that the school may need pertaining to my health status and other pertinent medical findings and to hereby release them from all legal responsibility.
    </p>

    <br><br>
    <table>
        <tr>
            <td>(Signature over printed name)<br>Date: _____________</td>
            <td>School Nurse</td>
            <td>School Physician</td>
        </tr>
    </table>

</body>
</html>
