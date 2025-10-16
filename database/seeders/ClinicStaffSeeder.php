<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\User;
use App\Models\ClinicStaff;

class ClinicStaffSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run()
    {
        // Define patient details for each user
        $clinicstaffs = [
            [
                'email' => 'anamaet@apc.edu.ph',
                'clinic_staff_fname' => 'Ana Mae',
                'clinic_staff_minitial' => 'J',
                'clinic_staff_lname' => 'Torre',
                'clinic_staff_role' => 'Nurse',
                'doctor_category' => null,
                'clinic_staff_image' => null,
                'clinic_staff_desc' => null,
            ],
            [
                'email' => 'junavendano@apc.edu.ph',
                'clinic_staff_fname' => 'Jun',
                'clinic_staff_minitial' => null,
                'clinic_staff_lname' => 'Avendano',
                'clinic_staff_role' => 'Doctor',
                'doctor_category' => 'Medical',
                'clinic_staff_image' => 'img/clinic-staff/boy-doctor.png',
                'clinic_staff_desc' => 'Medical Doctor',
            ],
            [
                'email' => 'sallysamoza@apc.edu.ph',
                'clinic_staff_fname' => 'Sally',
                'clinic_staff_minitial' => null,
                'clinic_staff_lname' => 'Samoza',
                'clinic_staff_role' => 'Doctor',
                'doctor_category' => 'Dentist',
                'clinic_staff_image' => 'img/clinic-staff/girl-doctor.png',
                'clinic_staff_desc' => 'Dental Doctor',
            ],
            [
                'email' => 'winniesy@apc.edu.ph',
                'clinic_staff_fname' => 'Winnie',
                'clinic_staff_minitial' => null,
                'clinic_staff_lname' => 'Sy',
                'clinic_staff_role' => 'Doctor',
                'doctor_category' => 'Dentist',
                'clinic_staff_image' => 'img/clinic-staff/girl-doctor.png',
                'clinic_staff_desc' => 'Dental Doctor',
            ],
        ];

        foreach ($clinicstaffs as $clinicstaff) {
            // Find the corresponding user by email
            $user = User::where('email', $clinicstaff['email'])->first();

            if ($user && $user->hasRole('clinic staff')) {
                ClinicStaff::create([
                    'user_id' => $user->id,
                    'clinic_staff_fname' => $clinicstaff['clinic_staff_fname'],
                    'clinic_staff_minitial' => $clinicstaff['clinic_staff_minitial'],
                    'clinic_staff_lname' => $clinicstaff['clinic_staff_lname'],
                    'email' => $clinicstaff['email'],
                    'clinic_staff_role' => $clinicstaff['clinic_staff_role'],
                    'doctor_category' => $clinicstaff['doctor_category'],
                    'clinic_staff_image' => $clinicstaff['clinic_staff_image'],
                    'clinic_staff_desc' => $clinicstaff['clinic_staff_desc'],
                ]);
            }
        }
    }
}
