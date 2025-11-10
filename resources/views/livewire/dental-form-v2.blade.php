<div class="pb-5 flex gap-3">
    <div class="w-1/4 bg-white rounded-md shadow-md mt-5 p-6">
        <div class="flex align-items-center gap-2">
            <i class="material-icons text-light-blue-1">info_outline</i>
            <h2 class="font-bold">Patient Information</h2>
        </div>
        <hr class="my-3"/>
        <div class="text-sm">
            <p><span class="font-semibold">ID Number: </span>{{ $patient_info['id'] }}</p>
            <p><span class="font-semibold">Name: </span>{{ $patient_info['full_name'] }}</p>
            <p><span class="font-semibold">Gender: </span>{{ $patient_info['gender'] }}</p>
            <p><span class="font-semibold">Date of Birth: </span>{{ $patient_info['dob'] }}</p>
            <p><span class="font-semibold">Age: </span>{{ $patient_info['age'] }}</p>
            <br>
            <p><span class="font-semibold">Nationality: </span>{{ $patient_info['nationality'] }}</p>
            <p><span class="font-semibold">Blood Type: </span>{{ $patient_info['blood_type'] }}</p>
            <p><span class="font-semibold">Civil Status: </span>{{ $patient_info['civil_status'] }}</p>
            <p><span class="font-semibold">Religion: </span>{{ $patient_info['religion'] }}</p>
            <br>
            <p><span class="font-semibold">Contact Number: </span>{{ $patient_info['contact_number'] }}</p>
            <p><span class="font-semibold">Email Address: </span>{{ $patient_info['email'] }}</p>
            <p><span class="font-semibold">House/Unit No.: </span>{{ $patient_info['house_no'] }}</p>
            <p><span class="font-semibold">Street: </span>{{ $patient_info['street'] }}</p>
            <p><span class="font-semibold">Barangay: </span>{{ $patient_info['barangay'] }}</p>
            <p><span class="font-semibold">City/Municipality: </span>{{ $patient_info['city'] }}</p>
            <p><span class="font-semibold">Province: </span>{{ $patient_info['province'] }}</p>
            <p><span class="font-semibold">ZIP Code: </span>{{ $patient_info['zip_code'] }}</p>
            <p><span class="font-semibold">Country: </span>{{ $patient_info['country'] }}</p>
            <br>
            <p><span class="font-semibold">Emergency Contact Name: </span>{{ $patient_info['emergency_name'] }}</p>
            <p><span class="font-semibold">Emergency Contact Number: </span>{{ $patient_info['emergency_number'] }}</p>
            <p><span class="font-semibold">Relationship to Patient: </span>{{ $patient_info['emergency_relationship'] }}</p>
        </div>
    </div>

    <div class="w-3/4 mx-auto mt-5 bg-white rounded-md shadow-md p-8">
        <!-- Progress bar -->
        <div class="relative mb-5 flex justify-center">
            <ol class="relative z-10 flex w-[80%] justify-center">
                @php
                    $steps = [
                        1 => 'Intraoral Exam',
                        2 => 'Procedures',
                        3 => 'Dental Chart',
                        4 => 'Recommendation',
                    ];
                @endphp

                @foreach ($steps as $index => $label)
                    <li class="flex flex-col items-center text-center w-1/5">
                        <div class="flex items-center justify-center w-10 h-10 rounded-full border-2 
                            {{ $step >= $index ? 'bg-light-blue-1 border-blue-500 text-white' : 'bg-white border-gray-300 text-gray-500' }}
                            transition-all duration-300">
                            {{ $index }}
                        </div>
                        <span class="mt-2 text-sm {{ $step >= $index ? 'text-blue-600 font-semibold' : 'text-gray-500' }}">
                            {{ $label }}
                        </span>
                    </li>
                @endforeach
            </ol>
        </div>

        <form wire:submit.prevent="save">
        <!-- Navigation buttons -->
        <div class="flex justify-between mb-5">
            @if ($step > 1)
                <button type="button" wire:click="previousStep"
                    class="bg-gray-200 text-gray-700 px-4 py-2 rounded-md hover:bg-gray-300 transition">
                    Previous
                </button>
            @endif
            @if ($step < 4)
                <button type="button" wire:click="nextStep"
                    class="ml-auto bg-blue-500 text-white px-4 py-2 rounded-md hover:bg-blue-600 transition">
                    Next
                </button>
            @else
                <button type="submit"
                    class="ml-auto bg-green-500 text-white px-4 py-2 rounded-md hover:bg-green-600 transition"
                    wire:loading.attr="disabled">
                    <span wire:loading.remove>Save Record</span>
                    <span wire:loading>Saving...</span>
                </button>
            @endif
        </div>
        
        <!-- Step Content -->
        
        @if($step == 1)
            <div>
                <h2 class="font-bold mb-4">Intraoral Examination</h2>
                <div class="py-4">
                    <div class="grid grid-cols-2 gap-6">
                        <div>
                            <h3 class="text-md font-semibold mb-3">Oral Hygiene</h3>
                            <div class="space-y-2 text-sm">
                                <label class="block text-sm font-medium text-gray-700">Plaque Level:</label>
                                <select wire:model="oral_hygiene.plaque_level" class="border-gray-300 rounded-md text-sm focus:ring focus:ring-blue-200 focus:ring-opacity-50" required>
                                    <option value="">Select</option>
                                    <option value="Good">Good</option>
                                    <option value="Fair">Fair</option>
                                    <option value="Poor">Poor</option>
                                </select>
                                @error('oral_hygiene.plaque_level') <span class="text-red-600 text-sm">{{ $message }}</span> @enderror
                            </div>
                        </div>
                        <div>
                            <h3 class="text-md font-semibold mb-3">Gingival Color</h3>
                            <div class="space-y-3 text-sm">
                                <label class="block text-sm font-medium text-gray-700">Select Color:</label>
                                <div class="flex gap-3" required>
                                    @foreach (['Pale Pink', 'Red', 'Bluish', 'Inflamed'] as $color)
                                        <button 
                                            type="button"
                                            wire:click="$set('gingival_color', '{{ $color }}')"
                                            class="px-4 py-2 border rounded-md text-sm font-medium transition
                                            {{ $gingival_color === $color 
                                                ? 'bg-blue-500 text-white border-blue-500' 
                                                : 'bg-white text-gray-700 border-gray-300 hover:bg-gray-100' }}">
                                            {{ $color }}
                                        </button>
                                    @endforeach
                                </div>
                                @error('gingival_color') <span class="text-red-600 text-sm">{{ $message }}</span> @enderror
                            </div>
                        </div>
                    </div>
                <label class="block text-sm font-medium text-gray-700 mt-4">Remarks:</label>
                <textarea wire:model="oral_hygiene.remarks" rows="2"
                    class="text-gray-700 text-sm mt-1 w-full border-gray-300 rounded-md focus:border-blue-500 focus:ring focus:ring-blue-200 focus:ring-opacity-50"
                    placeholder="Add any remarks here..."></textarea>
                </div>
            </div>
        @elseif($step == 2)
            <div>
                <h3 class="font-semibold mb-4">Procedures</h3>
                <div class="space-y-3 text-sm">
                    <label class="block text-sm font-medium text-gray-700 pt-2">Select Procedure:</label>
                    <div class="grid grid-cols-2 gap-3">
                        @foreach (['Tooth Extraction', 'Oral Prophylaxis', 'Temporary Filling', 'Denture Adjustment and Repair'] as $procedure)
                            <label class="flex items-center space-x-2">
                                <input type="checkbox" wire:model="procedures" value="{{ $procedure }}" class="text-blue-600 border-gray-300 rounded focus:ring-blue-500">
                                <span>{{ $procedure }}</span>
                            </label>
                        @endforeach
                    </div>
                    <div class="mt-2 text-sm text-gray-600 italic">
                        <p>* Tick all applicable procedures</p>
                    </div>
                    <div class="pt-2">
                        <label class="block text-sm font-medium text-gray-700">Notes:</label>
                        <textarea wire:model="procedure_notes" rows="2"
                            class="text-gray-700 text-sm mt-1 w-full border-gray-300 rounded-md focus:border-blue-500 focus:ring focus:ring-blue-200 focus:ring-opacity-50"
                            placeholder="Add notes for selected procedure(s)..."></textarea>
                    </div>
                </div>
            </div>

        @elseif($step == 3)
            <!-- Dental Chart -->
            <div class="mb-6">
                <h2 class="font-bold mb-4">Dental Number Chart</h2>
                <!-- Upper Teeth -->
                <div class="flex justify-center space-x-3 text-sm">
                    @foreach($leftLabels as $idx => $label)
                        <button type="button" wire:click="openModal('upper', {{ $idx }})"
                            class="w-10 h-10 rounded-full border border-gray-400 transition-colors duration-300
                                {{ $teeth['upper'][$idx] ? $toothColors[$teeth['upper'][$idx]] : 'bg-white hover:bg-gray-200' }}"
                            title="Upper Left {{ $label }}">
                            {{ $label }}
                        </button>
                    @endforeach
                    <div class="w-8 flex items-center justify-center text-sm"><div class="h-8 border-l-2 border-gray-700"></div></div>
                    @foreach($rightLabels as $idx => $label)
                        @php $pos = $idx + count($leftLabels); @endphp
                        <button type="button" wire:click="openModal('upper', {{ $pos }})"
                            class="w-10 h-10 rounded-full border border-gray-400 transition-colors duration-300
                                {{ $teeth['upper'][$pos] ? $toothColors[$teeth['upper'][$pos]] : 'bg-white hover:bg-gray-200' }}"
                            title="Upper Right {{ $label }}">
                            {{ $label }}
                        </button>
                    @endforeach
                </div>
                <!-- Lower Teeth -->
                <div class="flex justify-center space-x-3 mt-3 text-sm">
                    @foreach($leftLabels as $idx => $label)
                        <button type="button" wire:click="openModal('lower', {{ $idx }})"
                            class="w-10 h-10 rounded-full border border-gray-400 transition-colors duration-300
                                {{ $teeth['lower'][$idx] ? $toothColors[$teeth['lower'][$idx]] : 'bg-white hover:bg-gray-200' }}"
                            title="Lower Left {{ $label }}">
                            {{ $label }}
                        </button>
                    @endforeach
                    <div class="w-8 flex items-center justify-center text-sm"><div class="h-8 border-l-2 border-gray-700"></div></div>
                    @foreach($rightLabels as $idx => $label)
                        @php $pos = $idx + count($leftLabels); @endphp
                        <button type="button" wire:click="openModal('lower', {{ $pos }})"
                            class="w-10 h-10 rounded-full border border-gray-400 transition-colors duration-300
                                {{ $teeth['lower'][$pos] ? $toothColors[$teeth['lower'][$pos]] : 'bg-white hover:bg-gray-200' }}"
                            title="Lower Right {{ $label }}">
                            {{ $label }}
                        </button>
                    @endforeach
                </div>

                <!-- Legends -->
                <div class="mt-4 text-sm text-gray-600">
                    <p class="italic">* Click on a tooth to set its condition.</p>

                    <h3 class="font-semibold mt-3 mb-1">Legend:</h3>

                    <div class="grid grid-cols-2 gap-4">
                        <div>
                            <p>
                                C = Caries <br>
                                M = Missing <br>
                                E = Extraction
                            </p>
                        </div>
                        <div>
                            <p>
                                LC = Lesion/Cavity <br>
                                CR = Crown <br>
                                UE = Unerupted
                            </p>
                        </div>
                    </div>
                </div>
            </div>
        @elseif($step == 4)
            <!-- Recommendation -->
            <div class="mb-6">
                <h2 class="font-bold mb-4">Recommendation</h2>
                <textarea wire:model="recommendation" class="w-full border p-2 rounded text-sm" placeholder="Overall recommendation if there are any..."></textarea>
            </div>
        @endif

        <!-- Pop-up Modal -->
        @if($showModal)
            <div class="fixed inset-0 bg-black bg-opacity-40 flex items-center justify-center z-50" wire:click="closeModal">
                <div class="bg-white rounded p-6 w-96" wire:click.stop>
                    <h3 class="font-semibold mb-4">Tooth {{ $selectedToothLabel }}</h3>
                    <div class="grid grid-cols-3 gap-2">
                        @foreach(['C','M','E','LC','CR','UE'] as $status)
                            <button type="button" wire:click="selectToothCondition('{{ $status }}')"
                                class="py-2 px-3 rounded {{ ($teeth[$selectedJaw][$selectedIndex] ?? null) === $status ? 'ring-2' : '' }} {{ $toothColors[$status] }}">
                                {{ $status }}
                            </button>
                        @endforeach
                    </div>
                    <div class="flex justify-end mt-4">
                        <button type="button" wire:click="closeModal" class="px-4 py-2 bg-gray-300 rounded">Close</button>
                    </div>
                </div>
            </div>
        @endif
        </form>
        <!-- Success Modal -->
        @if (session()->has('success'))
            <div 
                x-data="{ show: true }" 
                x-init="setTimeout(() => show = false, 5000)" 
                x-show="show" 
                x-transition
                class="fixed inset-0 flex items-center justify-center z-50"
            >
                <!-- Background overlay -->
                <div class="fixed inset-0 bg-black bg-opacity-50"></div>

                <!-- Green message box -->
                <div class="bg-green-500 text-white p-3 rounded shadow z-50">
                    {{ session('success') }}
                </div>
            </div>
        @endif
    </div>
</div>


