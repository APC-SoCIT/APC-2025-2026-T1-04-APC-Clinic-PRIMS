<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class DentalRecord extends Model
{
    protected $fillable = [
        'patient_id',
        'oral_hygiene',
        'gingival_color',
        'prophylaxis',
        'teeth',
        'recommendation',
    ];

    protected $casts = [
        'teeth' => 'array',       // automatically json encode/decode
        'prophylaxis' => 'boolean',
    ];

    public function patient()
    {
        return $this->belongsTo(Patient::class, 'patient_id');
    }

    public function latestRecord()
    {
        return $this->hasOne(MedicalRecord::class, 'apc_id_number', 'apc_id_number')
            ->latestOfMany('last_visited');
    }

}
