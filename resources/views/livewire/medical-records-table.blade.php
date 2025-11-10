<div 
    class="p-6 bg-white overflow-hidden shadow-xl sm:rounded-2xl mt-6 border border-gray-200"
    x-data="{ showModal: false }"
>
    <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4 pb-5">
        <input 
            type="text" 
            wire:model.live="apc_id_number" 
            placeholder="Search by APC ID or name..."
            class="flex-1 px-5 py-3 border border-gray-300 rounded-xl shadow-sm focus:ring-2 focus:ring-prims-azure-400 focus:border-prims-azure-400 placeholder-gray-400 text-base transition w-full sm:w-1/3"
        />

        <button 
            @click="showModal = true"
            id="openRecordModal"
            class="px-6 py-3 bg-prims-azure-500 text-white font-medium rounded-xl shadow-md hover:bg-prims-azure-600 hover:shadow-lg active:scale-95 transition-all duration-200 ease-out"
        >
            + Add Record
        </button>
    </div>

    <div class="overflow-x-auto bg-white border border-gray-200 rounded-xl shadow-md" x-data>
        <table id="recordsTable" class="w-full divide-y divide-gray-200">
            <thead style="background-color: #F4BF4F;" class="text-gray-800">
                <tr>
                    <th class="px-6 py-3 text-left text-sm font-semibold tracking-wider uppercase">APC ID Number</th>
                    <th class="px-6 py-3 text-left text-sm font-semibold tracking-wider uppercase">Last Name</th>
                    <th class="px-6 py-3 text-left text-sm font-semibold tracking-wider uppercase">First Name</th>
                    <th class="px-6 py-3 text-center text-sm font-semibold tracking-wider uppercase">Middle Initial</th>
                    <th class="px-6 py-3 text-left text-sm font-semibold tracking-wider uppercase">Email</th>
                    <th class="px-6 py-3 text-left text-sm font-semibold tracking-wider uppercase">Last Visited</th>
                    <th class="px-6 py-3 text-left text-sm font-semibold tracking-wider uppercase">Actions</th>
                </tr>
            </thead>

            <tbody class="bg-white divide-y divide-gray-100">
                @if ($apc_id_number)
                    @if($records->isEmpty())
                        <tr x-transition>
                            <td colspan="7" class="px-6 py-5 text-center text-gray-500 italic">
                                No records found for "<strong>{{ $apc_id_number }}</strong>".
                            </td>
                        </tr>
                    @else
                        @foreach($records as $patient)
                            {{-- ANIMATION: Simple fade in for new search results --}}
                            <tr class="hover:bg-gray-50 transition-colors duration-150" 
                                x-transition:enter="transition ease-out duration-300" x-transition:enter-start="opacity-0" x-transition:enter-end="opacity-100"
                            >
                                <td class="px-6 py-3 text-gray-800">{{ $patient->apc_id_number }}</td>
                                <td class="px-6 py-3 text-gray-800">{{ $patient->last_name }}</td>
                                <td class="px-6 py-3 text-gray-800">{{ $patient->first_name }}</td>
                                <td class="px-6 py-3 text-gray-800 text-center">{{ $patient->middle_initial }}</td>
                                <td class="px-6 py-3 text-gray-700">{{ $patient->email }}</td>
                                <td class="px-6 py-3 text-gray-700">
                                    {{ optional($patient->medicalRecords->last())->last_visited 
                                        ?? optional($patient->dentalRecords->last())->created_at 
                                        ?? '-' }}
                                </td>
                                <td class="px-6 py-3 text-center">
                                    <x-button 
                                        wire:click="toggleExpand({{ $patient->id }})" 
                                        class="px-4 py-1 flex items-center justify-center gap-1 bg-gray-100 hover:bg-gray-200 rounded-lg transition"
                                    >
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
                                {{-- ANIMATION: Smooth slide/fade for expanded details --}}
                                <tr class="bg-gray-50" 
                                    x-show="true" {{-- Necessary for Livewire's conditional rendering to trigger Alpine transition --}}
                                    x-transition:enter="transition ease-out duration-500" x-transition:enter-start="opacity-0 max-h-0" x-transition:enter-end="opacity-100 max-h-screen"
                                    x-transition:leave="transition ease-in duration-300"
                                    x-transition:leave-start="opacity-100 max-h-screen"
                                    x-transition:leave-end="opacity-0 max-h-0"
                                    style="overflow: hidden;" {{-- Hide overflow during height transition --}}
                                >
                                    <td colspan="7" class="px-6 py-5">
                                        <div class="flex flex-col items-center mb-6">
                                            <h3 class="text-lg font-semibold text-gray-800 mb-3">Medical Record(s)</h3>
                                            <table class="table-auto w-[85%] border border-gray-300 rounded-lg shadow-sm">
                                                <thead class="bg-gray-100">
                                                    <tr>
                                                        <th class="px-3 py-2 text-sm">Type</th>
                                                        <th class="px-3 py-2 text-sm">Date</th>
                                                        <th class="px-3 py-2 text-sm">Reason</th>
                                                        <th class="px-3 py-2 text-sm">Diagnosis</th>
                                                        <th class="px-3 py-2 text-sm"></th>
                                                    </tr>
                                                </thead>
                                                <tbody>
                                                    @forelse ($this->getPatientRecords($patient->id) as $med)
                                                        <tr class="hover:bg-gray-50">
                                                            <td class="text-center">
                                                                @if ($med->appointment_id)
                                                                    <span class="px-2 py-1 bg-green-100 text-green-700 rounded-full text-xs">Appointment</span>
                                                                @else
                                                                    <span class="px-2 py-1 bg-blue-100 text-blue-700 rounded-full text-xs">Walk-in</span>
                                                                @endif
                                                            </td>
                                                            <td class="text-center">{{ \Carbon\Carbon::parse($med->last_visited)->format('M j, Y') }}</td>
                                                            <td class="text-center">{{ $med->reason }}</td>
                                                            <td class="text-center">{{ $med->diagnoses->first()->diagnosis ?? '-' }}</td>
                                                            <td class="text-center">
                                                                <a href="{{ route('view-medical-record', $med->id) }}" class="text-blue-600 hover:underline">View</a>
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

                                        <div class="flex flex-col items-center">
                                            <h3 class="text-lg font-semibold text-gray-800 mb-3">Dental Record(s)</h3>
                                            <table class="table-auto w-[85%] border border-gray-300 rounded-lg shadow-sm">
                                                <thead class="bg-gray-100">
                                                    <tr>
                                                        <th class="px-3 py-2 text-sm">Type</th>
                                                        <th class="px-3 py-2 text-sm">Date</th>
                                                        <th class="px-3 py-2 text-sm">Recommendation</th>
                                                        <th class="px-3 py-2 text-sm"></th>
                                                    </tr>
                                                </thead>
                                                <tbody>
                                                    @forelse ($this->getPatientDentalRecords($patient->id) as $dent)
                                                        <tr class="hover:bg-gray-50">
                                                            <td class="text-center">
                                                                @if ($dent->appointment_id)
                                                                    <span class="px-2 py-1 bg-green-100 text-green-700 rounded-full text-xs">Appointment</span>
                                                                @else
                                                                    <span class="px-2 py-1 bg-blue-100 text-blue-700 rounded-full text-xs">Walk-in</span>
                                                                @endif
                                                            </td>
                                                            <td class="text-center">{{ \Carbon\Carbon::parse($dent->last_visited ?? $dent->created_at)->format('M j, Y') }}</td>
                                                            <td class="text-center text-gray-700">{{ \Illuminate\Support\Str::words($dent->recommendation ?? '-', 15, '...') }}</td>
                                                            <td class="text-center">
                                                                <a href="{{ route('view-dental-record', $dent->id) }}" class="text-blue-600 hover:underline">View</a>
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
                    @endif
                @else
                    <tr>
                        <td colspan="7" class="px-6 py-6 text-center text-gray-500 text-base italic">
                            Start typing to search for patient records.
                        </td>
                    </tr>
                @endif
            </tbody>
        </table>

        @if (!empty($apc_id_number) && !$records->isEmpty())
            <div class="p-4 border-t border-gray-100">
                {{ $records->links() }}
            </div>
        @endif
    </div>

    <div 
        x-show="showModal" 
        x-transition:enter="transition ease-out duration-300"
        x-transition:enter-start="opacity-0"
        x-transition:enter-end="opacity-100"
        x-transition:leave="transition ease-in duration-200"
        x-transition:leave-start="opacity-100"
        x-transition:leave-end="opacity-0"
        class="fixed inset-0 z-50 flex items-center justify-center bg-black bg-opacity-50"
    >
        <div 
            @click.away="showModal = false"
            x-transition:enter="transition ease-out duration-300"
            x-transition:enter-start="opacity-0 scale-90"
            x-transition:enter-end="opacity-100 scale-100"
            x-transition:leave="transition ease-in duration-200"
            x-transition:leave-start="opacity-100 scale-100"
            x-transition:leave-end="opacity-0 scale-90"
            class="bg-white rounded-2xl shadow-xl w-full max-w-sm p-8 relative"
        >
            <button 
                @click="showModal = false"
                class="absolute top-3 right-4 text-gray-400 text-3xl font-light hover:text-gray-700 transition"
            >
                &times;
            </button>
            <h2 class="text-2xl font-bold text-gray-800 mb-6 text-center">Select Record Type</h2>
            
            <div class="flex flex-col gap-4">
                <button 
                    id="medicalRecordBtn"
                    class="w-full px-6 py-3 bg-blue-600 text-white font-semibold rounded-xl shadow-md hover:bg-blue-700 transition-all duration-200"
                >
                    🩺 Medical Record
                </button>
                <button 
                    id="dentalRecordBtn"
                    class="w-full px-6 py-3 bg-green-600 text-white font-semibold rounded-xl shadow-md hover:bg-green-700 transition-all duration-200"
                >
                    🦷 Dental Record
                </button>
            </div>
        </div>
    </div>
</div>

<script>
    document.addEventListener('DOMContentLoaded', () => {
        const medicalBtn = document.getElementById('medicalRecordBtn');
        const dentalBtn = document.getElementById('dentalRecordBtn');
        
        if (medicalBtn) {
            medicalBtn.addEventListener('click', () => {
                // Corrected route:
                window.location.href = '/staff/medformv2'; 
            });
        }

        if (dentalBtn) {
            dentalBtn.addEventListener('click', () => {
                // Corrected route:
                window.location.href = '/staff/dental-form-v2'; 
            });
        }
    });
</script>