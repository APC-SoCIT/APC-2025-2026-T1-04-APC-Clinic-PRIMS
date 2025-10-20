<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <title>Medical Supplies Inventory Report</title>
    <style>
        body { font-family: Arial, sans-serif; margin: 30px; font-size: 12px; }
        h1, h2 { text-align: center; margin: 0; padding: 0; }
        h1 { font-size: 18px; text-transform: uppercase; }
        h2 { font-size: 14px; margin-top: 5px; color: #444; }

        table { width: 100%; border-collapse: collapse; margin-top: 20px; }
        th, td { border: 1px solid #000; padding: 6px; text-align: center; }
        th { background: #f2f2f2; font-weight: bold; }
        td.num { text-align: center; }
        td.left { text-align: left; }
    </style>
</head>
<body>

    <h1>Medical Supplies Inventory Report</h1>
    <h2>{{ strtoupper($month) }} — {{ strtoupper($duration) }}</h2>

    {{-- ======================== ACTUAL STOCKS (Daily Grid) ======================== --}}
    <h2 style="margin-top: 30px;">Actual Stocks</h2>
    <table>
        <thead>
            <tr>
                <th style="width: 30%;">Particular (Medicine Name)</th>
                @for ($i = 1; $i <= 31; $i++)
                    <th style="width: 2%;">{{ $i }}</th>
                @endfor
            </tr>
        </thead>
        <tbody>
            @php
                $medicines = [
                    'Ambroxol 30mg',
                    'Amlodipine 5mg',
                    'Ascof (Lagundi)',
                    'Betahistin (Serc) 16mg',
                    'Bioflu',
                    'Carbocistiene 500mg',
                    'Cetirizine (Virlix) 10mg',
                    'Clonidine 75mcg',
                    'Decolgen (no drowse)',
                    'Dequadin',
                    'Diphenhydramine',
                    'Hyocine (Buscopan) 10mg',
                    'Hyocine (Venus)',
                    'Ibuprofen (Advil)',
                    'Ibuprofen / Paracetamol',
                    'Kremil-S',
                    'Loperamide (Diatabs)',
                    'Loratadine (Alerta) 10mg',
                    'Meclizine (Dizitab)',
                    'Mefenamic Acid 500mg',
                    'Metoclopramide (Plasil)',
                    'Omeprazole 20mg',
                    'ORS Hydrite',
                    'Paracetamol (Biogesic)',
                    'Sinecod',
                    'Sinupret forte',
                    'Tuseran forte',
                    'Ventolin neb.',
                    'Domperidone',
                    'Midol'
                ];
            @endphp

            @foreach ($medicines as $name)
                <tr>
                    <td class="left">{{ $name }}</td>
                    @for ($i = 1; $i <= 31; $i++)
                        @php
                            $receivedForDay = $receivedData[$i] ?? collect();
                            $totalReceived = $receivedForDay->filter(function ($r) use ($name) {
                                return $r->supply_name === $name;
                            })->sum('total_received');
                        @endphp
                        <td class="num">{{ $totalReceived > 0 ? $totalReceived : '' }}</td>
                    @endfor
                </tr>
            @endforeach
        </tbody>
    </table>

    {{-- ======================== GENERAL ISSUANCE (Daily Grid) ======================== --}}
    <h2 style="margin-top: 40px;">General Issuance</h2>
    <table>
        <thead>
            <tr>
                <th style="width: 30%;">Particular (Medicine Name)</th>
                @for ($i = 1; $i <= 31; $i++)
                    <th style="width: 2%;">{{ $i }}</th>
                @endfor
            </tr>
        </thead>
        <tbody>
            @foreach ($medicines as $name)
                <tr>
                    <td class="left">{{ $name }}</td>
                    @for ($i = 1; $i <= 31; $i++)
                        @php
                            $dispensedForDay = $dispensedData[$i] ?? collect();
                            $totalDispensed = $dispensedForDay->filter(function ($d) use ($name) {
                                return optional($d->inventory->supply)->name === $name;
                            })->sum('quantity_dispensed');
                        @endphp
                        <td class="num">{{ $totalDispensed > 0 ? $totalDispensed : '' }}</td>
                    @endfor
                </tr>
            @endforeach
        </tbody>
    </table>

</body>
</html>
