<<<<<<< HEAD
<<<<<<< HEAD
<div class="pb-5">
    <div class="bg-white rounded-md shadow-md mt-5 p-6">

    
=======
=======
<div class="pb-5">
    <div class="bg-white rounded-md shadow-md mt-5 p-6">

    @if($statusMessage)
        <div class="mb-4 rounded-md bg-green-50 border border-green-200 p-3 text-green-800">
            {{ $statusMessage }}
        </div>
    @endif

    @if(session()->has('success'))
        <div class="mb-4 rounded-md bg-green-50 border border-green-200 p-3 text-green-800">
            {{ session('success') }}
        </div>
    @endif
>>>>>>> 295b19a (updated ui)

        <!-- Personal Information -->
        <div class="bg-prims-yellow-1 rounded-lg p-4">
            <h2 class="text-lg font-semibold">Personal Information</h2>
        </div>
        <form wire:submit.prevent="submit">
        <div class="grid grid-cols-4 gap-4 my-4">
            <div>
                <label class="text-lg">ID Number</label>
                <input type="text" wire:model.lazy="apc_id_number" wire:change="searchPatient" class="border p-2 rounded w-full" placeholder="Enter an ID number">
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
            <label class="font-bold">Oral Hygiene :</label>
            <label>
                <input type="radio" name="oral_hygiene" value="Good">
                <span class="">Good</span>
            </label>
            <label>
                <input type="radio" name="oral_hygiene" value="Fair">
                <span class="text-align-center">Fair</span>
            </label>
            <label>
                <input type="radio" name="oral_hygiene" value="Poor">
                <span class="text-align-center">Poor</span>
            </label>

            <!-- Gingival Color -->
            <label class="font-bold mt-4">Gingival Color :</label>
            <label class="mt-4">
                <input type="radio" name="gingival_color" value="Pink">
                <span class="">Pink</span>
            </label>
            <label class="mt-4">
                <input type="radio" name="gingival_color" value="Pale">
                <span class="text-align-center">Pale</span>
            </label>
            <label class="mt-4">
                <input type="radio" name="gingival_color" value="Bright Red">
                <span class="text-align-center">Bright Red</span>
            </label>
        </div>
        
        <div class="bg-gray-300 rounded-lg p-1 flex justify-center">
            <h3 class="text-md font-semibold">Procedures</h3>
        </div>
        <div class="my-6 justify-items-center">
            <div>
                <label>
                    <input type="checkbox" name="gingival_color" value="Oral Prophylaxis">
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
                            @if($teeth['upper'][$idx]) bg-blue-600 text-white @else bg-white hover:bg-gray-200 @endif"
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
                            @if($teeth['upper'][$pos]) bg-blue-600 text-white @else bg-white hover:bg-gray-200 @endif"
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
                            @if($teeth['lower'][$idx]) bg-green-600 text-white @else bg-white hover:bg-gray-200 @endif"
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
                            @if($teeth['lower'][$pos]) bg-green-600 text-white @else bg-white hover:bg-gray-200 @endif"
                        title="Lower Right {{ $label }} (pos {{ $pos }})"
                    >
                        {{ $label }}
                    </button>
                @endforeach
            </div>
        </div>

        <!-- Pop-up Modal -->
        @if($showModal)
            <div class="fixed inset-0 bg-black bg-opacity-40 flex items-center justify-center z-50 transition-opacity duration-200">
                <div class="bg-white rounded-lg shadow-lg p-6 w-96 transform transition-transform duration-300 scale-100">
                    <h3 class="text-lg font-semibold mb-4 text-gray-800">
                        Tooth
                        <span class="text-blue-600">
                            @if($selectedJaw === 'upper')
                                {{ ($upper[$selectedIndex] ?? $selectedIndex) }}
                            @else
                                {{ ($lower[$selectedIndex] ?? $selectedIndex) }}
                            @endif
                        </span>
                        ({{ ucfirst($selectedJaw) }})
                    </h3>

                    <div class="grid grid-cols-3 gap-3">
                        @php
                            $colors = [
                                'C'  => 'bg-red-500 hover:bg-red-600 text-white',
                                'M'  => 'bg-gray-500 hover:bg-gray-600 text-white',
                                'E'  => 'bg-yellow-500 hover:bg-yellow-600 text-white',
                                'LC' => 'bg-orange-500 hover:bg-orange-600 text-white',
                                'CR' => 'bg-purple-500 hover:bg-purple-600 text-white',
                                'UE' => 'bg-blue-500 hover:bg-blue-600 text-white',
                            ];
                            $statuses = ['C','M','E','LC','CR','UE'];
                        @endphp

                        @foreach($statuses as $status)
                            @php
                                $isActive = ($selectedJaw && $selectedIndex !== null)
                                    && ($teeth[$selectedJaw][$selectedIndex] === $status);
                                $baseClass = $colors[$status] ?? 'bg-gray-200 text-gray-800';
                            @endphp

                            <button
                                wire:click="selectToothCondition('{{ $status }}')"
                                class="py-2 px-3 rounded shadow-sm transition transform duration-150
                                    {{ $isActive ? 'scale-105 ring-2 ring-offset-1' : '' }}
                                    {{ $baseClass }}"
                            >
                                {{ $status }}
                            </button>
                        @endforeach
                    </div>

                    <div class="flex justify-end mt-5">
                        <button wire:click="closeModal"
                                class="px-4 py-2 bg-gray-300 rounded hover:bg-gray-400 transition-colors duration-200">
                            Close
                        </button>
                    </div>
                </div>
            </div>
        @endif

<<<<<<< HEAD
        <div class="mt-6 mb-4 bg-gray-300 rounded-lg p-1 flex justify-center">
            <h3 class="text-md font-semibold">Recommendation</h3>
        </div>
        <textarea wire:model="recommendation" class="w-full border p-2 rounded mb-1" placeholder="Recommendation..."></textarea>
=======

>>>>>>> 295b19a (updated ui)

        <!-- Submit -->
        <div class="mt-6 flex justify-end">
            <button type="submit"
                class="px-4 py-2 bg-prims-azure-500 text-white rounded-lg hover:bg-prims-azure-100">
                Submit
            </button>
        </div>
        </form>
    </div>
</div>
<<<<<<< HEAD
=======
>>>>>>> 59521b7 (dental form)
=======
>>>>>>> a16af49 (updated ui)
>>>>>>> 295b19a (updated ui)
