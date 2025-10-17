<div class="p-6 bg-white dark:bg-gray-800 overflow-hidden shadow-lg sm:rounded-lg mt-5">
    <!-- Search bar -->
    <div class="flex gap-6 pb-5 justify-end">
        <input type="text" id="searchInput" wire:model.lazy="apc_id_number" wire:change="searchPatient" placeholder="Search records..." class="px-4 py-2 border rounded-lg w-1/3">

        <a href="/staff/add-record">
            <button id="addRecordButton" class="px-4 py-2 bg-prims-azure-500 text-white rounded-lg hover:bg-prims-azure-100">
                Add Record
            </button>
        </a>
    </div>

    <div class="overflow-x-auto bg-white shadow-md rounded-lg">
        <table id="recordsTable" class="w-full min-w-full divide-y divide-gray-200">
            <thead style="background-color: #F4BF4F;">
                <tr>
                    <th class="px-6 py-3 text-left text-sm uppercase tracking-wider">
                        APC ID Number
                    </th>
                    <th class="px-6 py-3 text-left text-sm uppercase tracking-wider">
                        Last Name
                    </th>
                    <th class="px-6 py-3 text-left text-sm uppercase tracking-wider">
                        First Name
                    </th>
                    <th class="px-6 py-3 text-center text-sm uppercase tracking-wider">
                        Middle Initial
                    </th>
                    <th class="px-6 py-3 text-left text-sm uppercase tracking-wider">
                        Email
                    </th>
                    <th class="px-6 py-3 text-left text-sm uppercase tracking-wider">
                        Last Visited
                    </th>
                    <th class="px-6 py-3 text-left text-sm uppercase tracking-wider">
                        Actions
                    </th>
                </tr>
            </thead>
            <tbody class="bg-white divide-y divide-gray-200">
                @foreach ($records as $patient)
                    <tr class="record-row">
                        <td class="px-6 py-3 text-left text-md">{{ $patient->apc_id_number }}</td>
                        <td class="px-6 py-3 text-left text-md">{{ $patient->last_name }}</td>
                        <td class="px-6 py-3 text-left text-md">{{ $patient->first_name }}</td>
                        <td class="px-6 py-3 text-left text-md text-center">{{ $patient->middle_initial }}</td>
                        <td class="px-6 py-3 text-left text-md">{{ $patient->email }}</td>
                        <td class="px-6 py-3 text-left text-md">
                            {{ optional($patient->medicalRecords->last())->last_visited 
                                ?? optional($patient->dentalRecords->last())->created_at 
                                ?? '-' }}
                        </td>
                        <td>
                            <x-button wire:click="toggleExpand({{ $patient->id }})" class="px-4 py-1 flex items-center gap-1">
                                @if ($expandedPatient === $patient->id)
                                    <span>Collapse</span>
                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 15l7-7 7 7" />
                                    </svg>
                                @else
                                    <span>Expand</span>
                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7" />
                                    </svg>
                                @endif
                            </x-button>
                        </td>
                    </tr>

                    @if ($expandedPatient === $patient->id)
                        <tr>
                            <td colspan="7">
                                <!-- Medical Records -->
                                <div class="flex justify-center mt-4 mb-2">
                                    <h3 class="text-lg font-semibold">Medical Record(s)</h3>
                                </div>
                                <div class="flex justify-center">
                                    <table class="table-auto w-[80%] rounded mb-4 border">
                                        <thead>
                                            <tr class="border border-gray-300 bg-gray-200">
                                                <th></th>
                                                <th>Date</th>
                                                <th>Reason</th>
                                                <th>Diagnosis</th>
                                                <th></th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @forelse ($this->getPatientRecords($patient->id) as $med)
                                                <tr>
                                                    <td class="text-center">
                                                        @if ($med->appointment_id)
                                                            <span class="px-2 bg-green-100 text-green-700 rounded-2xl text-xs">Appointment</span>
                                                        @else
                                                            <span class="px-2 bg-blue-100 text-blue-700 rounded-2xl text-xs">Walk-in</span>
                                                        @endif
                                                    </td>
                                                    <td class="text-center">{{ \Carbon\Carbon::parse($med->last_visited)->format('M j, Y') }}</td>
                                                    <td class="text-center">{{ $med->reason }}</td>
                                                    <td class="text-center">{{ $med->diagnoses->first()->diagnosis ?? '-' }}</td>
                                                    <td class="text-center">
                                                        <a href="{{ route('view-medical-record', $med->id) }}" class="text-blue-600">View</a>
                                                    </td>
                                                </tr>
                                            @empty
                                                <tr>
                                                    <td colspan="5" class="px-6 py-3 text-center text-sm text-gray-500">No medical records found.</td>
                                                </tr>
                                            @endforelse
                                        </tbody>
                                    </table>
                                </div>

                                <!-- Dental Records -->
                                <div class="flex justify-center mb-2">
                                    <h3 class="text-lg font-semibold">Dental Record(s)</h3>
                                </div>
                                <div class="flex justify-center mb-4">
                                    <table class="table-auto w-[80%] rounded mb-4 border">
                                        <thead>
                                            <tr class="border border-gray-300 bg-gray-200">
                                                <th></th>
                                                <th>Date</th>
                                                <th>Recommendation</th>
                                                <th></th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @forelse ($this->getPatientDentalRecords($patient->id) as $dent)
                                                <tr class="record-row">
                                                    <td class="text-center">
                                                        @if ($dent->appointment_id)
                                                            <span class="px-2 bg-green-100 text-green-700 rounded-2xl text-xs">Appointment</span>
                                                        @else
                                                            <span class="px-2 bg-blue-100 text-blue-700 rounded-2xl text-xs">Walk-in</span>
                                                        @endif
                                                    </td>
                                                    <td class="text-center">{{ \Carbon\Carbon::parse($dent->last_visited ?? $dent->created_at)->format('M j, Y') }}</td>
                                                    <td class="text-center">{{ \Illuminate\Support\Str::words($dent->recommendation ?? '-', 15, '...') }}</td>
                                                    <td class="text-center">
                                                        <a href="{{ route('view-dental-record', $dent->id) }}" class="text-blue-600">View</a>
                                                    </td>
                                                </tr>
                                            @empty
                                                <tr>
                                                    <td colspan="4" class="px-6 py-3 text-center text-sm text-gray-500">No dental records found.</td>
                                                </tr>
                                            @endforelse
                                        </tbody>
                                    </table>
                                </div>
                            </td>
                        </tr>
                    @endif
                @endforeach
            </tbody>
        </table>
    </div>

    <!-- Record Type Modal -->
    <div id="addrecordModal" class="hidden fixed inset-0 bg-black bg-opacity-50 flex items-center justify-center">
        <div class="bg-white rounded-lg p-6 w-80 relative">
            <button id="closeRecordModal" class="absolute top-5 right-6 text-gray-700">&times;</button>
            <h2 class="text-lg font-semibold mb-5">Select Record Type</h2>
            <div class="flex flex-col gap-3">
                <button id="medicalRecordBtn" class="px-4 py-2 bg-blue-500 text-white rounded-lg hover:bg-blue-600">
                    Medical Record
                </button>
                <button id="dentalRecordBtn" class="px-4 py-2 bg-green-500 text-white rounded-lg hover:bg-green-600">
                    Dental Record
                </button>
            </div>
        </div>
    </div>

