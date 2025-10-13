<?php

use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\Log;
use Illuminate\Console\Scheduling\Schedule;
use App\Models\Appointment;
use App\Models\DoctorSchedule;
use App\Mail\CancelledAppointment;
use Carbon\Carbon;
use Illuminate\Support\Facades\Mail;
use App\Models\ClinicStaff;

Artisan::command('appointments:auto-cancel', function () {
    $minutes = 1;
    $now = Carbon::now('Asia/Manila');
    $threshold = $now->copy()->subMinutes($minutes);

    $dueAppointments = Appointment::where('status', 'approved')
        ->where('appointment_date', '<=', $threshold->toDateTimeString())
        ->with('patient')
        ->get();

    if ($dueAppointments->isEmpty()) {
        $this->info("No overdue appointments found.");
        return;
    }

    foreach ($dueAppointments as $appointment) {
        try {
            $appointment->status = 'cancelled';
            $appointment->cancellation_reason = "Automatically cancelled after {$minutes} minutes past scheduled time.";
            $appointment->status_updated_by = null;
            $appointment->save();

            $schedule = DoctorSchedule::where('doctor_id', $appointment->clinic_staff_id)
                ->where('date', Carbon::parse($appointment->appointment_date)->format('Y-m-d'))
                ->first();

            if ($schedule) {
                $availableTimes = is_array($schedule->available_times)
                    ? $schedule->available_times
                    : json_decode($schedule->available_times, true) ?? [];

                $timeToAdd = Carbon::parse($appointment->appointment_date)->format('g:i A');

                if (!in_array($timeToAdd, $availableTimes)) {
                    $availableTimes[] = $timeToAdd;
                    $schedule->update(['available_times' => json_encode($availableTimes)]);
                }
            }

            if (!empty($appointment->patient->email)) {
                Mail::to($appointment->patient->email)->send(new CancelledAppointment($appointment));
            }

            Log::info("Auto-cancelled appointment ID {$appointment->id}");
        } catch (\Exception $e) {
            Log::error("Error auto-cancelling appointment ID {$appointment->id}: " . $e->getMessage());
        }
    }

    $this->info("Processed auto-cancel for overdue appointments.");
})->purpose('Auto-cancel overdue approved appointments');

app(Schedule::class)->command('appointments:auto-cancel')->everyMinute();