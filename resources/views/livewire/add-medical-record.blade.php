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
                <input type="text" wire:model.lazy="apc_id_number" wire:change="searchPatient" class="border p-2 rounded w-full" placeholder="Enter an ID number" required>
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

        <!-- Medical Concern -->
        <div class="mt-6 bg-prims-yellow-1 rounded-lg p-4">
            <h2 class="text-lg font-semibold">Medical Concern</h2>
        </div>

        <div class="mt-6">
            <label class="block text-lg font-medium">Reason for Visit <span class="text-red-500 italic text-xs">* required</span></label>
            <select wire:model="reason" class="w-full p-2 border rounded-md mb-6" required>
                <option value="">Select a reason</option>
                <option value="Consultation">Consultation</option>
                <option value="Fever">Fever</option>
                <option value="Emergency">Headache</option>
                <option value="Injury">Injury</option>
                <option value="Other">Other</option>
            </select>

            <label class="font-medium text-lg">Description of Symptoms <span class="text-red-500 italic text-xs">* required</span></label>
            <textarea wire:model="description" class="w-full border p-2 rounded mb-5" placeholder="Description of symptoms..." required></textarea>
        </div>

        <!-- Medical History -->
        <div class="mb-6 bg-prims-yellow-1 rounded-lg p-4">
            <h3 class="text-lg font-semibold">Medical History</h3>
        </div>

        <!-- Past Medical History -->
        <div class="mb-3 bg-gray-300 rounded-lg p-1 flex justify-center">
            <h3 class="text-md font-semibold">A. Past Medical History</h3>
        </div>

        <div class=" grid grid-cols-2 gap-x-4 mb-4">
            <label class="font-medium text-lg mt-2">Medications</label>
            <label class="font-medium text-lg mt-2">Allergies</label>
            <textarea wire:model="medications" class="w-full border p-2 rounded" placeholder="List any current or past medications, including maintenance prescriptions..."></textarea>
            <textarea wire:model="allergies" class="w-full border p-2 rounded" placeholder="Specify any known drug, food, or environmental allergies..."></textarea>
        </div>

        <div class="text-md grid grid-cols-2 md:grid-cols-4 gap-4">
            @foreach ($past_medical_history as $key => $value)
                @if ($key === 'Hepatitis')
                    <div class="flex flex-col my-2">
                        <span class="font-bold text-lg">{{ $key }} <span class="text-red-500 italic text-xs">*</span></span>
                        <div class="flex flex-wrap gap-4 mt-1">
                            @foreach (['A', 'B', 'C', 'D', 'None'] as $type)
                                <label class="flex items-center space-x-1">
                                    <input type="radio" wire:model="past_medical_history.Hepatitis" value="{{ $type }}" class="accent-black">
                                    <span>{{ $type }}</span>
                                </label>
                            @endforeach
                        </div>
                    </div>
                @else
                    <div class="flex flex-col my-2">
                        <span class="font-medium text-lg">{{ $key }} <span class="text-red-500 italic text-xs">*</span></span>
                        <div class="flex gap-4 mt-1">
                            <label class="flex items-center space-x-1">
                                <input type="radio" wire:model="past_medical_history.{{ $key }}" value="Yes" class="accent-black">
                                <span>Yes</span>
                            </label>
                            <label class="flex items-center space-x-1">
                                <input type="radio" wire:model="past_medical_history.{{ $key }}" value="No" class="accent-black">
                                <span>No</span>
                            </label>
                        </div>
                    </div>
                @endif
            @endforeach
        </div>

        <!-- Family History -->
        <div class="my-3 bg-gray-300 rounded-lg p-1 flex justify-center">
            <h3 class="text-md font-semibold">B. Family History</h3>
        </div>

        <div class="text-md grid grid-cols-2 md:grid-cols-4 gap-4">
            @foreach ($family_history as $key => $value)
                <div class="flex flex-col my-2">
                    <span class="font-medium text-lg">{{ $key }} <span class="text-red-500 italic text-xs">*</span></span>
                    <div class="flex gap-4 mt-1">
                        <label class="flex items-center space-x-1">
                            <input type="radio" wire:model="family_history.{{ $key }}" value="Yes" class="accent-black">
                            <span>Yes</span>
                        </label>
                        <label class="flex items-center space-x-1">
                            <input type="radio" wire:model="family_history.{{ $key }}" value="No" class="accent-black">
                            <span>No</span>
                        </label>
                    </div>
                </div>
            @endforeach
        </div>

        <!-- Personal and Social History -->
        <div class="my-3 bg-gray-300 rounded-lg p-1 flex justify-center">
            <h3 class="text-md font-semibold">C. Personal History</h3>
        </div>

        <div class="text-md grid grid-cols-3 gap-4">

            <!-- Smoke Input -->
            <div class="flex flex-col">
                <label class="text-lg font-medium">Smoke</label>
                <div class="flex items-center gap-4 flex-wrap">
                    <label class="text-md">Sticks/day:</label>
                    <input type="number" wire:model="personal_history.sticks_per_day" class="border rounded p-1 w-20" min="0" placeholder="N/A">
                    <label class="text-md">Packs/year:</label>
                    <input type="number" wire:model="personal_history.packs_per_year" class="border rounded p-1 w-20" min="0" placeholder="N/A">
                </div>
            </div>

            <div class="flex flex-col">
                <span class="font-medium text-lg">Vape <span class="text-red-500 italic text-xs">*</span></span>
                <div class="flex gap-4 mt-1">
                    <label class="flex items-center space-x-1">
                        <input type="radio" wire:model="personal_history.Vape" value="Yes" class="accent-black">
                        <span>Yes</span>
                    </label>
                    <label class="flex items-center space-x-1">
                        <input type="radio" wire:model="personal_history.Vape" value="No" class="accent-black">
                        <span>No</span>
                    </label>
                </div>
            </div>

            <!-- Alcohol Consumption -->
            <div class="flex flex-col">
                <label class="font-medium text-lg">Alcohol Consumption <span class="text-sm">(bottles per week)</span></label>
                <select wire:model="personal_history.Alcohol" class="border rounded p-1 w-full">
                    <option value="N/A">N/A</option>
                    @for ($i = 1; $i <= 20; $i++)
                        <option value="{{ $i }}">{{ $i }} bottle(s) per week</option>
                    @endfor
                </select>
            </div>

        </div>

        <!-- OB-GYNE History -->
        <div class="my-3 bg-gray-300 rounded-lg p-1 flex justify-center">
            <h3 class="text-md font-semibold">D. OB-GYNE History</h3>
        </div>

        <div class="text-md grid grid-cols-3 gap-x-4 gap-y-3">
            @foreach ($obgyne_history as $key => $value)
                <div class="flex flex-col my-2">
                    <span class="font-semibold text-lg">{{ $key }}</span>
                    <input type="text" wire:model="obgyne_history.{{ $key }}" class="border rounded-md p-1 w-full">
                </div>
            @endforeach
        </div>

        <!-- Hospitalization -->
        <div class="my-3 bg-gray-300 rounded-lg p-1 flex justify-center">
            <h3 class="text-md font-semibold">E. Hospitalization</h3>
        </div>

        <label class="font-medium text-lg mt-2">Hospitalization</label>
        <textarea wire:model="hospitalization" class="w-full border p-2 rounded" placeholder="Please specify..."></textarea>

        <!-- Operation -->
        <div class="my-3 bg-gray-300 rounded-lg p-1 flex justify-center">
            <h3 class="text-md font-semibold">F. Operation</h3>
        </div>

        <label class="font-medium text-lg mt-2">Operation</label>
        <textarea wire:model="operation" class="w-full border p-2 rounded" placeholder="Please specify..."></textarea>

        <!-- Immunizations -->
        <div class="my-3 bg-gray-300 rounded-lg p-1 flex justify-center">
            <h3 class="text-md font-semibold">G. Immunizations</h3>
        </div>

        <div class="text-md grid grid-cols-2 md:grid-cols-4 gap-4">
            @foreach ($immunizations as $key => $value)
                <div class="flex flex-col my-2">
                    <span class="font-medium text-lg">{{ $key }} 
                        @if (in_array($key, ['Hepa B', 'HPV', 'FLU VAC']))<span class="text-red-500 italic text-xs">*</span>@endif
                    </span>

                    @if (in_array($key, ['COVID-19 1st', 'COVID-19 2nd', 'Booster 1', 'Booster 2']))
                        <input type="text" 
                            wire:model="immunizations.{{ $key }}" 
                            placeholder="Enter date/details" 
                            class="border rounded px-2 py-1 mt-1 w-full" />
                    @else
                        <div class="flex gap-4 mt-1">
                            <label class="flex items-center space-x-1">
                                <input type="radio" wire:model="immunizations.{{ $key }}" value="Yes" class="accent-black">
                                <span>Yes</span>
                            </label>
                            <label class="flex items-center space-x-1">
                                <input type="radio" wire:model="immunizations.{{ $key }}" value="No" class="accent-black">
                                <span>No</span>
                            </label>
                        </div>
                    @endif
                </div>
            @endforeach
        </div>

        
        <!-- Physical Examination -->
        <div class="my-6 bg-prims-yellow-1 rounded-lg p-4">
            <h3 class="text-lg font-semibold">Physical Examination</h3>
        </div>

        <div class="-mt-3 mb-3">
            <span class="text-red-500 italic text-xs">Everything under physical examination is required.</span>
        </div>

        <div class="flex grid grid-cols-8 gap-4 justify-center mb-6">
            <div>
                <label class="block text-lg font-medium">Weight <span class="text-xs text-gray-500">(kg)</span> <span class="text-red-500 italic text-xs">*</span></label>
                <input type="number" wire:model.lazy="weight" class="w-full border rounded px-2 py-1" min="1" step="0.01">
            </div>
            <div>
                <label class="block text-lg font-medium">Height <span class="text-xs text-gray-500">(cm)</span> <span class="text-red-500 italic text-xs">*</span></label>
                <input type="number" wire:model.lazy="height" class="w-full border rounded px-2 py-1" min="1" step="0.01">
            </div>
           <div>
                <label class="block text-lg font-medium">BP <span class="text-xs text-gray-500">(mmHg)</span> <span class="text-red-500 italic text-xs">*</span></label>
                <input type="text" wire:model="blood_pressure" class="w-full border rounded px-2 py-1">
            </div>
            <div>
                <label class="block text-lg font-medium">HR <span class="text-xs text-gray-500">(beats per min.)</span> <span class="text-red-500 italic text-xs">*</span></label>
                <input type="number" wire:model="heart_rate" class="w-full border rounded px-2 py-1" min="1" step="0.01">
            </div>
            <div>
                <label class="block text-lg font-medium">RR <span class="text-xs text-gray-500">(breaths per min.)</span> <span class="text-red-500 italic text-xs">*</span></label>
                <input type="number" wire:model="respiratory_rate" class="w-full border rounded px-2 py-1" min="1" step="0.01">
            </div>
            <div>
                <label class="block text-lg font-medium">Temp <span class="text-xs text-gray-500">(°C)</span> <span class="text-red-500 italic text-xs">*</span></label>
                <input type="number" wire:model="temperature" class="w-full border rounded px-2 py-1" min="20" step="0.01">
            </div>
            <div>
                <label class="block text-lg font-medium">
                    BMI <span class="text-red-500 italic text-xs">*</span>
                </label>
                <input type="number" wire:model="bmi" class="w-full border px-2 py-1" step="0.01" min="0" readonly>
            </div>
            <div>
                <label class="block text-lg font-medium">O2Sat <span class="text-xs text-gray-500">(%)</span> <span class="text-red-500 italic text-xs">*</span></label>
                <input type="number" wire:model="o2sat" class="w-full border rounded px-2 py-1" min="0" step="0.01">
            </div>
        </div>

        <div class="flex justify-center mb-6">
            <table class="table-auto w-[80%] border-collapse border border-gray-300">
                <thead>
                    <tr class="bg-gray-100">
                        <th class="border px-4 py-1">Section</th>
                        <th class="border px-4 py-1">Normal <span class="text-red-500 italic text-xs">*</span></th>
                        <th class="border px-4 py-1">Findings <span class="text-red-500 italic text-xs">*</span></th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($sections as $key => $section)
                        <tr>
                            <td class="border px-4 py-1">{{ $section }}</td>
                            <td class="border px-4 py-1 text-center">
                                <input type="checkbox" wire:model="physical_examinations.{{ $section }}.normal" class="form-checkbox">
                            </td>
                            <td class="border px-4 py-1">
                                <input type="text" wire:model="physical_examinations.{{ $section }}.findings"
                                    class="w-full border rounded px-2 py-1 h-10"
                                    wire:keydown.enter.prevent>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>

        <!-- Diagnosis -->
        <div class="my-6 bg-prims-yellow-1 rounded-lg p-4">
            <h3 class="text-lg font-semibold">Diagnosis</h3>
        </div>

        @foreach ($diagnoses as $index => $diag)
            <div class="mb-6 flex flex-row gap-4 items-start">
                <!-- Diagnosis Dropdown -->
                <div class="w-1/3">
                    <label class="block text-lg font-medium">Diagnosis</label>
                    <select wire:model.defer="diagnoses.{{ $index }}.diagnosis"
                            class="w-full p-2 border rounded-md">
                        <option value="">-- Select Diagnosis --</option>
                        @foreach ($diagnosisOptions as $option)
                            <option value="{{ $option }}">{{ $option }}</option>
                        @endforeach
                    </select>
                </div>

                <!-- Notes -->
                <div class="w-2/3">
                    <label class="block text-lg font-medium">Diagnosis Notes:</label>
                    <textarea wire:model.defer="diagnoses.{{ $index }}.notes"
                        class="w-full border p-2 rounded"
                        placeholder="Additional notes..."></textarea>
                </div>

                <!-- Remove -->
                <button type="button" class="text-red-500" wire:click="removeDiagnosis({{ $index }})">✕</button>
            </div>
        @endforeach


        <!-- Add Diagnosis Button -->
        @if(count($diagnoses) < 5)
            <div class="mt-2">
                <button type="button" wire:click="addDiagnosis"
                    class="px-3 py-1 bg-prims-azure-100 text-white rounded-md">
                    + Add Diagnosis
                </button>
            </div>
        @endif

        <datalist id="diagnosisOptions">
            @foreach ($diagnosisOptions as $option)
                <option value="{{ $option }}">
            @endforeach
        </datalist>


        <!-- Prescription -->
        <div class="my-6 bg-prims-yellow-1 rounded-lg p-4">
            <h3 class="text-lg font-semibold">Prescription</h3>
        </div>

        <div class="mb-4">
            <label class="text-md font-medium">Prescription</label>
            <textarea wire:model="prescription" class="w-full border p-2 rounded mt-1" placeholder="Enter prescription notes or instructions..."></textarea>
        </div>

        <div class="mt-6 flex justify-end">
            <a href="/staff/medical-records" class="text-prims-azure-500 text-md m-2 mx-6 underline hover:text-prims-yellow-1 transition ease-in-out duration-150"> Back </a>
            <button 
            id="addRecordButton" 
            class="px-4 py-2 bg-prims-azure-500 text-white rounded-lg hover:bg-prims-azure-100"
            wire:click="submit">
            {{ $fromStaffCalendar ? 'Complete Appointment' : 'Submit' }}
            </button>
        </div>
        </form>

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
</div>