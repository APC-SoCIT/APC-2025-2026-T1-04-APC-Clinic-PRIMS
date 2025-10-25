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
            'duration' => 'required|string', // monthly or annually
            'sections' => 'required|array',
            'month' => 'nullable|string',   // for monthly
            'year' => 'nullable|integer',   // for annual
        ]);

        $duration = strtolower($validated['duration']);
        $sections = $validated['sections'];

        // =====================================================
        // 📅 DETERMINE TARGET RANGE
        // =====================================================
        if ($duration === 'annually') {
            $year = $request->year ?? now()->year;
            $targetStart = Carbon::createFromDate($year, 1, 1)->startOfDay();
            $targetEnd   = Carbon::createFromDate($year, 12, 31)->endOfDay();
            $monthName = "YEAR {$year} - ANNUAL";
        } else {
            // Monthly
            if ($request->filled('month')) {
                try {
                    $targetStart = Carbon::createFromFormat('Y-m', $request->month)->startOfMonth();
                    $targetEnd = (clone $targetStart)->endOfMonth();
                } catch (\Exception $e) {
                    $targetStart = now()->startOfMonth();
                    $targetEnd = now()->endOfMonth();
                }
            } else {
                $targetStart = now()->startOfMonth();
                $targetEnd = now()->endOfMonth();
            }
            $monthName = $targetStart->format('F Y') . ' - MONTHLY';
        }

        // =====================================================
        // 📦 STATIC SUPPLY LIST
        // =====================================================
        $supplies = Supply::orderBy('name')->get();

        // =====================================================
        // 🟩 ACTUAL STOCKS (RECEIVED)
        // =====================================================
        if ($duration === 'annually') {
            // Group per supply per month
            $receivedData = Inventory::selectRaw('supply_id, MONTH(date_supplied) as month, SUM(quantity_received) as total_received')
                ->whereBetween('date_supplied', [$targetStart, $targetEnd])
                ->groupBy('supply_id', 'month')
                ->get()
                ->groupBy('supply_id');
        } else {
            // Group by day (for monthly)
            $daysCount = $targetStart->daysInMonth;
            $receivedData = [];
            for ($d = 1; $d <= $daysCount; $d++) {
                $date = $targetStart->copy()->day($d)->toDateString();
                $dayRecords = Inventory::selectRaw('supply_id, SUM(quantity_received) as total_received')
                    ->whereDate('date_supplied', $date)
                    ->groupBy('supply_id')
                    ->get()
                    ->map(function ($r) {
                        $supply = Supply::find($r->supply_id);
                        return (object)[
                            'supply_name' => $supply->name ?? 'Unknown',
                            'total_received' => (int) $r->total_received,
                        ];
                    });
                $receivedData[$d] = $dayRecords;
            }
        }

        // =====================================================
        // 🟥 GENERAL ISSUANCE (DISPENSED)
        // =====================================================
        if ($duration === 'annually') {
            $dispensedData = Dispensed::selectRaw('inventory_id, MONTH(date_dispensed) as month, SUM(quantity_dispensed) as total_dispensed')
                ->whereBetween('date_dispensed', [$targetStart, $targetEnd])
                ->groupBy('inventory_id', 'month')
                ->get()
                ->groupBy(function ($item) {
                    $inv = \App\Models\Inventory::with('supply')->find($item->inventory_id);
                    return optional($inv->supply)->id ?? null;
                });
        } else {
            $daysCount = $targetStart->daysInMonth;
            $dispensedData = [];
            for ($d = 1; $d <= $daysCount; $d++) {
                $date = $targetStart->copy()->day($d)->toDateString();
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
        }

        // =====================================================
        // 🚚 DELIVERIES
        // =====================================================
        $deliveriesQuery = Inventory::with('supply')->orderBy('date_supplied', 'asc');
        $deliveriesQuery->whereBetween('date_supplied', [$targetStart, $targetEnd]);

        $deliveries = $deliveriesQuery->get()->map(function ($item) {
            $supply = $item->supply;
            return (object)[
                'supply_name'      => $supply->name ?? 'Unknown',
                'brand'            => $supply->brand ?? '—',
                'category'         => $supply->category ?? '—',
                'dosage_form'      => $supply->dosage_form ?? '—',
                'dosage_strength'  => $supply->dosage_strength ?? '—',
                'quantity_received'=> $item->quantity_received,
                'date_supplied'    => $item->date_supplied,
                'expiration_date'  => $item->expiration_date,
            ];
        });

        // =====================================================
        // 🧾 GENERATE PDF
        // =====================================================
        $pdf = Pdf::loadView('pdf.medical_inventory_report', [
            'supplies'       => $supplies,
            'receivedData'   => $receivedData,
            'dispensedData'  => $dispensedData,
            'deliveries'     => $deliveries,
            'monthName'      => $monthName,
            'duration'       => ucfirst($duration),
            'sections'       => $sections,
            'isAnnual'       => $duration === 'annually',
            'daysCount'      => $duration === 'annually' ? 12 : $targetStart->daysInMonth,
        ])->setPaper('A4', 'landscape');

        $safeName = str_replace([' ', ':'], '_', $monthName);
        return $pdf->stream("Inventory_Report_{$safeName}.pdf");
    }
}
