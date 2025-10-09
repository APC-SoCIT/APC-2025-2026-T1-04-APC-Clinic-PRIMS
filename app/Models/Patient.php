<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Patient extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'user_id',
        'category_id',

        'apc_id_number',
        'first_name',
        'middle_initial',
        'last_name',

        'gender',
        'date_of_birth',
        'nationality',

        'blood_type',
        'civil_status',
        'religion',
        'contact_number',

        'email',
        'house_unit_number',
        'street',
        'barangay',
        'city',
        'province',
        'zip_code',
        'country',

        'emergency_contact_name',
        'emergency_contact_number',
        'emergency_contact_relationship',
    ];

    protected $casts = [
    'birthdate' => 'date',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function appointments()
    {
        return $this->hasMany(Appointment::class);
    }

    public function medicalRecords()
    {
        return $this->hasMany(MedicalRecord::class);
    }

    public function rfidCards()
    {
        return $this->hasMany(RfidCard::class);
    }
}
