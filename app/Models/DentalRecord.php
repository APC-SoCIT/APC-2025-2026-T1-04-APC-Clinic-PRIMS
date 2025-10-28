<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class DentalRecord extends Model
{
    protected $fillable = [
        'patient_id',
        'oral_hygiene',
        'gingival_color',
        'procedures',
        'procedure_notes',
        'teeth',
        'recommendation',
        'appointment_id',
        'doctor_id',
        'archived_at',
    ];

    protected $casts = [
        'teeth' => 'array',       
        'oral_hygiene' => 'array', // needed for Livewire
        'procedures' => 'array',   // optional, good for consistency
    ];

    public function patient()
    {
        return $this->belongsTo(Patient::class, 'patient_id');
    }

    public function doctor()
    {
        return $this->belongsTo(ClinicStaff::class, 'doctor_id');
    }

    public function appointment()
    {
        return $this->belongsTo(Appointment::class, 'appointment_id');
    }
}