</div>

<script>
    document.getElementById("searchInput").addEventListener("keyup", function () {
        let filter = this.value.toLowerCase();
        let rows = document.querySelectorAll(".record-row");

        rows.forEach(row => {
            let text = row.textContent.toLowerCase();
            row.style.display = text.includes(filter) ? "" : "none";
        });
    });
</script>

<script>
    document.addEventListener('DOMContentLoaded', function () {
        const modal = document.getElementById('addrecordModal');
        const closeBtn = document.getElementById('closeRecordModal');
        const addRecordBtn = document.getElementById('addRecordButton');

        addRecordBtn.addEventListener('click', function(e) {
            e.preventDefault(); 
            modal.classList.remove('hidden'); 
        });

        closeBtn.addEventListener('click', function() {
            modal.classList.add('hidden'); 
        });

        window.addEventListener('click', function(e) {
            if (e.target === modal) modal.classList.add('hidden');
        });

        // Detect which button is clicked
        const medicalBtn = document.getElementById('medicalRecordBtn');
        const dentalBtn = document.getElementById('dentalRecordBtn');

        medicalBtn.addEventListener('click', function() {
            window.location.href = '/staff/add-record';
        });

        dentalBtn.addEventListener('click', function() {
            window.location.href = '/staff/dental-form';
        });
    });
</script>
