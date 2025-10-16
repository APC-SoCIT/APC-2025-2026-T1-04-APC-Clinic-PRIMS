<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\DentalRecord;

class DentalRecordController extends Controller
{
    /**
     * View a single dental record.
     */
    public function view($id)
    {
        $record = DentalRecord::with('patient')->findOrFail($id);
        return view('view-dental-record', compact('record'));
    }
}