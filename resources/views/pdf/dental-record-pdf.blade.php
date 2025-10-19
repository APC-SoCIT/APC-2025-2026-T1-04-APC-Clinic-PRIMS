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
    
        .teeth-table {
            width: 100%;
            border-collapse: collapse;
            text-align: center;
            font-size: 12px;
        }
        .teeth-table td {
            width: 15px;
            height: 25px;
            border: 1px solid #000;
        }
        .teeth-gap {
            width: 30px; 
            border: none !important;
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

    <!-- I. Dental Examination -->
    <div class="section-title">I. DENTAL EXAMINATION</div>
    <table>
        <tr>
            <th>Oral Hygiene</th>
            <td>{{ $record->oral_hygiene ?? 'N/A' }}</td>
            <th>Gingival Color</th>
            <td>{{ $record->gingival_color ?? 'N/A' }}</td>
        </tr>
    </table>

    <!-- II. Procedures -->
    <div class="section-title">II. PROCEDURES</div>
    <table>
        <tr>
            <td colspan="3" style="text-align: center; font-weight: bold;">
                @if ($record->prophylaxis)
                    Oral Prophylaxis
                @else
                    None
                @endif
            </td>
        </tr>
    </table>

    <!-- III. Selected Tooth Numbers -->
    <div class="section-title">III. SELECTED TOOTH NUMBERS</div>

    <!-- Upper Teeth -->
    <p><strong>Upper Teeth</strong></p>
    <table class="teeth-table">
        <tr>
            @foreach (range(8, 1) as $num)
                <td>{{ $num }}</td>
            @endforeach
            <td class="teeth-gap"></td> <!-- Center gap -->
            @foreach (range(1, 8) as $num)
                <td>{{ $num }}</td>
            @endforeach
        </tr>
        <tr>
            @foreach (range(0, 7) as $index)
                <td>{{ $record->teeth['upper'][$index] ?? '' }}</td>
            @endforeach
            <td class="teeth-gap"></td>
            @foreach (range(8, 15) as $index)
                <td>{{ $record->teeth['upper'][$index] ?? '' }}</td>
            @endforeach
        </tr>
    </table>
    <!-- Gap between upper and lower -->
    <div style="height: 20px;"></div>

    <!-- Lower Teeth -->
    <p><strong>Lower Teeth</strong></p>
    <table class="teeth-table">
        <tr>
            @foreach (range(8, 1) as $num)
                <td>{{ $num }}</td>
            @endforeach
            <td class="teeth-gap"></td>
            @foreach (range(1, 8) as $num)
                <td>{{ $num }}</td>
            @endforeach
        </tr>
        <tr>
            @foreach (range(0, 7) as $index)
                <td>{{ $record->teeth['lower'][$index] ?? '' }}</td>
            @endforeach
            <td class="teeth-gap"></td>
            @foreach (range(8, 15) as $index)
                <td>{{ $record->teeth['lower'][$index] ?? '' }}</td>
            @endforeach
        </tr>
    </table>

    <!-- Legend for Tooth Conditions -->
    <p style="font-size: 11px; line-height: 1.5; margin-left: 10px; text-align: center;;">
        <br></br>
        <strong>C</strong> – Caries,&nbsp;
        <strong>M</strong> – Missing,&nbsp;
        <strong>E</strong> – Extraction,<br>
        <strong>LC</strong> – Lost Crown,&nbsp;
        <strong>CR</strong> – Crown,&nbsp;
        <strong>UE</strong> – Unerupted
        <br></br>
    </p>

    <!-- IV. Recommendation -->
    <br></br>
    <div class="section-title">IV. RECOMMENDATION</div>
    <table>
        <tr>
            <td>{{ $record->recommendation ?? 'No recommendation provided.' }}</td>
        </tr>
    </table>

    <!-- Authorization -->
    <br><br>
    <p>
    I hereby authorize this clinic and its officially designated examining physician to furnish information that the school may need pertaining to my health status and other pertinent medical findings and to hereby release them from all legal responsibility.
    </p>

    <!-- Signature Section -->
    <table>
        <tr>
            <td>(Signature over printed name)<br>Date: _____________</td>
            <td>Dentist</td>
            <td>School Nurse</td>
        </tr>
    </table>

</body>
</html>
