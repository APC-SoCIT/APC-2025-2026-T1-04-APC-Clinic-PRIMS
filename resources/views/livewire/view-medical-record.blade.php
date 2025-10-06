<div>
    <div class="bg-white rounded-md shadow-md mt-5 p-6">

        <!-- Personal Information -->
        <div class="bg-prims-yellow-1 rounded-lg p-4">
            <h2 class="text-lg font-semibold">Personal Information</h2>
        </div>

        <div class="grid grid-cols-4 gap-4 mt-4 items-center">
            <div>
                <label class="font-bold text-lg">ID Number</label>
                <input type="text" value="{{ $record->patient->apc_id_number }}" class="border p-2 rounded w-full bg-gray-100" readonly>
            </div>
            <div>
                <label class="font-bold text-lg">First Name</label>
                <input type="text" value="{{ $record->patient->first_name }}" class="border p-2 rounded w-full bg-gray-100" readonly>
            </div>
            <div>
                <label class="font-bold text-lg">Middle Initial</label>
                <input type="text" value="{{ $record->patient->middle_initial }}" class="border p-2 rounded w-full bg-gray-100" readonly>
            </div>
            <div>
                <label class="font-bold text-lg">Last Name</label>
                <input type="text" value="{{ $record->patient->last_name }}" class="border p-2 rounded w-full bg-gray-100" readonly>
            </div>
            <div>
                <label class="font-bold text-lg">Gender</label>
                <input type="text" value="{{ $record->patient->gender }}" class="border p-2 rounded w-full bg-gray-100" readonly>
            </div>
            <div>
                <label class="font-bold text-lg">Age</label>
                <input 
                    type="text" 
                    value="{{ \Carbon\Carbon::parse($record->patient->date_of_birth)->diff(\Carbon\Carbon::parse($record->created_at))->y }}" 
                    class="border p-2 rounded w-full bg-gray-100" 
                    readonly>
            </div>
            <div>
                <label class="font-bold text-lg">Date of Birth</label>
                <input type="text" value="{{ $record->patient->date_of_birth }}" class="border p-2 rounded w-full bg-gray-100" readonly>
            </div>
            <div>
                <label class="font-bold text-lg">Nationality</label>
                <input type="text" value="{{ $record->patient->nationality }}" class="border p-2 rounded w-full bg-gray-100" readonly>
            </div>
            <div>
                <label class="font-bold text-lg">Blood Type</label>
                <input type="text" value="{{ $record->patient->blood_type }}" class="border p-2 rounded w-full bg-gray-100" readonly>
            </div>
            <div>
                <label class="font-bold text-lg">Civil Status</label>
                <input type="text" value="{{ $record->patient->civil_status }}" class="border p-2 rounded w-full bg-gray-100" readonly>
            </div>
            <div>
                <label class="font-bold text-lg">Religion</label>
                <input type="text" value="{{ $record->patient->religion }}" class="border p-2 rounded w-full bg-gray-100" readonly>
            </div>
            <div>
                <label class="font-bold text-lg">Contact Number</label>
                <input type="text" value="{{ $record->patient->contact_number }}" class="border p-2 rounded w-full bg-gray-100" readonly>
            </div>
            <div>
                <label class="font-bold text-lg">Email Address</label>
                <input type="text" value="{{ $record->patient->email }}" class="border p-2 rounded w-full bg-gray-100" readonly>
            </div>
            <div>
                <label class="font-bold text-lg">House/Unit No.</label>
                <input type="text" value="{{ $record->patient->house_unit_number }}" class="border p-2 rounded w-full bg-gray-100" readonly>
            </div>
            <div>
                <label class="font-bold text-lg">Street</label>
                <input type="text" value="{{ $record->patient->street }}" class="border p-2 rounded w-full bg-gray-100" readonly>
            </div>
            <div>
                <label class="font-bold text-lg">Barangay</label>
                <input type="text" value="{{ $record->patient->barangay }}" class="border p-2 rounded w-full bg-gray-100" readonly>
            </div>
            <div>
                <label class="font-bold text-lg">City/Municipality</label>
                <input type="text" value="{{ $record->patient->city }}" class="border p-2 rounded w-full bg-gray-100" readonly>
            </div>
            <div>
                <label class="font-bold text-lg">Province</label>
                <input type="text" value="{{ $record->patient->province }}" class="border p-2 rounded w-full bg-gray-100" readonly>
            </div>
            <div>
                <label class="font-bold text-lg">ZIP Code</label>
                <input type="text" value="{{ $record->patient->zip_code }}" class="border p-2 rounded w-full bg-gray-100" readonly>
            </div>
            <div>
                <label class="font-bold text-lg">Country</label>
                <input type="text" value="{{ $record->patient->country }}" class="border p-2 rounded w-full bg-gray-100" readonly>
            </div>
            <div>
                <label class="font-bold text-lg">Emergency Contact Name</label>
                <input type="text" value="{{ $record->patient->emergency_contact_name }}" class="border p-2 rounded w-full bg-gray-100" readonly>
            </div>
            <div>
                <label class="font-bold text-lg">Emergency Contact Number</label>
                <input type="text" value="{{ $record->patient->emergency_contact_number }}" class="border p-2 rounded w-full bg-gray-100" readonly>
            </div>
            <div>
                <label class="font-bold text-lg">Relationship to Patient</label>
                <input type="text" value="{{ $record->patient->emergency_contact_relationship }}" class="border p-2 rounded w-full bg-gray-100" readonly>
            </div>
        </div>

        <!-- Medical Concern -->
        <div class="mt-6 bg-prims-yellow-1 rounded-lg p-4">
            <h2 class="text-lg font-semibold">Medical Concern</h2>
        </div>

        <div class="mt-4">
            <label class="text-lg font-medium">Reason for visit</label>
            <textarea class="w-full border p-2 rounded mb-5 bg-gray-100" readonly>{{ $record->reason }}</textarea>

            <label class="text-lg font-medium">Description of symptoms</label>
            <textarea class="w-full border p-2 rounded mb-5 bg-gray-100" readonly>{{ $record->description }}</textarea>
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
            <textarea class="w-full border p-2 rounded bg-gray-100" readonly>{{ $record->medications }}</textarea>
            <textarea class="w-full border p-2 rounded bg-gray-100" readonly>{{ $record->allergies }}</textarea>
        </div>

        <div class="text-md grid grid-cols-2 md:grid-cols-4 gap-4">
            @foreach($past_medical_history as $key => $value)
                <div class="flex flex-col my-2 justify-between">
                    <label class="text-lg font-semibold">{{ $key }}</label>

                    @if ($key === 'Hepatitis')
                        <div class="flex space-x-3">
                            @foreach(['A', 'B', 'C', 'D', 'None'] as $type)
                                <label class="flex items-center">
                                    <input type="radio" name="past_medical_history[{{ $key }}]" value="{{ $type }}" 
                                        {{ $value === $type ? 'checked' : '' }} disabled>
                                    <span class="ml-2">{{ $type }}</span>
                                </label>
                            @endforeach
                        </div>
                    @else
                        <div class="flex space-x-2">
                            <label class="flex items-center">
                                <input type="radio" name="past_medical_history[{{ $key }}]" value="Yes" 
                                    {{ $value === 'Yes' ? 'checked' : '' }} disabled>
                                <span class="ml-2">Yes</span>
                            </label>
                            <label class="flex items-center">
                                <input type="radio" name="past_medical_history[{{ $key }}]" value="No" 
                                    {{ $value === 'No' ? 'checked' : '' }} disabled>
                                <span class="ml-2">No</span>
                            </label>
                        </div>
                    @endif
                </div>
            @endforeach
        </div>

        <!-- Family History -->
        <div class="my-3 bg-gray-300 rounded-lg p-1 flex justify-center">
            <h3 class="text-md font-semibold">B. Family History</h3>
        </div>

        <div class="grid grid-cols-2 md:grid-cols-4 gap-4">
            @foreach($family_history as $key => $value)
                <div class="flex flex-col my-2 justify-between">
                    <label class="text-lg font-semibold">{{ $key }}</label>
                    <div class="flex space-x-4">
                        <label class="flex items-center">
                            <input type="radio" name="past_medical_history[{{ $key }}]" value="Yes" 
                                {{ $value === 'Yes' ? 'checked' : '' }} disabled>
                            <span class="ml-2">Yes</span>
                        </label>
                        <label class="flex items-center">
                            <input type="radio" name="past_medical_history[{{ $key }}]" value="No" 
                                {{ $value === 'No' ? 'checked' : '' }} disabled>
                            <span class="ml-2">No</span>
                        </label>
                    </div>
                </div>
            @endforeach
        </div>

        <!-- Personal & Social History -->
        <div class="my-3 bg-gray-300 rounded-lg p-1 flex justify-center">
            <h3 class="text-md font-semibold">C. Personal History</h3>
        </div>

        <div class="text-md grid grid-cols-3 gap-4">

            <div class="flex flex-col">
                <label class="text-lg font-medium">Smoke</label>
                <div class="flex items-center gap-4 flex-wrap">
                    <label class="text-md">Sticks/day:</label>
                    <input type="number" value="{{ $personal_history['sticks_per_day'] ?? 'N/A' }}" class="border rounded p-1 w-20 bg-gray-100" readonly>
                    <label class="text-md">Packs/year:</label>
                    <input type="number" value="{{ $personal_history['packs_per_year'] ?? 'N/A' }}" class="border rounded p-1 w-20 bg-gray-100" readonly>
                </div>
            </div>

            @foreach ($personal_history as $key => $value)
                @if (in_array($key, ['Vape']))
                    <div class="flex flex-col">
                        <span class="text-lg font-bold">{{ ucfirst($key) }}</span>
                        <div class="flex gap-4 mt-1">
                            <label class="flex items-center space-x-1">
                                <input type="radio" value="Yes" {{ $value === 'Yes' ? 'checked' : '' }} disabled>
                                <span>Yes</span>
                            </label>
                            <label class="flex items-center space-x-1">
                                <input type="radio" value="No" {{ $value === 'No' ? 'checked' : '' }} disabled>
                                <span>No</span>
                            </label>
                        </div>
                    </div>
                @endif
            @endforeach

            <!-- Alcohol Consumption -->
            <div class="flex flex-col">
                <label class="text-lg font-semibold">Alcohol Consumption</label>
                <input 
                    type="text" 
                    value="{{ $personal_history['Alcohol'] === 'N/A' ? 'N/A' : $personal_history['Alcohol'] . ' bottle(s) per week' }}" 
                    class="border p-2 rounded w-full bg-gray-100" 
                    readonly>
            </div>

        </div>

        <!-- OB-GYNE History -->
        <div class="my-3 bg-gray-300 rounded-lg p-1 flex justify-center">
            <h3 class="text-md font-semibold">D. OB-GYNE History</h3>
        </div>

        <div class="text-md grid grid-cols-3 gap-x-4 gap-y-3">
            @foreach ($obgyne_history as $key => $value)
                <div class="flex flex-col my-2">
                    <label class="text-lg font-semibold">{{ $key }}</label>
                    <input type="text" value="{{ $value }}" class="border p-2 rounded w-full bg-gray-100" readonly>
                </div>
            @endforeach
        </div>

        <!-- Hospitalization -->
        <div class="my-3 bg-gray-300 rounded-lg p-1 flex justify-center">
            <h3 class="text-md font-semibold">E. Hospitalization</h3>
        </div>

        <div class="mt-4">
            <label class="text-lg font-medium">Hospitalization</label>
            <textarea class="w-full border p-2 rounded mb-5 bg-gray-100" readonly>{{ $record->hospitalization }}</textarea>
        </div>

        <!-- Operation -->
        <div class="mb-3 bg-gray-300 rounded-lg p-1 flex justify-center">
            <h3 class="text-md font-semibold">F. Operation</h3>
        </div>

        <div class="mt-4">
            <label class="text-lg font-medium">Operation</label>
            <textarea class="w-full border p-2 rounded mb-5 bg-gray-100" readonly>{{ $record->operation }}</textarea>
        </div>

        <!-- Immunizations -->
        <div class="mb-3 bg-gray-300 rounded-lg p-1 flex justify-center">
            <h3 class="text-md font-semibold">G. Immunizations</h3>
        </div>

        <div class="text-md grid grid-cols-2 md:grid-cols-4 gap-4">
            @php
                $order = ['COVID-19 1st', 'COVID-19 2nd', 'Booster 1', 'Booster 2', 'Hepa B', 'HPV', 'FLU VAC'];
                $immunizations = collect($immunizations)->sortBy(fn($v, $k) => array_search($k, $order))->toArray();
            @endphp

            @foreach ($immunizations as $key => $value)
                <div class="flex flex-col my-2">
                    <span class="font-medium text-lg">{{ $key }}</span>

                    @if (in_array($key, ['COVID-19 1st', 'COVID-19 2nd', 'Booster 1', 'Booster 2']))
                        <input type="text" 
                            value="{{ $value }}" 
                            class="border rounded px-2 py-1 mt-1 w-full bg-gray-100" 
                            readonly />
                    @else
                        <div class="flex gap-4 mt-1">
                            <label class="flex items-center space-x-1">
                                <input type="radio" 
                                    value="Yes" 
                                    {{ $value === 'Yes' ? 'checked' : '' }} 
                                    disabled>
                                <span>Yes</span>
                            </label>
                            <label class="flex items-center space-x-1">
                                <input type="radio" 
                                    value="No" 
                                    {{ $value === 'No' ? 'checked' : '' }} 
                                    disabled>
                                <span>No</span>
                            </label>
                        </div>
                    @endif
                </div>
            @endforeach
        </div>

        <!-- Physical Examination -->
        <div class="mt-6 bg-prims-yellow-1 rounded-lg p-4">
            <h3 class="text-lg font-semibold">Physical Examination</h3>
        </div>

         <div class="flex grid grid-cols-8 gap-4 justify-center mb-6 mt-3">
            <div>
                <label class="block text-lg font-medium">Weight <span class="text-xs text-gray-500">(kg)</span></label>
                <input class="w-full border rounded px-2 py-1 bg-gray-100" value="{{ $record->weight }}" readonly>
            </div>
            <div>
                <label class="block text-lg font-medium">Height <span class="text-xs text-gray-500">(cm)</span></label>
                <input class="w-full border rounded px-2 py-1 bg-gray-100" value="{{ $record->height }}" readonly>
            </div>
           <div>
                <label class="block text-lg font-medium">BP <span class="text-xs text-gray-500">(mmHg)</span></label>
                <input class="w-full border rounded px-2 py-1 bg-gray-100" value="{{ $record->blood_pressure }}" readonly>
            </div>
            <div>
                <label class="block text-lg font-medium">HR <span class="text-xs text-gray-500">(beats per min.)</span></label>
                <input class="w-full border rounded px-2 py-1 bg-gray-100" value="{{ $record->heart_rate }}" readonly>
            </div>
            <div>
                <label class="block text-lg font-medium">RR <span class="text-xs text-gray-500">(breaths per min.)</span></label>
                <input class="w-full border rounded px-2 py-1 bg-gray-100" value="{{ $record->respiratory_rate }}" readonly>
            </div>
            <div>
                <label class="block text-lg font-medium">Temp <span class="text-xs text-gray-500">(°C)</span></label>
                <input class="w-full border rounded px-2 py-1 bg-gray-100" value="{{ $record->temperature }}" readonly>
            </div>
            <div>
                <label class="block text-lg font-medium">BMI</label>
                <input class="w-full border rounded px-2 py-1 bg-gray-100" value="{{ $record->bmi }}" readonly>
            </div>
            <div>
                <label class="block text-lg font-medium">O2Sat <span class="text-xs text-gray-500">(%)</span></label>
                <input class="w-full border rounded px-2 py-1 bg-gray-100" value="{{ $record->o2sat }}" readonly>
            </div>
        </div>

        <div class="flex justify-center mb-6 mt-4">
            <table class="table-auto w-[80%] border-collapse border border-gray-300">
                <thead>
                    <tr class="bg-gray-100">
                        <th class="border px-4 py-2">Section</th>
                        <th class="border px-4 py-2">Normal</th>
                        <th class="border px-4 py-2">Findings</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse ($physical_exams as $exam)
                        <tr>
                            <td class="border px-4 py-2 font-medium">{{ $exam->section }}</td>
                            <td class="border px-4 py-2 text-center">
                                <input 
                                    type="checkbox" 
                                    {{ $exam->normal ? 'checked' : '' }} 
                                    disabled
                                    class="{{ $exam->normal ? '' : 'border-gray-300' }}">
                            </td>
                            <td class="border px-4 py-2">
                                <input 
                                    type="text" 
                                    value="{{ $exam->findings ?? 'N/A' }}" 
                                    class="w-full border rounded px-2 py-1 h-10 
                                        {{ ($exam->findings ?? 'N/A') === 'N/A' ? 'text-gray-400 border-gray-300' : 'bg-gray-100' }}" 
                                    readonly>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="3" class="border px-4 py-2 text-center text-gray-500">
                                No physical examination data available
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>


        <!-- Diagnosis -->
        <div class="mt-6 bg-prims-yellow-1 rounded-lg p-4">
            <h3 class="text-lg font-semibold">Diagnosis</h3>
        </div>

        <div>
            @forelse ($diagnoses as $diag)
                <div class="my-4">
                    <label class="text-lg font-medium">Diagnosis</label>
                    <input type="text" 
                        value="{{ $diag->diagnosis }}" 
                        class="border p-2 rounded w-full bg-gray-100 mb-2" 
                        readonly>

                    <label class="text-lg font-medium">Notes</label>
                    <textarea class="w-full border p-2 rounded bg-gray-100" readonly>{{ $diag->diagnosis_notes ?? 'No additional notes' }}</textarea>
                </div>
            @empty
                <div class="my-4">
                    <label class="text-lg font-medium">Diagnosis</label>
                    <textarea class="w-full border p-2 rounded bg-gray-100" readonly>'No diagnosis data available'</textarea>
                </div>
            @endforelse
        </div>

        <!-- Prescription -->
        <div class="bg-prims-yellow-1 rounded-lg p-4">
            <h3 class="text-lg font-semibold">Prescription</h3>
        </div>

        <div class="mt-4">
            <label class="text-lg font-medium">Prescription</label>
            <textarea class="w-full border p-2 rounded bg-gray-100" readonly>{{ $record->prescription ?? 'No prescription available' }}</textarea>
        </div>

        <div class="mt-6 flex justify-end space-x-2">
            <a href="{{ route('medical-records') }}">
                <button class="px-4 py-2 bg-prims-azure-500 text-white rounded-lg hover:bg-prims-azure-100">
                    Back
                </button>
            </a>

            <a href="{{ route('print-medical-record', $record->id) }}" target="_blank">
                <button class="px-4 py-2 bg-green-500 text-white rounded-lg hover:bg-green-600">
                    Print
                </button>
            </a>
        </div>
    </div>
</div>
