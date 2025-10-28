<?php

namespace App\Livewire;

use Livewire\Component;
use App\Models\User;

class AdminDoctorSchedule extends Component
{
    public $doctors = [];
    public $selectedDoctor;
    public $selectedDate;
    public $customTime;
    public $availableTimes = [];

    public function mount()
    {
        // Fetch users who have the "doctor" role
        $this->doctors = User::role('doctor')->get(['id', 'email']);
    }

    public function addCustomTime()
    {
        if ($this->customTime && !in_array($this->customTime, $this->availableTimes)) {
            $this->availableTimes[] = $this->customTime;
            $this->customTime = '';
        }
    }

    public function removeTime($time)
    {
        $this->availableTimes = array_filter($this->availableTimes, fn ($t) => $t !== $time);
    }

    public function saveSchedule()
    {
        // Placeholder for saving logic later
        session()->flash('message', 'Schedule saved successfully!');
    }

    public function render()
    {
        return view('livewire.admin-doctor-schedule');
    }
}
