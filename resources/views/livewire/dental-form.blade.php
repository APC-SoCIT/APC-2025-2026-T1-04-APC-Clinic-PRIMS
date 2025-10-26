<div class="pb-5">
    <div class="bg-white rounded-md shadow-md mt-5 p-6">

        <!-- Personal Information -->
        <div class="bg-prims-yellow-1 rounded-lg p-4">
            <h2 class="text-lg font-semibold">Personal Information</h2>
        </div>
        <form wire:submit.prevent="submit">
        <div class="grid grid-cols-4 gap-4 my-4">
            <div>
                <label class="text-lg">ID Number <span class="text-red-500 italic text-xs">* required</span></label>
                <input type="text" wire:model.lazy="apc_id_number" wire:change="searchPatient" wire:keydown.enter.prevent="searchPatient" class="border p-2 rounded w-full" placeholder="Enter an ID number" required>
            </div>
            <div>
                <label class="text-lg">First Name</label>
                <input type="text" wire:model="first_name" class="border p-2 rounded w-full bg-gray-200" readonly>
            </div>
            <div>
                <label class="text-lg">Middle Initial</label>
                <input type="text" wire:model="middle_initial" class="border p-2 rounded w-full bg-gray-200" readonly>
            </div>
            <div>
                <label class="text-lg">Last Name</label>
                <input type="text" wire:model="last_name" class="border p-2 rounded w-full bg-gray-200" readonly>
            </div>
            <div>
                <label class="text-lg">Gender</label>
                <input type="text" wire:model="gender" class="border p-2 rounded w-full col-span-2 bg-gray-200" readonly>
            </div>
            <div>
                <label class="text-lg">Age</label>
                <input type="text" wire:model="age" class="border p-2 rounded w-full col-span-2 bg-gray-200" readonly>
            </div>
            <div>
                <label class="text-lg">Date of Birth</label>
                <input type="text" wire:model="date_of_birth" class="border p-2 rounded w-full col-span-2 bg-gray-200" readonly>
            </div>
            <div>
                <label class="text-lg">Nationality</label>
                <input type="text" wire:model="nationality" class="border p-2 rounded w-full col-span-2 bg-gray-200" readonly>
            </div>
            <div>
                <label class="text-lg">Blood Type</label>
                <input type="text" wire:model="blood_type" class="border p-2 rounded w-full col-span-2 bg-gray-200" readonly>
            </div>
            <div>
                <label class="text-lg">Civil Status</label>
                <input type="text" wire:model="civil_status" class="border p-2 rounded w-full col-span-2 bg-gray-200" readonly>
            </div>
            <div>
                <label class="text-lg">Religion</label>
                <input type="text" wire:model="religion" class="border p-2 rounded w-full col-span-2 bg-gray-200" readonly>
            </div>
            <div>
                <label class="text-lg">Contact Number</label>
                <input type="text" wire:model="contact_number" class="border p-2 rounded w-full col-span-2 bg-gray-200" readonly>
            </div>
            <div>
                <label class="text-lg">Email Address</label>
                <input type="text" wire:model="email" class="border p-2 rounded w-full col-span-2 bg-gray-200" readonly>
            </div>
            <div>
                <label class="text-lg">House/Unit No.</label>
                <input type="text" wire:model="house_unit_number" class="border p-2 rounded w-full col-span-2 bg-gray-200" readonly>
            </div>
            <div>
                <label class="text-lg">Street</label>
                <input type="text" wire:model="street" class="border p-2 rounded w-full col-span-2 bg-gray-200" readonly>
            </div>
            <div>
                <label class="text-lg">Barangay</label>
                <input type="text" wire:model="barangay" class="border p-2 rounded w-full col-span-2 bg-gray-200" readonly>
            </div>
            <div>
                <label class="text-lg">City/Municipality</label>
                <input type="text" wire:model="city" class="border p-2 rounded w-full col-span-2 bg-gray-200" readonly>
            </div>        
            <div>
                <label class="text-lg">Province</label>
                <input type="text" wire:model="province" class="border p-2 rounded w-full col-span-2 bg-gray-200" readonly>
            </div>
            <div>
                <label class="text-lg">ZIP Code</label>
                <input type="text" wire:model="zip_code" class="border p-2 rounded w-full col-span-2 bg-gray-200" readonly>
            </div>
            <div>
                <label class="text-lg">Country</label>
                <input type="text" wire:model="country" class="border p-2 rounded w-full col-span-2 bg-gray-200" readonly>
            </div>
            <div>
                <label class="text-lg">Emergency Contact Name</label>
                <input type="text" wire:model="emergency_contact_name" class="border p-2 rounded w-full col-span-2 bg-gray-200" readonly>
            </div>
            <div>
                <label class="text-lg">Emergency Contact Number</label>
                <input type="text" wire:model="emergency_contact_number" class="border p-2 rounded w-full col-span-2 bg-gray-200" readonly>
            </div>
            <div>
                <label class="text-lg">Relationship to Patient</label>
                <input type="text" wire:model="emergency_contact_relationship" class="border p-2 rounded w-full col-span-2 bg-gray-200" readonly>
            </div>
        </div>

        <!-- Dental Examination -->
        <div class="bg-prims-yellow-1 rounded-lg p-4 mt-6">
            <h2 class="text-lg font-semibold">Dental Examination</h2>
        </div>

        <div class="mt-6 bg-gray-300 rounded-lg p-1 flex justify-center">
            <h3 class="text-md font-semibold">Intraoral Examination</h3>
        </div>

        <div class="ml-17 my-6 px-40 grid grid-cols-4">
            <!-- Oral Hygiene -->
            <label class="font-bold">Oral Hygiene :<span class="text-red-500 italic text-xs">* required</span></label> 
            <label>
                <input type="radio" wire:model="oral_hygiene" value="Good" required>
                <span class="">Good</span>
            </label>
            <label>
                <input type="radio" wire:model="oral_hygiene" value="Fair" required>
                <span class="text-align-center">Fair</span>
            </label>
            <label>
                <input type="radio" wire:model="oral_hygiene" value="Poor" required>
                <span class="text-align-center">Poor</span>
            </label>

            <!-- Gingival Color -->
            <label class="font-bold mt-4">Gingival Color :<span class="text-red-500 italic text-xs">* required</span></label>
            <label class="mt-4">
                <input type="radio" wire:model="gingival_color" value="Pink" required>
                <span class="">Pink</span>
            </label>
            <label class="mt-4">
                <input type="radio" wire:model="gingival_color" value="Pale" required>
                <span class="text-align-center">Pale</span>
            </label>
            <label class="mt-4">
                <input type="radio" wire:model="gingival_color" value="Bright Red" required>
                <span class="text-align-center">Bright Red</span>
            </label>
        </div>
        
        <div class="bg-gray-300 rounded-lg p-1 flex justify-center">
            <h3 class="text-md font-semibold">Procedures</h3>
        </div>
        <div class="my-6 justify-items-center">
            <div>
                <label>
                    <input type="checkbox" wire:model="prophylaxis" value="Oral Prophylaxis">
                    <span class="text-align-center font-bold ml-1">Oral Prophylaxis</span>
                </label>
            </div>
        </div>

        <div class="bg-gray-300 rounded-lg p-1 flex justify-center">
            <h3 class="text-md font-semibold">Dental Number Chart</h3>
        </div>

        <!-- Tooth Number Chart -->
        <div class="mt-4">
            <h3 class="flex justify-center text-md font-semibold m-5">Select Tooth Numbers</h3>

            <!-- Upper Teeth -->
            <div class="flex justify-center space-x-3">
                @foreach($leftLabels as $idx => $label)
                    <button
                        type="button"
                        wire:click="openModal('upper', {{ $idx }})"
                        class="w-10 h-10 rounded-full border border-gray-400 transition-colors duration-300
                            {{ $teeth['upper'][$idx] ? $toothColors[$teeth['upper'][$idx]] : 'bg-white hover:bg-gray-200' }}"
                        title="Upper Left {{ $label }} (pos {{ $idx }})"
                    >
                        {{ $label }}
                    </button>
                @endforeach

                <div class="w-8 flex items-center justify-center">
                    <div class="h-8 border-l-2 border-gray-700"></div>
                </div>

                @foreach($rightLabels as $idx => $label)
                    @php $pos = $idx + count($leftLabels); @endphp
                    <button
                        type="button"
                        wire:click="openModal('upper', {{ $pos }})"
                        class="w-10 h-10 rounded-full border border-gray-400 transition-colors duration-300
                            {{ $teeth['upper'][$pos] ? $toothColors[$teeth['upper'][$pos]] : 'bg-white hover:bg-gray-200' }}"
                        title="Upper Right {{ $label }} (pos {{ $pos }})"
                    >
                        {{ $label }}
                    </button>
                @endforeach
            </div>

            <!-- Lower Teeth -->
            <div class="flex justify-center space-x-3 mt-3">
                @foreach($leftLabels as $idx => $label)
                    <button
                        type="button"
                        wire:click="openModal('lower', {{ $idx }})"
                        class="w-10 h-10 rounded-full border border-gray-400 transition-colors duration-300
                            {{ $teeth['lower'][$idx] ? $toothColors[$teeth['lower'][$idx]] : 'bg-white hover:bg-gray-200' }}"
                        title="Lower Left {{ $label }} (pos {{ $idx }})"
                    >
                        {{ $label }}
                    </button>
                @endforeach

                <div class="w-8 flex items-center justify-center">
                    <div class="h-8 border-l-2 border-gray-700"></div>
                </div>

                @foreach($rightLabels as $idx => $label)
                    @php $pos = $idx + count($leftLabels); @endphp
                    <button
                        type="button"
                        wire:click="openModal('lower', {{ $pos }})"
                        class="w-10 h-10 rounded-full border border-gray-400 transition-colors duration-300
                            {{ $teeth['lower'][$pos] ? $toothColors[$teeth['lower'][$pos]] : 'bg-white hover:bg-gray-200' }}"
                        title="Lower Right {{ $label }} (pos {{ $pos }})"
                    >
                        {{ $label }}
                    </button>
                @endforeach
            </div>
        </div>

        <!-- Pop-up Modal -->
        @if($showModal)
            <div id="dentalModalBackdrop" class="fixed inset-0 bg-black bg-opacity-40 flex items-center justify-center z-50" onclick="@this.closeModalWithSave()"> <!-- click anywhere on backdrop -->
    <div id="dentalModal" class="bg-white rounded-lg shadow-lg p-6 w-96" onclick="event.stopPropagation()"> <!-- stops clicks inside modal from closing -->
                    <h3 class="text-lg font-semibold mb-4 text-gray-800">
                        Tooth 
                        <span>
                            {{ $this->getSelectedToothLabel() }}
                        </span>
                    </h3>

                    <div class="grid grid-cols-3 gap-3">
                        @php
                            $statusLabels = [
                                'C'  => 'Caries',
                                'M'  => 'Missing',
                                'E'  => 'Extraction',
                                'LC' => 'Lesion/Cavity',
                                'CR' => 'Crown',
                                'UE' => 'Unerupted',
                            ];
                            $statuses = ['C','M','E','LC','CR','UE'];
                        @endphp

                        @foreach($statuses as $status)
                            @php
                                $isActive = ($selectedJaw && $selectedIndex !== null)
                                    && ($teeth[$selectedJaw][$selectedIndex] === $status);
                                $baseClass = $toothColors[$status] ?? 'bg-gray-200 text-gray-800';
                            @endphp

                            <button
                                type="button"
                                wire:click="selectToothCondition('{{ $status }}')"
                                class="py-2 px-3 rounded shadow-sm transition transform duration-150
                                    {{ $isActive ? 'scale-105 ring-2 ring-offset-1' : '' }}
                                    {{ $baseClass }}"
                                    title="@switch($status)
                                            @case('C') Caries @break
                                            @case('M') Missing @break
                                            @case('E') Extraction @break
                                            @case('LC') Lesion/Cavity @break
                                            @case('CR') Crown @break
                                            @case('UE') Unerupted @break
                                        @endswitch"
                            >
                                {{ $status }}
                            </button>
                        @endforeach
                    </div>

                    <div class="flex justify-end mt-5">
                        <button
                            type="button"
                            wire:click="closeModal"
                            class="px-4 py-2 bg-gray-300 rounded hover:bg-gray-400 transition-colors duration-200">
                            Close
                        </button>
                    </div>
                </div>
            </div>
        @endif

        <div class="mt-6 mb-4 bg-gray-300 rounded-lg p-1 flex justify-center">
            <h3 class="text-md font-semibold">Recommendation</h3>
        </div>
        <textarea wire:model="recommendation" class="w-full border p-2 rounded mb-1" placeholder="Recommendation..."></textarea>

        <!-- Submit -->
        <div class="mt-6 flex justify-end">
            <a href="/staff/medical-records" class="text-prims-azure-500 text-md m-2 mx-6 underline hover:text-prims-yellow-1 transition ease-in-out duration-150"> Back </a>
            <button type="submit"
                class="px-4 py-2 bg-prims-azure-500 text-white rounded-lg hover:bg-prims-azure-100">
                Submit
            </button>
        </div>
        </form>
    </div>
    @if ($showErrorModal)
        <div class="fixed inset-0 flex items-center justify-center bg-black bg-opacity-50 z-50">
            <div class="bg-white rounded-xl shadow-lg p-6 w-96">
                <h2 class="text-lg font-semibold text-red-600">Error</h2>
                <p class="mt-2 text-gray-700">{!! $errorMessage !!}</p>

                <div class="mt-4 flex justify-end">
                    <button 
                        wire:click="$set('showErrorModal', false)" 
                        class="px-4 py-2 bg-red-600 text-white rounded-md hover:bg-red-700"
                    >
                        Close
                    </button>
                </div>
            </div>
        </div>
    @endif
</div>