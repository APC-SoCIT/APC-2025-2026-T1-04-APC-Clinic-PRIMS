<?php

namespace Database\Seeders;

use App\Models\User;
// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Database\Seeders\UserSeeder;
use Database\Seeders\RolesSeeder;
use Database\Seeders\PatientSeeder;
use Database\Seeders\ClinicStaffSeeder;
use Database\Seeders\RfidCardsTableSeeder;
use App\Models\Appointment;
use App\Models\MedicalRecord;
use App\Models\Supply;
use App\Models\Inventory;
use App\Models\Dispensed;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        $this->call([
            RolesSeeder::class,
            UserSeeder::class,
            PatientSeeder::class,
            ClinicStaffSeeder::class,
            RfidCardsTableSeeder::class,
        ]);

        Appointment::factory(200)->create();
        MedicalRecord::factory(200)->create();
        Supply::factory(10)->create();
        Inventory::factory(20)->create();
        Dispensed::factory(15)->create();
    }
}
