<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dental Record Report - {{ $record->patient->first_name ?? 'N/A' }} {{ $record->patient->last_name ?? '' }}</title>
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
        th, td {
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
        <h2>Dental Record Report</h2>
    </div>

    <!-- Patient Information -->
    <table>
        <tr>
            <th>ID Number</th>
            <td>{{ $record->patient->apc_id_number ?? 'N/A' }}</td>
            <th>Name</th>
            <td>{{ $record->patient->last_name ?? '' }}, {{ $record->patient->first_name ?? '' }} {{ $record->patient->middle_initial ?? '' }}</td>
        </tr>
        <tr>
            <th>Gender</th>
            <td>{{ $record->patient->gender ?? 'N/A' }}</td>
            <th>Age</th>
            <td>{{ \Carbon\Carbon::parse($record->patient->date_of_birth ?? now())->age }}</td>
        </tr>
        <tr>
            <th>Date of Birth</th>
            <td>{{ \Carbon\Carbon::parse($record->patient->date_of_birth ?? now())->format('F j, Y') }}</td>
            <th>Contact</th>
            <td>{{ $record->patient->contact_number ?? 'N/A' }}</td>
        </tr>
    </table>

    <!-- Dental Examination -->
    <div class="section-title">I. DENTAL EXAMINATION</div>
    <table>
        <tr>
            <th>Oral Hygiene</th>
            <td>{{ $record->oral_hygiene ?? 'N/A' }}</td>
            <th>Gingival Color</th>
            <td>{{ $record->gingival_color ?? 'N/A' }}</td>
        </tr>
        <tr>
            <th>Procedures</th>
            <td colspan="3">
                @if ($record->prophylaxis)
                    Oral Prophylaxis
                @else
                    None
                @endif
            </td>
        </tr>
    </table>

    <!-- Selected Tooth Numbers -->
    <div class="section-title">II. SELECTED TOOTH NUMBERS</div>
    <table>
        <tr>
            <th>Upper Teeth</th>
            <td>
                @php
                    $upperTeeth = collect($record->teeth['upper'] ?? [])->filter(fn($v) => $v);
                @endphp
                {{ $upperTeeth->isNotEmpty() ? implode(', ', array_keys($upperTeeth->toArray())) : 'None selected' }}
            </td>
        </tr>
        <tr>
            <th>Lower Teeth</th>
            <td>
                @php
                    $lowerTeeth = collect($record->teeth['lower'] ?? [])->filter(fn($v) => $v);
                @endphp
                {{ $lowerTeeth->isNotEmpty() ? implode(', ', array_keys($lowerTeeth->toArray())) : 'None selected' }}
            </td>
        </tr>
    </table>

    <!-- Recommendation -->
    <div class="section-title">III. RECOMMENDATION</div>
    <table>
        <tr>
            <td>{{ $record->recommendation ?? 'No recommendation provided.' }}</td>
        </tr>
    </table>

    <!-- Signature Section -->
    <br><br>
    <table>
        <tr>
            <td>(Signature over printed name)<br>Date: _____________</td>
            <td>Dentist</td>
            <td>School Nurse</td>
        </tr>
    </table>

</body>
</html>
