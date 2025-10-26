<?php

namespace App\Livewire;

use Livewire\Component;
use App\Models\Doctor;

class AdminAccManagement extends Component
{
    public $search = '';
    public $filterRole = '';
    public $filterStatus = '';

    public $modalOpen = false;       // One modal for both input & confirm
    public $email = '';
    public $doctorInfo = [];
    public $isConfirmStep = false;   // Step toggle: false=input, true=confirm

    public $showSuccessModal = false;
    public $successMessage = '';

    public $showErrorModal = false;
    public $errorMessage = '';

    // Sample data for school doctors

    public $schoolDoctors = [
        'jdoe@apc.edu.ph' => ['first_name'=>'John','last_name'=>'Doe','role'=>'doctor'],
        'jsmith@apc.edu.ph' => ['first_name'=>'Jane','last_name'=>'Smith','role'=>'dentist'],
        'awilliams@apc.edu.ph' => ['first_name'=>'Alice','last_name'=>'Williams','role'=>'nurse'],
        'bnguyen@apc.edu.ph' => ['first_name'=>'Bob','last_name'=>'Nguyen','role'=>'doctor'],
        'cgarcia@apc.edu.ph' => ['first_name'=>'Carla','last_name'=>'Garcia','role'=>'dentist'],
        'dmartin@apc.edu.ph' => ['first_name'=>'David','last_name'=>'Martin','role'=>'nurse'],
        'eroberts@apc.edu.ph' => ['first_name'=>'Emma','last_name'=>'Roberts','role'=>'doctor'],
        'flee@apc.edu.ph' => ['first_name'=>'Frank','last_name'=>'Lee','role'=>'dentist'],
        'gclark@apc.edu.ph' => ['first_name'=>'Grace','last_name'=>'Clark','role'=>'nurse'],
        'hyoung@apc.edu.ph' => ['first_name'=>'Hannah','last_name'=>'Young','role'=>'doctor'],
        'ijones@apc.edu.ph' => ['first_name'=>'Ian','last_name'=>'Jones','role'=>'dentist'],
        'klong@apc.edu.ph' => ['first_name'=>'Kelly','last_name'=>'Long','role'=>'nurse'],
        'lwilson@apc.edu.ph' => ['first_name'=>'Leo','last_name'=>'Wilson','role'=>'doctor'],
        'mmorris@apc.edu.ph' => ['first_name'=>'Mia','last_name'=>'Morris','role'=>'dentist'],
        'nking@apc.edu.ph' => ['first_name'=>'Nathan','last_name'=>'King','role'=>'nurse'],
        'opatel@apc.edu.ph' => ['first_name'=>'Olivia','last_name'=>'Patel','role'=>'doctor'],
        'pwhite@apc.edu.ph' => ['first_name'=>'Peter','last_name'=>'White','role'=>'dentist'],
        'qyoung@apc.edu.ph' => ['first_name'=>'Quinn','last_name'=>'Young','role'=>'nurse'],
        'rwalker@apc.edu.ph' => ['first_name'=>'Rachel','last_name'=>'Walker','role'=>'doctor'],
        'slee@apc.edu.ph' => ['first_name'=>'Samuel','last_name'=>'Lee','role'=>'dentist'],
    ];

    public function setInactive($email)
    {
        $doctor = Doctor::where('email', $email)->first();
        if ($doctor) {
            $doctor->status = 'Inactive';
            $doctor->save();
        }
    }

    public function setActive($email)
    {
        $doctor = Doctor::where('email', $email)->first();
        if ($doctor) {
            $doctor->status = 'Active';
            $doctor->save();
        }
    }

    public function deleteDoctor($email)
    {
        $doctor = Doctor::where('email', $email)->first();
        if ($doctor) {
            $doctor->delete();
        }
    }

    public function openModal()
    {
        $this->modalOpen = true;
        $this->isConfirmStep = false;
        $this->email = '';
        $this->doctorInfo = [];
    }

    public function closeModal()
    {
        $this->modalOpen = false;
        $this->isConfirmStep = false;
        $this->email = '';
        $this->doctorInfo = [];
    }

    public function submitEmail()
    {
        $email = strtolower(trim($this->email));
        if (!$email) return;

        // Already in clinic DB
        if (Doctor::where('email', $email)->exists()) {
            $this->errorMessage = 'Already added. This doctor is in the clinic database.';
            $this->showErrorModal = true;
            $this->closeModal();
            return;
        }

        // Not in school dummy DB
        if (!isset($this->schoolDoctors[$email])) {
            $this->errorMessage = 'Doctor not found in school database.';
            $this->showErrorModal = true;
            return;
        }

        // Prepare doctor info
        $dummy = $this->schoolDoctors[$email];
        $this->doctorInfo = [
            'first_name' => $dummy['first_name'],
            'last_name'  => $dummy['last_name'],
            'email'      => $email,
            'role'       => ucfirst($dummy['role']),
            'status'     => 'Active',
        ];

        // Move to confirm step
        $this->isConfirmStep = true;
    }

    public function confirmAddDoctor()
    {
        $email = $this->doctorInfo['email'];

        // Check duplicate
        if (Doctor::where('email', $email)->exists()) {
            $this->successMessage = 'Already added. This doctor is in the clinic database.';
            $this->showSuccessModal = true;
            $this->closeModal(); // close input modal if open
            return;
        }

        // Add doctor
        Doctor::create($this->doctorInfo);

        $this->successMessage = 'Doctor added successfully!';
        $this->showSuccessModal = true;
        $this->closeModal(); // close input modal if open
    }

    public function closeSuccessModal()
    {
        $this->showSuccessModal = false;
        $this->successMessage = '';
    }

    public function render()
    {
        $doctors = Doctor::query()
            ->when($this->search, function ($query) {
                $query->where('first_name', 'like', '%' . $this->search . '%')
                      ->orWhere('last_name', 'like', '%' . $this->search . '%')
                      ->orWhere('email', 'like', '%' . $this->search . '%');
            })
            ->when($this->filterRole, function ($query) {
                $query->where('role', $this->filterRole);
            })
            ->when($this->filterStatus, function ($query) {
                $query->where('status', $this->filterStatus);
            })
            ->orderBy('last_name')
            ->get();

        return view('livewire.admin-acc-management', [
            'doctors' => $doctors,
        ]);
    }
}
