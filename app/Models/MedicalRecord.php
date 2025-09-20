<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class MedicalRecord extends Model
{
    use HasFactory;

    protected $fillable = [
        'patient_id',
        'reason',
        'description',
        'last_visited',
        'allergies',
        'past_medical_history',
        'family_history',
        'social_history',
        'obgyne_history',
        'hospitalization',
        'operation',
        'immunizations',
        'prescription',
        'appointment_id',
        'archived_at',
    ];

    protected static function booted()
    {
        static::addGlobalScope('notArchived', function ($query) {
            $query->whereNull('archived_at');
        });
    }

    public function patient()
    {
        return $this->belongsTo(Patient::class);
    }

    public function appointment()
    {
        return $this->belongsTo(Appointment::class, 'appointment_id');
    }

    public function latestRecord()
    {
        return $this->hasOne(MedicalRecord::class, 'apc_id_number', 'apc_id_number')
            ->latestOfMany('last_visited');
    }

        public function diagnoses()
    {
        return $this->hasMany(Diagnosis::class);
    }

    public function physicalExaminations()
    {
        return $this->hasMany(PhysicalExamination::class);
    }

    public function scopeArchived($query)
    {
        return $query->whereNotNull('archived_at');
    }
}