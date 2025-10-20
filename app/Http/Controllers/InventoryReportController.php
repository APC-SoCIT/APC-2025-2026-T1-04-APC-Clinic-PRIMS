<?php

namespace App\Http\Controllers;

use App\Models\Inventory;
use App\Models\Dispensed;
use App\Models\Supply;
use Barryvdh\DomPDF\Facade\Pdf;
use Carbon\Carbon;
use Illuminate\Http\Request;

class InventoryReportController extends Controller
{
    public function generate(Request $request)
    {
        $validated = $request->validate([
            'duration' => 'required|string',
            'sections' => 'required|array',
            // optional month/year (format YYYY-MM or separate month/year)
            'month' => 'nullable|string',
        ]);

        // Determine target month/year (allow override via request->month 'YYYY-MM')
        if ($request->filled('month')) {
            try {
                $target = Carbon::createFromFormat('Y-m', $request->month)->startOfMonth();
            } catch (\Exception $e) {
                $target = Carbon::now();
            }
        } else {
            $target = Carbon::now();
        }

        $monthName = $target->format('F Y');
        $duration = ucfirst($validated['duration']);
        $sections = $validated['sections'];

        // Use 30 days as requested
        $daysCount = 30;

        // fetch distinct supplies used in inventory (ordered alphabetically)
        $supplies = Supply::orderBy('name')->get();

        // prepare receivedData[day] = collection of (supply_name, total_received)
        $receivedData = [];
        for ($d = 1; $d <= $daysCount; $d++) {
            $date = $target->copy()->day($d)->toDateString();
            $dayRecords = Inventory::selectRaw('supply_id, SUM(quantity_received) as total_received')
                ->whereDate('date_supplied', $date)
                ->groupBy('supply_id')
                ->get()
                ->map(function ($r) {
                    return (object)[
                        'supply_id' => $r->supply_id,
                        'total_received' => (int) $r->total_received,
                    ];
                });

            // attach supply name for easier lookup in view
            $dayRecords = $dayRecords->map(function ($r) {
                $supply = Supply::find($r->supply_id);
                return (object)[
                    'supply_name' => $supply->name ?? 'Unknown',
                    'supply_id' => $r->supply_id,
                    'total_received' => $r->total_received,
                ];
            });

            $receivedData[$d] = $dayRecords;
        }

        // prepare dispensedData[day] = collection of (supply_name, total_dispensed)
        $dispensedData = [];
        for ($d = 1; $d <= $daysCount; $d++) {
            $date = $target->copy()->day($d)->toDateString();

            $dayDispensed = Dispensed::whereDate('date_dispensed', $date)
                ->with('inventory.supply')
                ->get()
                ->groupBy(function ($item) {
                    return optional($item->inventory->supply)->name ?? 'Unknown';
                })
                ->map(function ($group, $supplyName) {
                    return (object)[
                        'supply_name' => $supplyName,
                        'total_dispensed' => $group->sum('quantity_dispensed'),
                    ];
                })->values();

            $dispensedData[$d] = $dayDispensed;
        }

        $pdf = Pdf::loadView('pdf.medical_inventory_report', compact(
            'supplies', 'receivedData', 'dispensedData', 'monthName', 'duration', 'sections', 'daysCount'
        ))->setPaper('A4', 'landscape');

        return $pdf->stream("Inventory_Report_{$monthName}.pdf");
    }
}