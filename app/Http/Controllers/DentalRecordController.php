<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\DentalRecord;
use Illuminate\Support\Facades\Auth;

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
}