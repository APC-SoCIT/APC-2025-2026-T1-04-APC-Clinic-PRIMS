<div>
    <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
        <x-prims-sub-header>Appointment History</x-prims-sub-header>
        <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-lg sm:rounded-lg mt-5">
            <div class="p-6 lg:p-8 gap-8 bg-white dark:bg-gray-800 border-b border-gray-200 dark:border-gray-700 flex flex-wrap justify-start">
                <!-- left - picture -->
                <!-- <div>
                    <img src="img/appointment-history/temp-id-pic.jpg" class="max-h-44 inline-block align-middle">
                </div> -->

                <!-- center - personal details -->
                <div class="flex flex-col w-2/5">
                    <div class="text-3xl pb-5">
                        <strong>{{ $patient->first_name }} {{ $patient->middle_initial }}. {{ $patient->last_name }}</strong>
                    </div>
                    <div class="flex justify-start gap-5 flex-wrap">
                        <div class="flex flex-col gap-3">
                            <div class="text-sm flex flex-row align-center gap-2">
                                <img src="img/appointment-history/id-number-icon.svg" class="max-h-20">
                                <span>{{ $patient->apc_id_number }}</span>
                            </div>
                            <div class="text-sm flex flex-row align-center gap-2">
                                <img src="img/appointment-history/contact-number-icon.svg" class="max-h-20">
                                <span>{{ $patient->contact_number }}</span>
                            </div>
                        </div>
                        <div class="flex flex-col gap-3 max-w-[70%]">
                            <div class="text-sm flex flex-row align-center gap-2 break-all">
                                <img src="img/appointment-history/email-icon.svg" class="max-h-20">
                                <span>{{ $patient->email }}</span>
                            </div>
                            <div class="text-sm flex flex-row align-center gap-2 break-words">
                                <img src="img/appointment-history/gender-icon.svg" class="max-h-20">
                                <span>{{ $patient->gender }}</span>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- right - appointments -->
                <div>
                    <div class="p-3 border border-gray-200 rounded-lg bg-white shadow-md>
                        <p class="text-md"><strong>Upcoming Appointment:</strong></p>

                        @if($hasUpcomingAppointment)
                            <p class="text-2xl underline"><strong>
                                {{ \Carbon\Carbon::parse($hasUpcomingAppointment->appointment_date)->format('F j, Y - h:i A') }} 
                            </strong></p>
                            <p> 
                                Dr. {{ $hasUpcomingAppointment->doctor->clinic_staff_fname }} {{ $hasUpcomingAppointment->doctor->clinic_staff_lname }}
                            </p>
                            <p class="max-w-sm break-all">
                                Reason: {{ $hasUpcomingAppointment->reason_for_visit }}
                            </p>
                        @else
                            <span class="text-sm text-gray-500">None</span>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Appointment History Table -->
    <div class="max-w-7xl mx-auto mt-5 sm:px-6 lg:px-8">
        <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-lg sm:rounded-lg">
            <div class="p-6 lg:p-8 gap-6 bg-white dark:bg-gray-800 border-b border-gray-200 dark:border-gray-700">
                <div class="justify-between flex items-end">
                    <span>Total: {{ $appointmentHistory->count() }}</span>
                </div>
                <div class="overflow-x-auto py-4">
                    <table class="w-full bg-white dark:bg-gray-800 border border-gray-200 dark:border-gray-700 rounded-lg shadow-lg">
                        <thead class="bg-gray-100 dark:bg-gray-700 text-gray-700 dark:text-gray-300">
                            <tr>
                                <th class="text-left px-6 py-3 text-sm font-medium uppercase border-b dark:border-gray-600">#</th>
                                <th class="text-left px-6 py-3 text-sm font-medium uppercase border-b dark:border-gray-600">ID Number</th>
                                <th class="text-left px-6 py-3 text-sm font-medium uppercase border-b dark:border-gray-600">Date</th>
                                <th class="text-left px-6 py-3 text-sm font-medium uppercase border-b dark:border-gray-600">Time</th>
                                <th class="text-left px-6 py-3 text-sm font-medium uppercase border-b dark:border-gray-600">Doctor</th>
                                <th class="text-left px-6 py-3 text-sm font-medium uppercase border-b dark:border-gray-600">Status</th>
                                <th class="text-left px-6 py-3 text-sm font-medium uppercase border-b dark:border-gray-600">Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($appointmentHistory as $index => $appointment)
                                <tr class="hover:bg-gray-50 cursor-pointer" wire:click="toggleExpand({{ $appointment->id }})">
                                    <td class="px-6 py-4 border-b dark:border-gray-600">{{ $index + 1 }}</td>
                                    <td class="px-6 py-4 border-b dark:border-gray-600">{{ $appointment->patient->apc_id_number }}</td>
                                    <td class="px-6 py-4 border-b dark:border-gray-600">
                                        {{ \Carbon\Carbon::parse($appointment->appointment_date)->format('F j, Y') }}
                                    </td>
                                    <td class="px-6 py-4 border-b dark:border-gray-600">
                                        {{ \Carbon\Carbon::parse($appointment->appointment_date)->format('h:i A') }}
                                    </td>
                                    <td class="px-6 py-4 border-b dark:border-gray-600">Dr. {{ $appointment->doctor->clinic_staff_fname }} {{ $appointment->doctor->clinic_staff_lname }}</td>
                                    <td class="px-6 py-4 border-b dark:border-gray-600">
                                        <span class="px-3 py-1 text-xs font-semibold rounded-xl
                                            {{ $appointment->status == 'pending' ? 'bg-yellow-200 text-yellow-700' : '' }}
                                            {{ $appointment->status == 'approved' ? 'bg-green-200 text-green-700' : '' }}
                                            {{ $appointment->status == 'declined' ? 'bg-red-200 text-red-700' : '' }}
                                            {{ $appointment->status == 'cancelled' ? 'bg-gray-200 text-gray-700' : '' }}
                                            {{ $appointment->status == 'completed' ? 'bg-blue-200 text-blue-700' : '' }}">
                                            {{ ucfirst($appointment->status) }}
                                        </span>
                                    </td>
                                    <td class="px-6 py-4 border-b dark:border-gray-600">
                                        @if ($appointment->status == 'pending' || $appointment->status == 'approved')
                                            <button class="text-blue-500 text-sm underline" wire:click.stop="confirmCancel('{{ $appointment->id }}')">
                                                Cancel Appointment
                                            </button>
                                        @else
                                            <span class="text-gray-500 text-sm">Not Available</span>
                                        @endif
                                    </td>
                                </tr>

                                @if ($expandedRow === $appointment->id)
                                    <tr class="bg-gray-50">
                                        <td colspan="7" class="px-6 py-4 border-b">
                                            <div class="flex flex-row gap-4">
                                                <div class="w-2/5 flex flex-col gap-3">
                                                    <div class="p-3 border border-gray-200 rounded-lg bg-white shadow-md transition-all duration-150 transform">
                                                        <p class="text-lg font-semibold mb-2">Reason for Visit:</p>    
                                                        <p class="text-sm text-gray-700">{{ $appointment->reason_for_visit }}</p>
                                                    </div>
                                                    <div class="p-3 border border-gray-200 rounded-lg bg-white shadow-md transition-all duration-150 transform">
                                                        <p class="text-lg font-semibold mb-2">Feedback:</p>
                                                        @if($appointment->status == 'completed')    
                                                            @if($appointment->consultationFeedback)
                                                                <p class="text-sm text-gray-700">You have already submitted feedback for this appointment. Thank you!</p>
                                                            @else
                                                            <p class="text-sm text-gray-700">Help us improve our services! Answering will only take around 1-2 minutes.</p>
                                                            <div class="flex justify-end mt-2">
                                                                <x-button class="px-3 py-1 text-sm" 
                                                                    wire:click="openFeedbackModal({{ $appointment->id }})">
                                                                    Submit Feedback
                                                                </x-button>
                                                            </div>
                                                            @endif
                                                        @else
                                                        <p class="text-sm text-gray-700">Feedback is only available for completed appointments.</p>
                                                        @endif
                                                    </div>
                                                </div>
                                                <div class="w-3/5">
                                                    <div class="p-3 border border-gray-200 rounded-lg bg-white shadow-md transition-all duration-150 transform">
                                                        <p class="text-lg font-semibold mb-2">Medical Concerns:</p>    
                                                        @if($appointment->medicalRecord)
                                                            <div class="mt-2 text-sm text-gray-700 -indent-5 pl-5 break-all">
                                                                <p><strong>Reason for Visit (Category):</strong> {{ $appointment->medicalRecord->reason }}</p>
                                                                <p><strong>Description of Symptoms:</strong> {{ $appointment->medicalRecord->description }}</p>
                                                                <p><strong>Allergies:</strong> {{ $appointment->medicalRecord->allergies }}</p>
                                                            </div>
                                                        @else
                                                            <p class="text-sm text-gray-500 mt-2"><em>No medical concerns available yet.</em></p>
                                                        @endif
                                                        <p class="text-lg font-semibold my-2">Medical Findings:</p>    
                                                        @if($appointment->medicalRecord)
                                                            <div class="mt-2 text-sm text-gray-700 -indent-5 pl-5 break-all">
                                                                <p><strong>Physical Examination:</strong> 
                                                                    @forelse ($appointment->medicalRecord->physicalExaminations as $exam)
                                                                        <p>- {{ $exam->section }}: 
                                                                            {{ $exam->normal ? 'Normal' : 'Not Normal' }} 
                                                                            @if($exam->findings)
                                                                                (Findings: {{ $exam->findings }})
                                                                            @endif
                                                                        </p>
                                                                    @empty
                                                                        <p class="text-gray-500 italic">No physical exam records</p>
                                                                    @endforelse</p>
                                                                <p><strong>Diagnosis:</strong></p>
                                                                    @forelse ($appointment->medicalRecord->diagnoses as $diagnosis)
                                                                        <p>- {{ $diagnosis->diagnosis }} @if($diagnosis->diagnosis_notes) (Notes: {{ $diagnosis->diagnosis_notes }}) @endif</p>
                                                                    @empty
                                                                        <p class="text-gray-500 italic">No diagnoses available</p>
                                                                    @endforelse
                                                                <p><strong>Prescription:</strong> {{ $appointment->medicalRecord->prescription }}</p>
                                                            </div>
                                                        @else
                                                            <p class="text-sm text-gray-500 mt-2"><em>No medical findings available yet.</em></p>
                                                        @endif
                                                        @if($appointment->medicalRecord)
                                                            <div class="flex justify-end mt-2">
                                                                <x-button class="px-3 py-1 text-sm" 
                                                                    wire:click="downloadMedicalRecord({{ $appointment->id }})">
                                                                    Download Medical Record
                                                                </x-button>
                                                            </div>
                                                        @endif
                                                    </div>
                                                </div>
                                            </div>
                                        </td>
                                    </tr>
                                @endif
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>

    <!-- Modals -->
     @if($showCancelModal)
        <div class="fixed inset-0 bg-gray-500 bg-opacity-50 flex justify-center items-center z-50">
            <div class="bg-white p-6 rounded-lg shadow-lg max-w-sm">
                <h3 class="text-2xl font-bold pb-3 text-center">Cancel Appointment</h3>
                <p class="text-center">Please enter a <span class="text-red-500"><strong>reason</strong></span> for cancelling this appointment.</p>
                <textarea wire:model.defer="cancelReason" class="w-full p-2 border rounded mt-3" placeholder="Enter reason here..."></textarea>
                
                <div class="mt-4 flex justify-end gap-2">
                    <x-button 
                    wire:click="cancelAppointment"
                    x-bind:disabled="!$wire.cancelReason"
                    x-bind:class="!$wire.cancelReason ? 'opacity-50 cursor-not-allowed' : ''">
                        Confirm
                    </x-button>
                    <button wire:click="$set('showCancelModal', false)" class="px-4 py-2 rounded">
                        Cancel
                    </button>
                </div>
            </div>
        </div>
    @endif

    @if($showCancelSuccessModal)
        <div class="fixed inset-0 bg-gray-500 bg-opacity-50 flex justify-center items-center z-50">
            <div class="bg-white p-6 rounded-lg shadow-lg max-w-sm">
                <h3 class="text-3xl font-bold pb-3 text-center">Appointment Cancelled</h3>
                <p class="text-center">An <span class="text-red-500"><strong>email notification</strong></span> has been sent to the you and the clinic staff.</p>
                <div class="mt-4 flex justify-end gap-2">
                    <x-button wire:click="$set('showCancelSuccessModal', false)">OK</x-button>
                </div>
            </div>
        </div>
    @endif

    @if($showFeedbackModal)
        <div class="fixed inset-0 bg-gray-500 bg-opacity-50 flex justify-center items-center z-50">
            <div class="bg-white p-6 rounded-lg shadow-lg max-w-lg w-full">
                <h3 class="text-2xl font-bold pb-3 text-center">Submit Feedback</h3>
                <!-- <textarea wire:model.defer="feedbackText" class="w-full p-2 border rounded mt-3" placeholder="Enter your feedback here..."></textarea> -->
                <p class="mt-3">1. How would you rate your overall consultation experience?</p>
                    <div class="flex justify-center space-x-1 mt-2">
                        @for($i = 1; $i <= 5; $i++)
                            <svg wire:click="setRating({{ $i }})"
                                xmlns="http://www.w3.org/2000/svg" 
                                viewBox="0 0 24 24" 
                                class="w-7 h-7 cursor-pointer transition-transform transform hover:scale-110 
                                    {{ $rating >= $i ? 'text-yellow-400 fill-current' : 'text-gray-300' }}">
                                <path d="M12 17.27L18.18 21l-1.64-7.03L22 9.24l-7.19-.61L12 2 9.19 
                                        8.63 2 9.24l5.46 4.73L5.82 21z"/>
                            </svg>
                        @endfor
                    </div>
                <p class="mt-3">3. What areas do you think we could improve?</p>
                    <textarea wire:model.defer="consultationFeedback" class="w-full p-2 border rounded mt-3 mb-3" placeholder="Enter your feedback here..."></textarea>
                </p>
                <x-button wire:click="closeFeedbackModal" class="mt-3 px-3 py-1 text-sm">
                    Cancel
                </x-button>
                <x-button wire:click="submitConsultationFeedback" class="mt-3 px-3 py-1 text-sm">
                    Submit
                </x-button>
            </div>
        </div>
    @endif

</div>
