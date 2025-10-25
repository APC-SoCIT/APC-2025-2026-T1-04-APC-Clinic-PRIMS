<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Medical Supplies Inventory Report</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            font-size: 11px;
            color: #333;
            margin: 25px;
        }

        h2, h4, p {
            text-align: center;
            margin: 2px 0;
        }

        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 15px;
        }

        th, td {
            border: 1px solid #444;
            padding: 4px 6px;
            text-align: center;
        }

        th {
            background-color: #e9e9e9;
            font-weight: bold;
        }

        .section-title {
            font-weight: bold;
            font-size: 13px;
            margin-top: 25px;
            text-transform: uppercase;
        }

        .footer {
            margin-top: 30px;
            font-size: 10px;
            text-align: right;
            color: #555;
        }

        .no-data {
            text-align: center;
            font-style: italic;
            color: #777;
        }
    </style>
</head>
<body>

    <!-- Header -->
    <div>
        <h2>Medical Supplies Inventory Report</h2>
        <h4>{{ strtoupper($reportType) }} — {{ ucfirst($period) }}</h4>
        <p>Generated on {{ \Carbon\Carbon::now()->format('F d, Y') }}</p>
    </div>

    <!-- Report Table -->
    <div>
        <table>
            <thead>
                <tr>
                    <th>No.</th>
                    <th>Generic Name</th>
                    <th>Brand</th>
                    <th>Category</th>
                    <th>Dosage Form</th>
                    <th>Strength</th>
                    <th>Date Supplied</th>
                    <th>Expiration Date</th>
                    <th>Quantity Received</th>
                    <th>Remaining Stock</th>
                </tr>
            </thead>
            <tbody>
                @forelse ($records as $index => $item)
                    <tr>
                        <td>{{ $index + 1 }}</td>
                        <td>{{ $item->supply_name }}</td>
                        <td>{{ $item->brand ?? 'N/A' }}</td>
                        <td>{{ $item->category }}</td>
                        <td>{{ $item->dosage_form }}</td>
                        <td>{{ $item->dosage_strength }}</td>
                        <td>{{ $item->date_supplied }}</td>
                        <td>{{ $item->expiration_date }}</td>
                        <td>{{ $item->quantity_received }}</td>
                        <td>{{ $item->remaining_stock }}</td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="10" class="no-data">No records available for this report.</td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>

    <!-- Footer -->
    <div class="footer">
        Prepared by: ______________________ &nbsp;&nbsp;&nbsp; Verified by: ______________________
    </div>

</body>
</html>
