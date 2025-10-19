<?php

namespace App\Livewire;

use Livewire\Component;
use App\Models\Appointment;
use Illuminate\Support\Facades\Auth;
use Carbon\Carbon;
use App\Models\DoctorSchedule;
use App\Models\ClinicStaff;
use App\Models\Feedback;
use App\Models\MedicalRecord;
use App\Models\DentalRecord;
use App\Models\User;
use Illuminate\Support\Facades\Mail;
use App\Mail\RecordRequestMail;
use Barryvdh\DomPDF\Facade\Pdf;

class AppointmentHistory extends Component
{
    public $patient;
    public $appointmentHistory;
    public $hasUpcomingAppointment;
    public $showingWalkIns = false;
    public $walkInMedicalRecords;
    public $walkInDentalRecords;
    public $expandedWalkIn = null;
    public $showCancelModal = false;
    public $cancelAppointmentId;
    public $cancelReason;
    public $showCancelSuccessModal = false;
    public $expandedRow = null;
    public $showFeedbackModal = false;
    public $feedbackAppointmentId;
    public $feedbackText;
    public $rating = 0;
    public $anonymous = false;
    public $consultationFeedback;
    public $appointmentId;

    public function mount()
    {
        $this->patient = Auth::user()->patient;
        $this->loadAppointments();
    }

    public function loadAppointments()
    {
        $this->appointmentHistory = Appointment::with(['consultationFeedback', 'medicalRecord.diagnoses', 'medicalRecord.physicalExaminations', 'dentalRecord', 'doctor'])
            ->where('patient_id', $this->patient->id)
            ->orderBy('appointment_date', 'desc')
            ->get();

        $this->hasUpcomingAppointment = Appointment::where('patient_id', $this->patient->id)
            ->where('appointment_date', '>=', now())
            ->whereIn('status', ['approved'])
            ->first();

        // Also prepare walk-in records (medical records not linked to an appointment)
        $this->loadWalkIns();
    }

    public function loadWalkIns()
    {
        // Medical records that belong to this patient and are not linked to an appointment
        $this->walkInMedicalRecords = \App\Models\MedicalRecord::with(['physicalExaminations', 'diagnoses', 'appointment.doctor'])
            ->where('patient_id', $this->patient->id)
            ->whereNull('appointment_id')
            ->orderBy('last_visited', 'desc')
            ->get();

        // Dental records that belong to this patient and are not linked to an appointment
        $this->walkInDentalRecords = \App\Models\DentalRecord::with(['appointment.doctor'])
            ->where('patient_id', $this->patient->id)
            ->whereNull('appointment_id')
            ->orderBy('created_at', 'desc')
            ->get();
    }

    public function showWalkIns()
    {
        $this->showingWalkIns = true;
        $this->loadWalkIns();
    }

    public function showAppointments()
    {
        $this->showingWalkIns = false;
        $this->expandedWalkIn = null;
    }

    public function toggleExpandWalkIn($recordId)
    {
        $this->expandedWalkIn = $this->expandedWalkIn === $recordId ? null : $recordId;
    }

    public function confirmCancel($appointmentId)
    {
        $this->cancelAppointmentId = $appointmentId;
        $this->showCancelModal = true;
    }

    public function cancelAppointment()
    {
        $appointment = Appointment::find($this->cancelAppointmentId);

        if ($appointment) {
            $appointment->status = 'cancelled';
            $appointment->cancellation_reason = $this->cancelReason;
            $appointment->status_updated_by = Auth::id();
            $appointment->save();

            $schedule = DoctorSchedule::where('doctor_id', $appointment->clinic_staff_id)
                ->where('date', Carbon::parse($appointment->appointment_date)->format('Y-m-d'))
                ->first();

            if ($schedule) {
                $availableTimes = is_array($schedule->available_times) 
                    ? $schedule->available_times 
                    : json_decode($schedule->available_times, true) ?? [];

                $newTime = Carbon::parse($appointment->appointment_date)->format('g:i A');
                if (!in_array($newTime, $availableTimes)) {
                    $availableTimes[] = $newTime;
                }

                $schedule->update(['available_times' => $availableTimes]);
            }


            // Refresh appointments
            $this->loadAppointments();

            // Reset variables
            $this->cancelAppointmentId = null;
            $this->cancelReason = null;
            $this->showCancelModal = false;
            $this->showCancelSuccessModal = true;
        }
    }

