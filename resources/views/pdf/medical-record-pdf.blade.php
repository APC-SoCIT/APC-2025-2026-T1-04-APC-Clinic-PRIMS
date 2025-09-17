<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Medical Examination Report - {{ $patient->first_name }} {{ $patient->last_name }}</title>
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
            <td>{{ $patient->last_name }}, {{ $patient->first_name }} {{ $patient->middle_name ?? '' }}</td>
            <th>Sex</th>
            <td>{{ $patient->gender }}</td>
            <th>Age</th>
            <td>{{ \Carbon\Carbon::parse($patient->date_of_birth)->age }}</td>
        </tr>
        <tr>
            <th>Date of Birth</th>
            <td>{{ \Carbon\Carbon::parse($patient->date_of_birth)->format('F j, Y') }}</td>
            <th>Nationality</th>
            <td>{{ $patient->nationality ?? 'N/A' }}</td>
            <th>Blood Type</th>
            <td>{{ $patient->blood_type ?? 'N/A' }}</td>
        </tr>
        <tr>
            <th>Religion</th>
            <td>{{ $patient->religion ?? 'N/A' }}</td>
            <th>Status</th>
            <td colspan="3">{{ $patient->civil_status ?? 'N/A' }}</td>
        </tr>
        <tr>
            <th>Present Address</th>
            <td colspan="5">{{ $patient->address ?? 'N/A' }}</td>
        </tr>
        <tr>
            <th>Emergency Contact</th>
            <td colspan="5">{{ $patient->emergency_contact ?? 'N/A' }} - {{ $patient->emergency_number ?? 'N/A' }}</td>
        </tr>
    </table>

    <!-- Medical History -->
    <div class="section-title">I. MEDICAL HISTORY</div>
    <table>
        <tr>
            <th>Past Medical History</th>
            <td>
                @if($appointment->allergies) Allergies: {{ $appointment->allergies }} <br>@endif
                @if($appointment->mumps) Mumps <br>@endif
                @if($appointment->heart_disorder) Heart Disorder <br>@endif
                @if($appointment->bleeding_problem) Bleeding Problem <br>@endif
                @if($appointment->hepatitis) Hepatitis {{ $appointment->hepatitis_type ?? '' }} <br>@endif
                @if($appointment->chicken_pox) Chicken Pox <br>@endif
                @if($appointment->dengue) Dengue <br>@endif
                @if($appointment->kidney_disease) Kidney Disease <br>@endif
                @if($appointment->covid19) Covid-19 <br>@endif
            </td>
        </tr>
        <tr>
            <th>Family History</th>
            <td>
                @if($appointment->bronchial_asthma) Bronchial Asthma <br>@endif
                @if($appointment->diabetes_mellitus) Diabetes Mellitus <br>@endif
                @if($appointment->thyroid_disorder) Thyroid Disorder <br>@endif
                @if($appointment->cancer) Cancer <br>@endif
                @if($appointment->hypertension) Hypertension <br>@endif
                @if($appointment->liver_disease) Liver Disease <br>@endif
                @if($appointment->epilepsy) Epilepsy <br>@endif
            </td>
        </tr>
        <tr>
            <th>Personal & Social History</th>
            <td>
                Smoking: {{ $appointment->smoke ?? 'N/A' }} <br>
                Alcohol: {{ $appointment->alcohol_consumption ?? 'N/A' }} <br>
                Vape: {{ $appointment->vape ?? 'N/A' }} <br>
                Medications: {{ $appointment->medications ?? 'N/A' }}
            </td>
        </tr>
    </table>

    <!-- Immunizations -->
    <div class="section-title">II. IMMUNIZATIONS</div>
    <table>
        <tr>
            <th>Hepa B</th>
            <td>{{ $appointment->hepa_b ?? 'N/A' }}</td>
            <th>HPV</th>
            <td>{{ $appointment->hpv ?? 'N/A' }}</td>
            <th>Flu Vac</th>
            <td>{{ $appointment->flu_vac ?? 'N/A' }}</td>
        </tr>
        <tr>
            <th>Covid-19 (1st, 2nd, Booster)</th>
            <td colspan="5">{{ $appointment->covid_vaccine ?? 'N/A' }}</td>
        </tr>
    </table>

    <!-- Physical Examination -->
    <div class="section-title">III. PHYSICAL EXAMINATION</div>
    <table>
        <tr>
            <th>Height</th><td>{{ $appointment->height ?? 'N/A' }}</td>
            <th>Weight</th><td>{{ $appointment->weight ?? 'N/A' }}</td>
            <th>BMI</th><td>{{ $appointment->bmi ?? 'N/A' }}</td>
        </tr>
        <tr>
            <th>BP</th><td>{{ $appointment->bp ?? 'N/A' }}</td>
            <th>HR</th><td>{{ $appointment->hr ?? 'N/A' }}</td>
            <th>RR</th><td>{{ $appointment->rr ?? 'N/A' }}</td>
            <th>TEMP</th><td>{{ $appointment->temp ?? 'N/A' }}</td>
            <th>O2 Sat</th><td>{{ $appointment->o2sat ?? 'N/A' }}</td>
        </tr>
    </table>

    <div class="section-title">Findings</div>
    <table>
        <tr>
            <th>Exam</th>
            <th>Status</th>
            <th>Findings</th>
        </tr>
        <tr>
            <td>General Appearance</td>
            <td>{{ $appointment->appearance ?? 'Normal' }}</td>
            <td>{{ $appointment->appearance_findings ?? '' }}</td>
        </tr>
        <tr>
            <td>Skin</td>
            <td>{{ $appointment->skin ?? 'Normal' }}</td>
            <td>{{ $appointment->skin_findings ?? '' }}</td>
        </tr>
        <tr>
            <td>Eyes</td>
            <td>{{ $appointment->eyes ?? 'Normal' }}</td>
            <td>{{ $appointment->eyes_findings ?? '' }}</td>
        </tr>
        <tr>
            <td>Ears/Eardrums</td>
            <td>{{ $appointment->ears ?? 'Normal' }}</td>
            <td>{{ $appointment->ears_findings ?? '' }}</td>
        </tr>
        <tr>
            <td>Nose/Sinuses</td>
            <td>{{ $appointment->nose ?? 'Normal' }}</td>
            <td>{{ $appointment->nose_findings ?? '' }}</td>
        </tr>
        <tr>
            <td>Mouth/Throat</td>
            <td>{{ $appointment->throat ?? 'Normal' }}</td>
            <td>{{ $appointment->throat_findings ?? '' }}</td>
        </tr>
        <tr>
            <td>Neck/Thyroid</td>
            <td>{{ $appointment->neck ?? 'Normal' }}</td>
            <td>{{ $appointment->neck_findings ?? '' }}</td>
        </tr>
        <tr>
            <td>Chest/Breast/Axilla</td>
            <td>{{ $appointment->chest ?? 'Normal' }}</td>
            <td>{{ $appointment->chest_findings ?? '' }}</td>
        </tr>
        <tr>
            <td>Heart/Cardiovascular</td>
            <td>{{ $appointment->heart ?? 'Normal' }}</td>
            <td>{{ $appointment->heart_findings ?? '' }}</td>
        </tr>
        <tr>
            <td>Lungs/Respiratory</td>
            <td>{{ $appointment->lungs ?? 'Normal' }}</td>
            <td>{{ $appointment->lungs_findings ?? '' }}</td>
        </tr>
        <tr>
            <td>Abdomen</td>
            <td>{{ $appointment->abdomen ?? 'Normal' }}</td>
            <td>{{ $appointment->abdomen_findings ?? '' }}</td>
        </tr>
        <tr>
            <td>Back/Flanks</td>
            <td>{{ $appointment->back ?? 'Normal' }}</td>
            <td>{{ $appointment->back_findings ?? '' }}</td>
        </tr>
        <tr>
            <td>Musculoskeletal</td>
            <td>{{ $appointment->musculoskeletal ?? 'Normal' }}</td>
            <td>{{ $appointment->musculoskeletal_findings ?? '' }}</td>
        </tr>
        <tr>
            <td>Extremities</td>
            <td>{{ $appointment->extremities ?? 'Normal' }}</td>
            <td>{{ $appointment->extremities_findings ?? '' }}</td>
        </tr>
        <tr>
            <td>Reflexes</td>
            <td>{{ $appointment->reflexes ?? 'Normal' }}</td>
            <td>{{ $appointment->reflexes_findings ?? '' }}</td>
        </tr>
        <tr>
            <td>Neurological</td>
            <td>{{ $appointment->neuro ?? 'Normal' }}</td>
            <td>{{ $appointment->neuro_findings ?? '' }}</td>
        </tr>
    </table>


    <!-- Diagnosis -->
    <div class="section-title">Diagnosis</div>
    <p>{{ $appointment->diagnosis ?? 'N/A' }}</p>

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
