<?php

namespace App\Http\Controllers;

use App\Models\Appointment;
use App\Models\Dispensed;
use App\Models\MedicalRecord;
use App\Models\Diagnosis;
use App\Models\Feedback;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB; // <- used for raw queries
use Barryvdh\DomPDF\Facade\Pdf;
use Carbon\Carbon;
use Illuminate\Support\Facades\Http;

class StaffSummaryReportController extends Controller
{
    public function index(Request $request)
    {
        $user = Auth::user();
        if (!$user || !$user->hasRole('clinic staff')) {
            abort(403);
        }

        $month = $request->input('month', Carbon::now()->month);
        $year  = $request->input('year',  Carbon::now()->year);

        // Appointment Summary
        $attendedCount = Appointment::where('status', 'completed')
            ->whereMonth('appointment_date', $month)
            ->whereYear('appointment_date', $year)
            ->count();

        $cancelledCount = Appointment::where('status', 'cancelled')
            ->whereMonth('appointment_date', $month)
            ->whereYear('appointment_date', $year)
            ->count();

        $totalPatients = MedicalRecord::join('patients', 'medical_records.patient_id', '=', 'patients.id')
            ->whereMonth('medical_records.created_at', $month)
            ->whereYear('medical_records.created_at', $year)
            ->whereNull('medical_records.archived_at')
            ->distinct('patients.apc_id_number')
            ->count('patients.apc_id_number');

        // Most Prescribed Medications
        $medications = Dispensed::select('inventory_id', DB::raw('SUM(quantity_dispensed) as total_dispensed'))
            ->whereMonth('date_dispensed', $month)
            ->whereYear('date_dispensed', $year)
            ->groupBy('inventory_id')
            ->orderByDesc('total_dispensed')
            ->take(5)
            ->with(['inventory.supply'])
            ->get()
            ->map(function ($dispensed) {
                return [
                    'name' => optional($dispensed->inventory->supply)->name ?? 'Unknown',
                    'quantity_dispensed' => $dispensed->total_dispensed,
                ];
            });

        // Common Diagnoses
        $commonDiagnoses = Diagnosis::select('diagnosis', DB::raw('COUNT(*) as count'))
            ->whereMonth('created_at', $month)
            ->whereYear('created_at', $year)
            ->groupBy('diagnosis')
            ->orderByDesc('count')
            ->take(5)
            ->get();

        // Patient Demographics by Age Group
        $ageGroups = [
            '15-18' => 0,
            '19-25' => 0,
            '26-35' => 0,
            '36-50' => 0,
            '51+'   => 0,
        ];

        // Fetch patients linked to medical records within the month/year
        $patients = MedicalRecord::whereMonth('created_at', $month)
            ->whereYear('created_at', $year)
            ->with('patient')
            ->get()
            ->pluck('patient') // get the patient model
            ->filter(); // remove nulls just in case

        foreach ($patients as $patient) {
            if ($patient && $patient->date_of_birth) {
                $age = Carbon::parse($patient->date_of_birth)->age;

                if ($age >= 15 && $age <= 18) $ageGroups['15-18']++;
                elseif ($age >= 19 && $age <= 25) $ageGroups['19-25']++;
                elseif ($age >= 26 && $age <= 35) $ageGroups['26-35']++;
                elseif ($age >= 36 && $age <= 50) $ageGroups['36-50']++;
                elseif ($age >= 51) $ageGroups['51+']++;
            }
        }

        // Format for Chart.js
        $chartAgeGroups = collect($ageGroups)->map(fn($count, $label) => [
            'label' => $label,
            'count' => $count,
        ])->values();

        // ------------------------------------------------------
        // Feedback / Satisfaction section (EXCLUDE type = 'booking')
        // ------------------------------------------------------

        // Base builder for feedback excluding booking and scoped to month/year
        $feedbackBase = Feedback::query()
            ->where('type', '!=', 'booking')
            ->when($month, fn($q) => $q->whereMonth('created_at', $month))
            ->when($year, fn($q) => $q->whereYear('created_at', $year));

        // Total feedback rows (excluding booking)
        $totalFeedbackAll = (clone $feedbackBase)->count();

        // Rating-specific stats (only rows that actually have a rating)
        $ratingQuery = (clone $feedbackBase)->whereNotNull('rating');

        $ratingCount = $ratingQuery->count();
        $sumRatings  = $ratingQuery->sum('rating');

        // Average rating (1-5). If no rating entries exist, fallback to 0.
        $averageRating = $ratingCount > 0 ? round(($sumRatings / $ratingCount), 1) : 0;

        // Rating distribution for chart (ensure we return a plain array, keys 1..5)
        $rawDistribution = $ratingQuery
            ->select('rating', DB::raw('COUNT(*) as count'))
            ->groupBy('rating')
            ->pluck('count', 'rating')
            ->toArray();

        // Guarantee keys 1..5 exist (0 if missing) - this makes blade JS safe
        $ratingDistribution = [];
        for ($i = 1; $i <= 5; $i++) {
            $ratingDistribution[$i] = isset($rawDistribution[$i]) ? (int)$rawDistribution[$i] : 0;
        }

        // Recent feedback comments (exclude booking) — includes rating if present
        $recentFeedback = (clone $feedbackBase)
            ->latest()
            ->take(5)
            ->get();

        // If you also want emoji counts for any legacy usage, compute them excluding booking:
        $emojiCounts = (clone $feedbackBase)
            ->selectRaw("
                SUM(CASE WHEN emoji = 'happy' THEN 1 ELSE 0 END) as happy,
                SUM(CASE WHEN emoji = 'flat'  THEN 1 ELSE 0 END) as flat,
                SUM(CASE WHEN emoji = 'sad'   THEN 1 ELSE 0 END) as sad,
                COUNT(*) as total
            ")
            ->first();

        $happy = $emojiCounts->happy ?? 0;
        $flat  = $emojiCounts->flat ?? 0;
        $sad   = $emojiCounts->sad ?? 0;
        $totalEmojiRows = $emojiCounts->total ?? 0;

        // Convert rating avg (1-5) to a 0-100 percentage for any meter display if needed
        $satisfactionScore = $averageRating > 0 ? round(($averageRating / 5) * 100, 1) : 0;

        // ------------------------------------------------------
        // Incoming appointments (unchanged)
        // ------------------------------------------------------
        $incomingAppointments = Appointment::with(['patient', 'doctor'])
            ->where('status', 'approved')
            ->whereDate('appointment_date', '>=', Carbon::today())
            ->orderBy('appointment_date', 'asc')
            ->take(5)
            ->get();

        // ------------------------------------------------------
        // AI Insights (using Gemini)
        // ------------------------------------------------------
        try {
            // Convert collections to plain arrays
            $topReasons = $commonDiagnoses->pluck('diagnosis')->toArray();
            $topMedications = $medications->pluck('name')->toArray();
            $feedbackTexts = $recentFeedback->pluck('message')->toArray(); // adjust if your column is named differently

            // Create prompt for all 3 sections
            $prompt = "
            You are a helpful assistant creating an easy-to-read monthly clinic report.
            Write in a friendly and professional tone that a school nurse can easily understand.
            Highlight key phrases in bold HTML tags (use <b>, don't use **), and return plain HTML text only for those highlighted points. You are only allowed to return <b> tags for emphasis, don't use paragraph or heading tags.

            Use this exact format:

            FEEDBACK SUMMARY:
            Give a short summary (2-3 sentences) of what students or patients said in their feedback. 
            Point out common comments and simple suggestions for how the clinic can improve.

            ADMIN INSIGHTS:
            Give a quick overview (2-3 sentences) using the data below. 
            Mention the total patients, top reasons for visits, and top medicines. 
            Share what went well this month and what could be improved or continued.

            PREDICTIVE HINT:
            Based on the data and time of year, give a short prediction or reminder (2-3 sentences) for what might happen next month. 
            For example, expected health concerns or things to prepare for.

            Data:
            - Total patients: {$totalPatients}
            - Attended: {$attendedCount}
            - Cancelled: {$cancelledCount}
            - Top reasons for visit: " . implode(', ', $topReasons) . "
            - Top prescribed medications: " . implode(', ', $topMedications) . "
            - Average satisfaction rating: {$averageRating} / 5
            - Feedback examples: " . implode(' | ', $feedbackTexts) . "
            ";


            $response = Http::post("https://generativelanguage.googleapis.com/v1/models/gemini-2.5-flash:generateContent?key=" . env('GEMINI_API_KEY'), [
                'contents' => [[
                    'parts' => [[ 'text' => $prompt ]]
                ]]
            ]);

            \Log::info('Gemini raw response', ['body' => $response->json()]);

            $body = $response->json();
            $aiText = $body['candidates'][0]['content']['parts'][0]['text'] ?? null;

            if (!$aiText) {
                \Log::error('Gemini response error', ['body' => $body]);
                $feedbackSummary = $adminInsights = $predictiveHint = 'AI could not generate a response.';
            }


            // Split the AI response into sections
            $feedbackSummary = $this->extractSection($aiText, 'FEEDBACK SUMMARY', 'ADMIN INSIGHTS');
            $adminInsights = $this->extractSection($aiText, 'ADMIN INSIGHTS', 'PREDICTIVE HINT');
            $predictiveHint = $this->extractSection($aiText, 'PREDICTIVE HINT');
        } catch (\Exception $e) {
            $feedbackSummary = 'AI summary unavailable.';
            $adminInsights = 'AI insights unavailable.';
            $predictiveHint = 'Prediction unavailable.';
        }

        // ------------------------------------------------------
        // Return view with all expected variables
        // ------------------------------------------------------
        return view('staff-summary-report', [
            'attendedCount'        => $attendedCount,
            'cancelledCount'       => $cancelledCount,
            'totalPatients'        => $totalPatients,
            'medications'          => $medications,
            'diagnoses'            => $commonDiagnoses,
            'ageGroups'            => $chartAgeGroups,
            'selectedMonth'        => $month,
            'selectedYear'         => $year,
            'incomingAppointments' => $incomingAppointments,

            // Feedback-related (note: booking type excluded)
            'averageRating'        => $averageRating,        // numeric 0-5 (1 decimal)
            'totalFeedback'        => $ratingCount,          // number of rating entries (preferred for stars)
            'ratingDistribution'   => $ratingDistribution,   // array keys 1..5 => counts
            'recentFeedback'       => $recentFeedback,       // collection of recent feedback rows (no booking)
            'emojiCounts'          => [
                'happy' => $happy,
                'flat'  => $flat,
                'sad'   => $sad,
                'total' => $totalEmojiRows,
            ],
            'satisfactionScore'    => $satisfactionScore,    // 0-100 % (derived from rating avg)

            // AI-generated insights
            'feedbackSummary'      => $feedbackSummary,
            'adminInsights'        => $adminInsights,
            'predictiveHint'       => $predictiveHint,
        ]);
    }

    private function extractSection($text, $startLabel, $endLabel = null)
    {
        $pattern = $endLabel
            ? "/{$startLabel}\s*:?\s*(.*?)(?={$endLabel}\s*:|$)/is"
            : "/{$startLabel}\s*:?\s*(.*)/is";

        if (preg_match($pattern, $text, $matches)) {
            return trim($matches[1]);
        }

        return 'No data generated.';
    }

    public function generateAccomplishmentReport(Request $request)
    {
        $type = $request->input('type', 'monthly');
        $year = $request->input('year', Carbon::now()->year);
        $month = $type === 'monthly' ? $request->input('month') : null;
        if ($type === 'monthly' && !$month) $month = Carbon::now()->month;

        $attendedCount = Appointment::when($month, fn($q) => $q->whereMonth('appointment_date', $month))
            ->whereYear('appointment_date', $year)
            ->where('status', 'completed')
            ->count();

        $cancelledCount = Appointment::when($month, fn($q) => $q->whereMonth('appointment_date', $month))
            ->whereYear('appointment_date', $year)
            ->where('status', 'cancelled')
            ->count();

        $totalPatients = MedicalRecord::join('patients', 'medical_records.patient_id', '=', 'patients.id')
            ->when($month, fn($q) => $q->whereMonth('medical_records.created_at', $month))
            ->whereYear('medical_records.created_at', $year)
            ->whereNull('medical_records.archived_at')
            ->distinct('patients.apc_id_number')
            ->count('patients.apc_id_number');

        $allDiagnoses = [
            'Cardiology' => ['Hypertension', 'BP Monitoring', 'Bradycardia', 'Hypotension', 'Angina'],
            'Pulmonology' => ['URTI', 'Pneumonia', 'PTB', 'Bronchitis', 'Lung Pathology'],
            'Gastroenterology' => ['Acute Gastroenteritis', 'GERD', 'Hemorrhoids', 'Anorexia'],
            'Neurology' => ['Tension Headache', 'Migraine', 'Vertigo', 'Insomnia'],
            'Endocrinology' => ['Diabetes Mellitus', 'Dyslipidemia'],
            'Nephrology' => ['Urinary Tract Infection'],
        ];

        $existingDiagnoses = Diagnosis::when($month, fn($q) => $q->whereMonth('created_at', $month))
            ->whereYear('created_at', $year)
            ->select('diagnosis', DB::raw('COUNT(*) as count'))
            ->groupBy('diagnosis')
            ->pluck('count', 'diagnosis')
            ->toArray();

        $categorizedDiagnoses = [];
        foreach ($allDiagnoses as $category => $diagList) {
            foreach ($diagList as $diagName) {
                $categorizedDiagnoses[$category][] = [
                    'name' => $diagName,
                    'count' => $existingDiagnoses[$diagName] ?? 0,
                ];
            }
        }

        $staffName = Auth::user()->name;

        $pdf = Pdf::loadView('pdf.report', compact(
            'month',
            'year',
            'type',
            'totalPatients',
            'attendedCount',
            'cancelledCount',
            'staffName',
            'categorizedDiagnoses'
        ));

        return $pdf->stream('accomplishment-report.pdf');
    }


}
