<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\DentalRecord;
use Illuminate\Support\Facades\Auth;
use Barryvdh\DomPDF\Facade\Pdf;

class DentalRecordController extends Controller
{
    /**
     * View a single dental record.
     */
    public function view($id)
    {
        $user = Auth::user();
        if (!$user || !$user->hasRole('clinic staff')) {
            abort(403);
        }
        
        $record = DentalRecord::with('patient')->findOrFail($id);
        return view('view-dental-record', compact('record'));
    }

    /**
     * Generate and print a dental record as PDF.
     */
    public function printPDF($id)
    {
        $user = Auth::user();
        if (!$user || !$user->hasRole('clinic staff')) {
            abort(403);
        }

        $record = DentalRecord::with('patient')->findOrFail($id);

        $pdf = Pdf::loadView('pdf.dental-record-pdf', compact('record'))
                  ->setPaper('A4', 'portrait');

        return $pdf->stream('Dental_Record_' . $record->patient->last_name . '.pdf');
    }
}
