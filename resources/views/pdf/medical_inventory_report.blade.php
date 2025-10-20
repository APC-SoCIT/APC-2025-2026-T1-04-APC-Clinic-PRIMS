{{-- filepath: resources/views/pdf/medical_inventory_report.blade.php --}}
<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <title>Medical Supplies Inventory Report</title>
    <style>
        body { font-family: Arial, sans-serif; margin: 30px; font-size: 11px; }
        h1, h2 { text-align: center; margin: 0; padding: 0; }
        h1 { font-size: 16px; text-transform: uppercase; }
        h2 { font-size: 12px; margin-top: 4px; color: #444; }

        table { width: 100%; border-collapse: collapse; margin-top: 18px; font-size: 10px; }
        th, td { border: 1px solid #000; padding: 4px; text-align: center; vertical-align: middle; }
        th { background: #f2f2f2; font-weight: bold; }
        td.num { text-align: center; }
        td.left { text-align: left; }
    </style>
</head>
<body>

    <h1>Medical Supplies Inventory Report</h1>
    <h2>{{ strtoupper($monthName ?? '') }} — {{ strtoupper($duration ?? '') }}</h2>

    {{-- Actual Stocks (Received) --}}
    <h2 style="margin-top: 18px;">Actual Stocks (Received)</h2>
    <table>
        <thead>
            <tr>
                <th style="width: 30%;">Particular (Medicine / Supply)</th>
                @for ($i = 1; $i <= ($daysCount ?? 30); $i++)
                    <th style="width: {{ 70 / ($daysCount ?? 30) }}%;">{{ $i }}</th>
                @endfor
            </tr>
        </thead>
        <tbody>
            @foreach ($supplies as $supply)
                <tr>
                    <td class="left">{{ $supply->name }}</td>
                    @for ($day = 1; $day <= ($daysCount ?? 30); $day++)
                        @php
                            $receivedForDay = $receivedData[$day] ?? collect();
                            $found = $receivedForDay->firstWhere('supply_name', $supply->name);
                            $totalReceived = $found->total_received ?? 0;
                        @endphp
                        <td class="num">{{ $totalReceived > 0 ? $totalReceived : '' }}</td>
                    @endfor
                </tr>
            @endforeach
        </tbody>
    </table>

    {{-- General Issuance (Dispensed) --}}
    <h2 style="margin-top: 24px;">General Issuance (Dispensed)</h2>
    <table>
        <thead>
            <tr>
                <th style="width: 30%;">Particular (Medicine / Supply)</th>
                @for ($i = 1; $i <= ($daysCount ?? 30); $i++)
                    <th style="width: {{ 70 / ($daysCount ?? 30) }}%;">{{ $i }}</th>
                @endfor
            </tr>
        </thead>
        <tbody>
            @foreach ($supplies as $supply)
                <tr>
                    <td class="left">{{ $supply->name }}</td>
                    @for ($day = 1; $day <= ($daysCount ?? 30); $day++)
                        @php
                            $dispensedForDay = $dispensedData[$day] ?? collect();
                            $foundD = $dispensedForDay->firstWhere('supply_name', $supply->name);
                            $totalDispensed = $foundD->total_dispensed ?? 0;
                        @endphp
                        <td class="num">{{ $totalDispensed > 0 ? $totalDispensed : '' }}</td>
                    @endfor
                </tr>
            @endforeach
        </tbody>
    </table>

</body>
</html>