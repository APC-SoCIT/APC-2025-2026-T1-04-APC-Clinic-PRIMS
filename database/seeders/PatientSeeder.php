<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;
use App\Models\Patient;

class PatientSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run()
    {
        // Define patient details for each user
        $patients = [
            [
                'apc_id_number' => '2022-140224',
                'first_name' => 'Shannelien Mae',
                'middle_initial' => 'M',
                'last_name' => 'Catingub',
                'gender' => 'Female',
                'date_of_birth' => '2003-12-29',
                'nationality' => 'Filipino',
                'blood_type' => 'O',
                'civil_status' => 'Single',
                'religion' => 'Roman Catholic',
                'contact_number' => '09761164892',


                'email' => 'smcatingub@student.apc.edu.ph',
                'house_unit_number' => '000',
                'street' => 'J. Street',

                'barangay' => 'Barangay',

                'city' => 'Pasig',
                'province' => 'NCR',
                'zip_code' => '0000',
                'country' => 'Philippines',
                'emergency_contact_name' => 'Emergency Name',
                'emergency_contact_number' => '09876543210',
                'emergency_contact_relationship' => 'Relationship',
            ],
            [
                'apc_id_number' => '2022-140335',
                'first_name' => 'Erika Alessandra',
                'middle_initial' => 'D',
                'last_name' => 'Daduya',
                'gender' => 'Female',
                'date_of_birth' => '2003-10-27',
                'nationality' => 'Filipino',
                'blood_type' => 'O',
                'civil_status' => 'Single',
                'religion' => 'Born Again Christian',
                'contact_number' => '09112345678',

                'email' => 'eddaduya@student.apc.edu.ph',
                'house_unit_number' => '000',
                'street' => 'street',

                'barangay' => 'Barangay',

                'city' => 'Paranaque',
                'province' => 'NCR',
                'zip_code' => '1111',
                'country' => 'Philippines',
                'emergency_contact_name' => 'Emergency Name',
                'emergency_contact_number' => '09876543210',
                'emergency_contact_relationship' => 'Secret',
            ],
            [
                'apc_id_number' => '2022-140267',
                'first_name' => 'Clart Kent',
                'middle_initial' => 'K',
                'last_name' => 'Nailgas',
                'gender' => 'Male',
                'date_of_birth' => '2002-10-05',
                'nationality' => 'Filipino',
                'blood_type' => 'Di ko alam',
                'civil_status' => 'Married',
                'religion' => 'Catholic maybe',
                'contact_number' => '09129087654',

                'email' => 'cknailgas@student.apc.edu.ph',
                'house_unit_number' => '123',
                'street' => 'Street',
                'barangay' => 'Barangay',
                'city' => 'Taguig',
                'province' => 'NCR',
                'zip_code' => '2222',
                'country' => 'Philippines',

            ],
            [
                'apc_id_number' => '2022-140289',
                'apc_id_number' => '2022-140289',
                'email' => 'barabajante3@student.apc.edu.ph',
                'first_name' => 'Byron Louis',
                'middle_initial' => 'A',
                'last_name' => 'Rabajante',
                'gender' => 'Male',
                'date_of_birth' => '2003-08-22',
                'nationality' => 'Filipino',
                'blood_type' => 'Di ko alam',
                'civil_status' => 'Married',
                'religion' => 'Catholic maybe',
                'contact_number' => '09456298987',
                
                'house_unit_number' => '123',
                'street' => 'Street',

                'barangay' => 'Barangay',

                'city' => 'Taguig',
                'province' => 'NCR',
                'zip_code' => '0000',
                'country' => 'Philippines',
                'emergency_contact_name' => 'Emergency Name',
                'emergency_contact_number' => '09876543210',
                'emergency_contact_relationship' => 'Relationship',
            ],
            [
                'apc_id_number' => '2022-140145',
                'first_name' => 'John Keisuke',
                'middle_initial' => 'M',
                'last_name' => 'Miyabe',
                'gender' => 'Male',
                'date_of_birth' => '2004-05-05',
                'nationality' => 'Filipino',
                'blood_type' => 'Di ko alam',
                'civil_status' => 'Married',
                'religion' => 'Christian diba',
                'contact_number' => '09658014225',


                'email' => 'jmmiyabe@student.apc.edu.ph',
                'house_unit_number' => '123',
                'street' => 'Street',

                'barangay' => 'Barangay',

                'city' => 'Taguig',
                'province' => 'NCR',
                'zip_code' => '0000',
                'country' => 'Philippines',
                'emergency_contact_name' => 'Emergency Name',
                'emergency_contact_number' => '09876543210',
                'emergency_contact_relationship' => 'Relationship',
            ],
        ];

        foreach ($patients as $patient) {
            // Find the corresponding user by email
            $user = User::where('email', $patient['email'])->first();

            if ($user && $user->hasRole('patient')) {
                Patient::create([
                    'user_id' => $user->id,
                    'apc_id_number' => $patient['apc_id_number'],
                    'first_name' => $patient['first_name'],
                    'middle_initial' => $patient['middle_initial'],
                    'last_name' => $patient['last_name'],
                    'gender' => $patient['gender'],
                    'date_of_birth' => $patient['date_of_birth'],
                    'nationality' => $patient['nationality'],
                    'blood_type' => $patient['blood_type'],
                    'civil_status' => $patient['civil_status'],
                    'religion' => $patient['religion'],
                    'contact_number' => $patient['contact_number'],
                    'email' => $patient['email'],
                    'house_unit_number' => $patient['house_unit_number'] ?? null,
                    'street' => $patient['street'] ?? null, 
                    'barangay' => $patient['barangay'] ?? null,
                    'city' => $patient['city'] ?? null,
                    'province' => $patient['province'] ?? null,
                    'zip_code' => $patient['zip_code'] ?? null,
                    'country' => $patient['country'] ?? null,
                    'emergency_contact_name' => $patient['emergency_contact_name'] ?? null,
                    'emergency_contact_number' => $patient['emergency_contact_number'] ?? null,
                    'emergency_contact_relationship' => $patient['emergency_contact_relationship'] ?? null,
                ]);
            }
        }

        \App\Models\Patient::factory()->count(200)->create();

    }
}
