<?php

namespace App\Http\Controllers;

use App\Models\Inventory;
use App\Models\Dispensed;
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
        ]);

        $month = Carbon::now()->format('F Y');
        $duration = ucfirst($validated['duration']);
        $sections = $validated['sections'];

        // Fetch inventory with supply info
        $inventory = Inventory::with('supply')->get();

        // Fetch dispensed data for the current month (for issuance section)
        $dispensed = Dispensed::selectRaw('inventory_id, DAY(date_dispensed) as day, SUM(quantity_dispensed) as total')
            ->whereMonth('date_dispensed', Carbon::now()->month)
            ->whereYear('date_dispensed', Carbon::now()->year)
            ->groupBy('inventory_id', 'day')
            ->get()
            ->groupBy('inventory_id');

        $pdf = Pdf::loadView('pdf.medical_inventory_report', compact(
            'inventory', 'dispensed', 'month', 'duration', 'sections'
        ))->setPaper('A4', 'landscape');

        // Preview PDF in browser
        return $pdf->stream("Inventory_Report_{$month}.pdf");
    }
}
