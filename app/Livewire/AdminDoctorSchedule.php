<?php

namespace App\Livewire;

use Livewire\Component;
use App\Models\User;
use App\Models\DoctorSchedule;

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

    public function updatedSelectedDoctor()
    {
        $this->loadSchedule();
    }

    public function updatedSelectedDate()
    {
        $this->loadSchedule();
    }

    public function addCustomTime()
    {
        if ($this->customTime) {
            // Convert to 12-hour format
            $formattedTime = date("g:i A", strtotime($this->customTime));

            if (!in_array($formattedTime, $this->availableTimes)) {
                $this->availableTimes[] = $formattedTime;
                sort($this->availableTimes);
            }

            $this->customTime = '';
        }
    }

    public function removeTime($time)
    {
        $this->availableTimes = array_values(
            array_filter($this->availableTimes, fn ($t) => $t !== $time)
        );
    }

    public function saveSchedule()
    {
        if (!$this->selectedDoctor || !$this->selectedDate) {
            session()->flash('message', 'Please select a doctor and date.');
            return;
        }

        DoctorSchedule::updateOrCreate(
            [
                'doctor_id' => $this->selectedDoctor,
                'date' => $this->selectedDate,
            ],
            [
                'available_times' => json_encode($this->availableTimes),
            ]
        );

        session()->flash('message', 'Schedule saved successfully!');
    }

    private function loadSchedule()
    {
        if ($this->selectedDoctor && $this->selectedDate) {
            $schedule = DoctorSchedule::where('doctor_id', $this->selectedDoctor)
                ->where('date', $this->selectedDate)
                ->first();

            $this->availableTimes = $schedule ? json_decode($schedule->available_times, true) : [];
        } else {
            $this->availableTimes = [];
        }
    }

    public function render()
    {
        return view('livewire.admin-doctor-schedule');
    }
}