    public function toggleExpand($appointmentId)
    {
        $this->expandedRow = $this->expandedRow === $appointmentId ? null : $appointmentId;
    }

    public function openFeedbackModal($appointmentId)
    {
        $this->feedbackAppointmentId = $appointmentId;
        $this->appointmentId = $appointmentId;
        $this->showFeedbackModal = true;
    }

    public function feedback()
    {
        return $this->hasOne(Feedback::class, 'appointment_id');
    }

    public function setRating($value)
    {
        $this->rating = $value;
    }

    public function submitConsultationFeedback()
    {
        $this->validate([
            'rating' => 'required|integer|min:1|max:5'
        ]);

        Feedback::create([
            'user_id' => Auth::id(),
            'appointment_id' => $this->feedbackAppointmentId,
            'type' => 'consultation',
            'emoji' => null,
            'rating' => $this->rating,
            'comment' => $this->consultationFeedback,
            'anonymous' => $this->anonymous,
        ]);

        $this->reset(['rating', 'consultationFeedback', 'anonymous', 'showFeedbackModal', 'feedbackAppointmentId']);
    }

    public function closeFeedbackModal()
    {
        $this->showFeedbackModal = false;
        $this->feedbackAppointmentId = null;
        $this->consultationFeedback = null;
        $this->rating = 0;
    }

    public function downloadMedicalRecord($appointmentId)
    {
        $appointment = Appointment::with(['patient', 'medicalRecord'])->find($appointmentId);

        $medicalRecord = $appointment->medicalRecord;
        $patient = $appointment->patient;

        $data = [
            'patient' => $patient,
            'medicalRecord' => $medicalRecord,
            'appointment' => $appointment,
            'dateGenerated' => Carbon::now()->format('F j, Y, g:i A'),
        ];

        $pdf = Pdf::loadView('pdf.medical-record-pdf', $data);
        return response()->streamDownload(function() use ($pdf) {
            echo $pdf->output();
        }, 'Medical_Record_' . $patient->first_name . '_' . $patient->last_name . '_' . Carbon::now()->format('Ymd_His') . '.pdf');
    }

    public $requested_record_id;
    
    public function requestMedicalRecord($recordId)
    {
        \Log::info('Received request to send med record email for ID: ' . $recordId);

        $record = \App\Models\MedicalRecord::where('appointment_id', $recordId)->first();

        if (!$record) {
            \Log::info('Record not found for email!');
            return;
        }

        \Log::info('Preparing to send mail for record ID: ' . $record->id);
        
        Mail::to('primsapcclinic@gmail.com')->send(new RecordRequestMail($record, 'medical'));

        \Log::info('Mail sent successfully (or queued).');
        
        $this->showRequestPrompt = true;

        // optional success flash message
        session()->flash('success', 'An email has been sent to the nurse.');
    }

    public function requestDentalRecord($recordId)
    {
        \Log::info('Received request to send dental record email for ID: ' . $recordId);

        $record = DentalRecord::where('appointment_id', $recordId)->first();

        if (!$record) {
            \Log::info('Dental record not found for email!');
            return;
        }

        \Log::info('Preparing to send mail for dental record ID: ' . $record->id);

        Mail::to('primsapcclinic@gmail.com')->send(new RecordRequestMail($record, 'dental'));

        \Log::info('Dental appointment IDs in DB: ' . implode(',', DentalRecord::pluck('appointment_id')->toArray()));

        \Log::info('Mail sent successfully (or queued).');

        $this->showRequestPrompt = true;
        session()->flash('success', 'An email has been sent to the nurse.');
    }


    public function render()
    {
        return view('livewire.appointment-history', [
            'appointmentHistory' => $this->appointmentHistory,
            'hasUpcomingAppointment' => $this->hasUpcomingAppointment,
        ]);
    }
}
