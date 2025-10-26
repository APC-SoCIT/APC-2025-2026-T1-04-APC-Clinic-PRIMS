<?php

namespace App\Livewire;

use Livewire\Component;
use App\Models\RolePermission;

class RolesPermissions extends Component
{
    public $roles = ['doctor', 'dentist', 'nurse', 'patient'];
    public $permissions = [];

    public function mount()
    {
        // Load from DB, or seed defaults if empty
        $records = RolePermission::all();

        if ($records->isEmpty()) {
            $this->permissions = [
                'calendar_&_appointment' => [
                'set_doctors_schedule' => ['doctor' => true, 'dentist' => true, 'nurse' => false, 'patient' => false],
                'view_doctors_schedule' => ['doctor' => true, 'dentist' => true, 'nurse' => true, 'patient' => true],
                'book_appointment' => ['doctor' => false, 'dentist' => false, 'nurse' => false, 'patient' => true],
                'approve_or_decline_pending_appointment' => ['doctor' => true, 'dentist' => true, 'nurse' => true, 'patient' => false],
                'cancel_appointment' => ['doctor' => true, 'dentist' => true, 'nurse' => true, 'patient' => true],
                'view_appointment_history' => ['doctor' => false, 'dentist' => false, 'nurse' => false, 'patient' => true],
                'request_printed_medical_or_dental_record' => ['doctor' => false, 'dentist' => false, 'nurse' => false, 'patient' => true],
                ],

                'medical_record' => [
                    'add_record' => ['doctor' => true, 'dentist' => false, 'nurse' => true, 'patient' => false],
                    'view_record' => ['doctor' => true, 'dentist' => false, 'nurse' => true, 'patient' => true],
                    'search_patient' => ['doctor' => true, 'dentist' => true, 'nurse' => true, 'patient' => false],
                    'print_record' => ['doctor' => true, 'dentist' => true, 'nurse' => false, 'patient' => false],
                ],

                'dental_record' => [
                    'add_record' => ['doctor' => false, 'dentist' => true, 'nurse' => true, 'patient' => false],
                    'view_record' => ['doctor' => false, 'dentist' => true, 'nurse' => true, 'patient' => true],
                    'search_patient' => ['doctor' => false, 'dentist' => true, 'nurse' => true, 'patient' => false],
                    'print_record' => ['doctor' => false, 'dentist' => true, 'nurse' => false, 'patient' => false],
                ],

                'medical_inventory' => [
                    'add_inventory' => ['doctor' => false, 'dentist' => false, 'nurse' => true, 'patient' => false],
                    'view_inventory' => ['doctor' => false, 'dentist' => false, 'nurse' => true, 'patient' => false],
                    'dispose/dispense_medicine' => ['doctor' => false, 'dentist' => false, 'nurse' => true, 'patient' => false],
                    'generate_inventory_report' => ['doctor' => false, 'dentist' => false, 'nurse' => true, 'patient' => false],
                ],

                'summary_report' => [
                    'view_summary' => ['doctor' => false, 'dentist' => false, 'nurse' => true, 'patient' => false],
                    'generate_accomplishment' => ['doctor' => false, 'dentist' => false, 'nurse' => true, 'patient' => false],
                    'print_accomplishment' => ['doctor' => false, 'dentist' => false, 'nurse' => true, 'patient' => false],
                ],
            ];
            $this->savePermissionsToDatabase();

        } else {
            foreach ($records as $r) {
                $this->permissions[$r->category][$r->action][$r->role] = (bool) $r->allowed;
            }
        }
    }

    public function togglePermission($category, $action, $role)
    {
        $this->permissions[$category][$action][$role] = !$this->permissions[$category][$action][$role];
        $this->saveSinglePermission($category, $action, $role);
    }

    protected function saveSinglePermission($category, $action, $role)
    {
        RolePermission::updateOrCreate(
            ['category' => $category, 'action' => $action, 'role' => $role],
            ['allowed' => $this->permissions[$category][$action][$role]]
        );
    }

    public function savePermissionsToDatabase()
    {
        foreach ($this->permissions as $category => $actions) {
            foreach ($actions as $action => $roles) {
                foreach ($roles as $role => $allowed) {
                    RolePermission::updateOrCreate(
                        ['category' => $category, 'action' => $action, 'role' => $role],
                        ['allowed' => $allowed]
                    );
                }
            }
        }

        session()->flash('success', 'Permissions saved successfully!');
    }

    public function render()
    {
        return view('livewire.roles-permissions');
    }
}
