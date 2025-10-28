<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Appointment;
use App\Models\Inventory;
use Carbon\Carbon;

class DashboardController extends Controller
{
    public function index()
    {
        $today = Carbon::today();

        // Appointments
        $appointmentsToday = Appointment::with(['patient.user', 'doctor'])
            ->whereDate('appointment_date', $today)
            ->get();

        $totalToday = $appointmentsToday->where('status', 'approved')->count();
        $pendingRequests = Appointment::whereMonth('appointment_date', $today->month)
            ->where('status', 'pending')
            ->count();

        // Calendar events
        $calendarEvents = Appointment::with(['patient.user', 'doctor'])
            ->get()
            ->map(function ($appt) {
                return [
                    'title' => optional($appt->patient->user)->name ?? ($appt->patient->first_name.' '.$appt->patient->last_name) ?? 'N/A',
                    'start' => $appt->appointment_date,
                    'doctor' => optional($appt->doctor)->full_name ?? 'N/A',
                    'status' => $appt->status,
                ];
            });

        // Inventory counts
        $inventoryCounts = [
            'in_stock' => Inventory::where('quantity_received', '>', 10)
                ->whereDate('expiration_date', '>', $today)
                ->count(),
            'low_stock' => Inventory::whereBetween('quantity_received', [1, 10])
                ->whereDate('expiration_date', '>', $today)
                ->count(),
            'out_of_stock' => Inventory::where('quantity_received', '<=', 0)
                ->count(),
            'expired' => Inventory::whereDate('expiration_date', '<', $today)
                ->count(),
        ];

        // Inventory details for modal
        $inventoryDetails = [
            'in_stock' => Inventory::with('supply')
                ->where('quantity_received', '>', 10)
                ->whereDate('expiration_date', '>', $today)
                ->get(),
            'low_stock' => Inventory::with('supply')
                ->whereBetween('quantity_received', [1, 10])
                ->whereDate('expiration_date', '>', $today)
                ->get(),
            'out_of_stock' => Inventory::with('supply')
                ->where('quantity_received', '<=', 0)
                ->get(),
            'expired' => Inventory::with('supply')
                ->whereDate('expiration_date', '<', $today)
                ->get(),
        ];

        return view('dashboard', compact(
            'appointmentsToday',
            'totalToday',
            'pendingRequests',
            'calendarEvents',
            'inventoryCounts',
            'inventoryDetails'
        ));
    }
}
