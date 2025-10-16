<div class="pb-5">
    <div class="bg-white rounded-md shadow-md mt-5 p-6">

        <!-- Personal Information -->
        <div class="bg-prims-yellow-1 rounded-lg p-4">
            <h2 class="text-lg font-semibold">Personal Information</h2>
        </div>
        <div class="grid grid-cols-4 gap-4 my-4">
            <div>
                <label class="text-lg">ID Number</label>
                <input type="text" value="{{ $record->patient->apc_id_number ?? '' }}" class="border p-2 rounded w-full bg-gray-200" readonly>
            </div>
            <div>
                <label class="text-lg">First Name</label>
                <input type="text" value="{{ $record->patient->first_name ?? '' }}" class="border p-2 rounded w-full bg-gray-200" readonly>
            </div>
            <div>
                <label class="text-lg">Middle Initial</label>
                <input type="text" value="{{ $record->patient->middle_initial ?? '' }}" class="border p-2 rounded w-full bg-gray-200" readonly>
            </div>
            <div>
                <label class="text-lg">Last Name</label>
                <input type="text" value="{{ $record->patient->last_name ?? '' }}" class="border p-2 rounded w-full bg-gray-200" readonly>
            </div>
            <div>
                <label class="text-lg">Gender</label>
                <input type="text" value="{{ $record->patient->gender ?? '' }}" class="border p-2 rounded w-full bg-gray-200" readonly>
            </div>
            <div>
                <label class="text-lg">Age</label>
                <input type="text" value="{{ $record->patient->age ?? '' }}" class="border p-2 rounded w-full bg-gray-200" readonly>
            </div>
            <div>
                <label class="text-lg">Date of Birth</label>
                <input type="text" value="{{ $record->patient->date_of_birth ?? '' }}" class="border p-2 rounded w-full bg-gray-200" readonly>
            </div>
            <div>
                <label class="text-lg">Nationality</label>
                <input type="text" value="{{ $record->patient->nationality ?? '' }}" class="border p-2 rounded w-full bg-gray-200" readonly>
            </div>
            <div>
                <label class="text-lg">Blood Type</label>
                <input type="text" value="{{ $record->patient->blood_type ?? '' }}" class="border p-2 rounded w-full bg-gray-200" readonly>
            </div>
            <div>
                <label class="text-lg">Civil Status</label>
                <input type="text" value="{{ $record->patient->civil_status ?? '' }}" class="border p-2 rounded w-full bg-gray-200" readonly>
            </div>
            <div>
                <label class="text-lg">Religion</label>
                <input type="text" value="{{ $record->patient->religion ?? '' }}" class="border p-2 rounded w-full bg-gray-200" readonly>
            </div>
            <div>
                <label class="text-lg">Contact Number</label>
                <input type="text" value="{{ $record->patient->contact_number ?? '' }}" class="border p-2 rounded w-full bg-gray-200" readonly>
            </div>
            <div>
                <label class="text-lg">Email Address</label>
                <input type="text" value="{{ $record->patient->email ?? '' }}" class="border p-2 rounded w-full bg-gray-200" readonly>
            </div>
            <div>
                <label class="text-lg">House/Unit No.</label>
                <input type="text" value="{{ $record->patient->house_unit_number ?? '' }}" class="border p-2 rounded w-full bg-gray-200" readonly>
            </div>
            <div>
                <label class="text-lg">Street</label>
                <input type="text" value="{{ $record->patient->street ?? '' }}" class="border p-2 rounded w-full bg-gray-200" readonly>
            </div>
            <div>
                <label class="text-lg">Barangay</label>
                <input type="text" value="{{ $record->patient->barangay ?? '' }}" class="border p-2 rounded w-full bg-gray-200" readonly>
            </div>
            <div>
                <label class="text-lg">City/Municipality</label>
                <input type="text" value="{{ $record->patient->city ?? '' }}" class="border p-2 rounded w-full bg-gray-200" readonly>
            </div>        
            <div>
                <label class="text-lg">Province</label>
                <input type="text" value="{{ $record->patient->province ?? '' }}" class="border p-2 rounded w-full bg-gray-200" readonly>
            </div>
            <div>
                <label class="text-lg">ZIP Code</label>
                <input type="text" value="{{ $record->patient->zip_code ?? '' }}" class="border p-2 rounded w-full bg-gray-200" readonly>
            </div>
            <div>
                <label class="text-lg">Country</label>
                <input type="text" value="{{ $record->patient->country ?? '' }}" class="border p-2 rounded w-full bg-gray-200" readonly>
            </div>
            <div>
                <label class="text-lg">Emergency Contact Name</label>
                <input type="text" value="{{ $record->patient->emergency_contact_name ?? '' }}" class="border p-2 rounded w-full bg-gray-200" readonly>
            </div>
            <div>
                <label class="text-lg">Emergency Contact Number</label>
                <input type="text" value="{{ $record->patient->emergency_contact_number ?? '' }}" class="border p-2 rounded w-full bg-gray-200" readonly>
            </div>
            <div>
                <label class="text-lg">Relationship to Patient</label>
                <input type="text" value="{{ $record->patient->emergency_contact_relationship ?? '' }}" class="border p-2 rounded w-full bg-gray-200" readonly>
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
            <div>
                <input type="radio" {{ $record->oral_hygiene == 'Good' ? 'checked' : '' }} disabled>
                <span>Good</span>
            </div>
            <div>
                <input type="radio" {{ $record->oral_hygiene == 'Fair' ? 'checked' : '' }} disabled>
                <span>Fair</span>
            </div>
            <div>
                <input type="radio" {{ $record->oral_hygiene == 'Poor' ? 'checked' : '' }} disabled>
                <span>Poor</span>
            </div>

            <!-- Gingival Color -->
            <label class="font-bold mt-4">Gingival Color :</label>
            <div class="mt-4">
                <input type="radio" {{ $record->gingival_color == 'Pink' ? 'checked' : '' }} disabled>
                <span>Pink</span>
            </div>
            <div class="mt-4">
                <input type="radio" {{ $record->gingival_color == 'Pale' ? 'checked' : '' }} disabled>
                <span>Pale</span>
            </div>
            <div class="mt-4">
                <input type="radio" {{ $record->gingival_color == 'Bright Red' ? 'checked' : '' }} disabled>
                <span>Bright Red</span>
            </div>
        </div>
        
        <div class="bg-gray-300 rounded-lg p-1 flex justify-center">
            <h3 class="text-md font-semibold">Procedures</h3>
        </div>
        <div class="my-6 justify-items-center">
            <div>
                <input type="checkbox" {{ $record->prophylaxis ? 'checked' : '' }} disabled>
                <span class="text-align-center font-bold ml-1">Oral Prophylaxis</span>
            </div>
        </div>

        <div class="bg-gray-300 rounded-lg p-1 flex justify-center">
            <h3 class="text-md font-semibold">Dental Number Chart</h3>
        </div>

        <!-- Tooth Number Chart -->
        <div class="mt-4">
            <h3 class="flex justify-center text-md font-semibold m-5">Selected Tooth Numbers</h3>

            <!-- Upper Teeth -->
            <div class="flex justify-center space-x-3">
                @foreach($record->teeth['upper'] ?? [] as $idx => $status)
                    <button
                        type="button"
                        class="w-10 h-10 rounded-full border border-gray-400 transition-colors duration-300
                            {{ $status ? 'bg-blue-600 text-white' : 'bg-white' }}"
                        title="Upper {{ $idx }}"
                        disabled
                    >
                        {{ $idx }}
                    </button>
                @endforeach
            </div>

            <!-- Lower Teeth -->
            <div class="flex justify-center space-x-3 mt-3">
                @foreach($record->teeth['lower'] ?? [] as $idx => $status)
                    <button
                        type="button"
                        class="w-10 h-10 rounded-full border border-gray-400 transition-colors duration-300
                            {{ $status ? 'bg-green-600 text-white' : 'bg-white' }}"
                        title="Lower {{ $idx }}"
                        disabled
                    >
                        {{ $idx }}
                    </button>
                @endforeach
            </div>
        </div>

        <div class="mt-6 mb-4 bg-gray-300 rounded-lg p-1 flex justify-center">
            <h3 class="text-md font-semibold">Recommendation</h3>
        </div>
        <textarea class="w-full border p-2 rounded mb-1 bg-gray-200" readonly>{{ $record->recommendation ?? '' }}</textarea>
    </div>
</div>