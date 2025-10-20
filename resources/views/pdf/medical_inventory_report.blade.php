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
    <h2>{{ strtoupper($monthName ?? '') }}</h2>

    {{-- ===================================================== --}}
    {{-- 🟩 ACTUAL STOCKS --}}
    {{-- ===================================================== --}}
    @if(in_array('Actual Stocks', $sections))
        <h2 style="margin-top: 18px;">Actual Stocks (Received)</h2>

        @if($isAnnual)
            {{-- Annual Layout: Jan–Dec --}}
            <table>
                <thead>
                    <tr>
                        <th style="width: 25%;">Particular (Medicine / Supply)</th>
                        @foreach ([
                            'Jan','Feb','Mar','Apr','May','Jun','Jul','Aug','Sep','Oct','Nov','Dec'
                        ] as $month)
                            <th>{{ $month }}</th>
                        @endforeach
                    </tr>
                </thead>
                <tbody>
                    @foreach ($supplies as $supply)
                        <tr>
                            <td class="left">{{ $supply->name }}</td>
                            @for ($m = 1; $m <= 12; $m++)
                                @php
                                    $monthData = $receivedData[$supply->id] ?? collect();
                                    $found = $monthData->firstWhere('month', $m);
                                    $total = $found->total_received ?? 0;
                                @endphp
                                <td class="num">{{ $total > 0 ? $total : '' }}</td>
                            @endfor
                        </tr>
                    @endforeach
                </tbody>
            </table>
        @else
            {{-- Monthly Layout: 1–31 --}}
            <table>
                <thead>
                    <tr>
                        <th style="width: 30%;">Particular (Medicine / Supply)</th>
                        @for ($i = 1; $i <= ($daysCount ?? 30); $i++)
                            <th>{{ $i }}</th>
                        @endfor
                    </tr>
                </thead>
                <tbody>
                    @foreach ($supplies as $supply)
                        <tr>
                            <td class="left">{{ $supply->name }}</td>
                            @for ($day = 1; $day <= ($daysCount ?? 30); $day++)
                                @php
                                    $receivedForDay = collect($receivedData[$day] ?? []);
                                    $found = $receivedForDay->firstWhere('supply_name', $supply->name);
                                    $total = $found->total_received ?? 0;
                                @endphp
                                <td class="num">{{ $total > 0 ? $total : '' }}</td>
                            @endfor
                        </tr>
                    @endforeach
                </tbody>
            </table>
        @endif
    @endif


    {{-- ===================================================== --}}
    {{-- 🟥 GENERAL ISSUANCE --}}
    {{-- ===================================================== --}}
    @if(in_array('General Issuance', $sections))
        <h2 style="margin-top: 24px;">General Issuance (Dispensed)</h2>

        @if($isAnnual)
            {{-- Annual Layout: Jan–Dec --}}
            <table>
                <thead>
                    <tr>
                        <th style="width: 25%;">Particular (Medicine / Supply)</th>
                        @foreach ([
                            'Jan','Feb','Mar','Apr','May','Jun','Jul','Aug','Sep','Oct','Nov','Dec'
                        ] as $month)
                            <th>{{ $month }}</th>
                        @endforeach
                    </tr>
                </thead>
                <tbody>
                    @foreach ($supplies as $supply)
                        <tr>
                            <td class="left">{{ $supply->name }}</td>
                            @for ($m = 1; $m <= 12; $m++)
                                @php
                                    $monthData = $dispensedData[$supply->id] ?? collect();
                                    $monthValues = collect($monthData)->where('month', $m);
                                    $total = $monthValues->sum('total_dispensed');
                                @endphp
                                <td class="num">{{ $total > 0 ? $total : '' }}</td>
                            @endfor
                        </tr>
                    @endforeach
                </tbody>
            </table>
        @else
            {{-- Monthly Layout: 1–31 --}}
            <table>
                <thead>
                    <tr>
                        <th style="width: 30%;">Particular (Medicine / Supply)</th>
                        @for ($i = 1; $i <= ($daysCount ?? 30); $i++)
                            <th>{{ $i }}</th>
                        @endfor
                    </tr>
                </thead>
                <tbody>
                    @foreach ($supplies as $supply)
                        <tr>
                            <td class="left">{{ $supply->name }}</td>
                            @for ($day = 1; $day <= ($daysCount ?? 30); $day++)
                                @php
                                    $dispensedForDay = collect($dispensedData[$day] ?? []);
                                    $found = $dispensedForDay->firstWhere('supply_name', $supply->name);
                                    $total = $found->total_dispensed ?? 0;
                                @endphp
                                <td class="num">{{ $total > 0 ? $total : '' }}</td>
                            @endfor
                        </tr>
                    @endforeach
                </tbody>
            </table>
        @endif
    @endif


    {{-- ===================================================== --}}
    {{-- 🚚 DELIVERIES --}}
    {{-- ===================================================== --}}
    @if(in_array('Deliveries', $sections))
        <h2 style="margin-top: 24px;">Deliveries / Added</h2>
        <table>
            <thead>
                <tr>
                    <th>Generic Name</th>
                    <th>Brand</th>
                    <th>Category</th>
                    <th>Dosage Form</th>
                    <th>Strength</th>
                    <th>Quantity Received</th>
                    <th>Date Supplied</th>
                    <th>Expiration Date</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($deliveries as $item)
                    <tr>
                        <td class="left">{{ $item->supply_name ?? '—' }}</td>
                        <td>{{ $item->brand ?? '—' }}</td>
                        <td>{{ $item->category ?? '—' }}</td>
                        <td>{{ $item->dosage_form ?? '—' }}</td>
                        <td>{{ $item->dosage_strength ?? '—' }}</td>
                        <td class="num">{{ $item->quantity_received ?? 0 }}</td>
                        <td>{{ $item->date_supplied ? \Carbon\Carbon::parse($item->date_supplied)->format('M d, Y') : '—' }}</td>
                        <td>{{ $item->expiration_date ? \Carbon\Carbon::parse($item->expiration_date)->format('M d, Y') : '—' }}</td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    @endif

</body>
</html>
