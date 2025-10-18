<div class="pb-5">
    <div class="bg-white rounded-md shadow-md mt-5 p-6">

        <!-- Personal Information -->
        <div class="bg-prims-yellow-1 rounded-lg p-4">
            <h2 class="text-lg font-semibold">Personal Information</h2>
        </div>

        <div class="grid grid-cols-4 gap-4 my-4">
            <div>
                <label class="text-lg">ID Number</label>
                <input type="text" value="{{ $record->patient->apc_id_number ?? '' }}" class="border p-2 rounded w-full bg-gray-100" readonly>
            </div>
            <div>
                <label class="text-lg">First Name</label>
                <input type="text" value="{{ $record->patient->first_name ?? '' }}" class="border p-2 rounded w-full bg-gray-100" readonly>
            </div>
            <div>
                <label class="text-lg">Middle Initial</label>
                <input type="text" value="{{ $record->patient->middle_initial ?? '' }}" class="border p-2 rounded w-full bg-gray-100" readonly>
            </div>
            <div>
                <label class="text-lg">Last Name</label>
                <input type="text" value="{{ $record->patient->last_name ?? '' }}" class="border p-2 rounded w-full bg-gray-100" readonly>
            </div>

            <div>
                <label class="text-lg">Gender</label>
                <input type="text" value="{{ $record->patient->gender ?? '' }}" class="border p-2 rounded w-full bg-gray-100" readonly>
            </div>
            <div>
                <label class="text-lg">Age</label>
                <input 
                    type="text" 
                    value="{{ \Carbon\Carbon::parse($record->patient->date_of_birth)->diff(\Carbon\Carbon::parse($record->created_at))->y }}" 
                    class="border p-2 rounded w-full bg-gray-100" 
                    readonly>
            </div>
            <div>
                <label class="text-lg">Date of Birth</label>
                <input type="text" value="{{ optional($record->patient->date_of_birth)->format('Y-m-d') ?? $record->patient->date_of_birth ?? '' }}" class="border p-2 rounded w-full bg-gray-100" readonly>
            </div>
            <div>
                <label class="text-lg">Nationality</label>
                <input type="text" value="{{ $record->patient->nationality ?? '' }}" class="border p-2 rounded w-full bg-gray-100" readonly>
            </div>

            <div>
                <label class="text-lg">Blood Type</label>
                <input type="text" value="{{ $record->patient->blood_type ?? '' }}" class="border p-2 rounded w-full bg-gray-100" readonly>
            </div>
            <div>
                <label class="text-lg">Civil Status</label>
                <input type="text" value="{{ $record->patient->civil_status ?? '' }}" class="border p-2 rounded w-full bg-gray-100" readonly>
            </div>
            <div>
                <label class="text-lg">Religion</label>
                <input type="text" value="{{ $record->patient->religion ?? '' }}" class="border p-2 rounded w-full bg-gray-100" readonly>
            </div>
            <div>
                <label class="text-lg">Contact Number</label>
                <input type="text" value="{{ $record->patient->contact_number ?? '' }}" class="border p-2 rounded w-full bg-gray-100" readonly>
            </div>

            <div>
                <label class="text-lg">Email Address</label>
                <input type="text" value="{{ $record->patient->email ?? '' }}" class="border p-2 rounded w-full bg-gray-100" readonly>
            </div>
            <div>
                <label class="text-lg">House/Unit No.</label>
                <input type="text" value="{{ $record->patient->house_unit_number ?? '' }}" class="border p-2 rounded w-full bg-gray-100" readonly>
            </div>
            <div>
                <label class="text-lg">Street</label>
                <input type="text" value="{{ $record->patient->street ?? '' }}" class="border p-2 rounded w-full bg-gray-100" readonly>
            </div>
            <div>
                <label class="text-lg">Barangay</label>
                <input type="text" value="{{ $record->patient->barangay ?? '' }}" class="border p-2 rounded w-full bg-gray-100" readonly>
            </div>

            <div>
                <label class="text-lg">City/Municipality</label>
                <input type="text" value="{{ $record->patient->city ?? '' }}" class="border p-2 rounded w-full bg-gray-100" readonly>
            </div>
            <div>
                <label class="text-lg">Province</label>
                <input type="text" value="{{ $record->patient->province ?? '' }}" class="border p-2 rounded w-full bg-gray-100" readonly>
            </div>
            <div>
                <label class="text-lg">ZIP Code</label>
                <input type="text" value="{{ $record->patient->zip_code ?? '' }}" class="border p-2 rounded w-full bg-gray-100" readonly>
            </div>
            <div>
                <label class="text-lg">Country</label>
                <input type="text" value="{{ $record->patient->country ?? '' }}" class="border p-2 rounded w-full bg-gray-100" readonly>
            </div>

            <div>
                <label class="text-lg">Emergency Contact Name</label>
                <input type="text" value="{{ $record->patient->emergency_contact_name ?? '' }}" class="border p-2 rounded w-full bg-gray-100" readonly>
            </div>
            <div>
                <label class="text-lg">Emergency Contact Number</label>
                <input type="text" value="{{ $record->patient->emergency_contact_number ?? '' }}" class="border p-2 rounded w-full bg-gray-100" readonly>
            </div>
            <div>
                <label class="text-lg">Relationship to Patient</label>
                <input type="text" value="{{ $record->patient->emergency_contact_relationship ?? '' }}" class="border p-2 rounded w-full bg-gray-100" readonly>
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
                <input type="radio" {{ ($record->oral_hygiene ?? '') === 'Good' ? 'checked' : '' }} disabled>
                <span class="">Good</span>
            </label>
            <label>
                <input type="radio" {{ ($record->oral_hygiene ?? '') === 'Fair' ? 'checked' : '' }} disabled>
                <span class="text-align-center">Fair</span>
            </label>
            <label>
                <input type="radio" {{ ($record->oral_hygiene ?? '') === 'Poor' ? 'checked' : '' }} disabled>
                <span class="text-align-center">Poor</span>
            </label>

            <!-- Gingival Color -->
            <label class="font-bold mt-4">Gingival Color :</label>
            <label class="mt-4">
                <input type="radio" {{ ($record->gingival_color ?? '') === 'Pink' ? 'checked' : '' }} disabled>
                <span class="">Pink</span>
            </label>
            <label class="mt-4">
                <input type="radio" {{ ($record->gingival_color ?? '') === 'Pale' ? 'checked' : '' }} disabled>
                <span class="text-align-center">Pale</span>
            </label>
            <label class="mt-4">
                <input type="radio" {{ ($record->gingival_color ?? '') === 'Bright Red' ? 'checked' : '' }} disabled>
                <span class="text-align-center">Bright Red</span>
            </label>
        </div>

        <div class="bg-gray-300 rounded-lg p-1 flex justify-center">
            <h3 class="text-md font-semibold">Procedures</h3>
        </div>
        <div class="my-6 justify-items-center">
            <div>
                <label>
                    <input type="checkbox" {{ ($record->prophylaxis ?? false) ? 'checked' : '' }} disabled>
                    <span class="text-align-center font-bold ml-1">Oral Prophylaxis</span>
                </label>
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
                @php
                    $leftLabels = $leftLabels ?? ['8','7','6','5','4','3','2','1'];
                    $rightLabels = $rightLabels ?? ['1','2','3','4','5','6','7','8'];
                    $upper = $record->teeth['upper'] ?? [];
                    $lower = $record->teeth['lower'] ?? [];

                    // added: color map for each condition
                    $conditionColors = [
                        'C' => 'bg-red-500 text-white',     // Caries
                        'M' => 'bg-gray-500 text-white',    // Missing
                        'E' => 'bg-green-500 text-white',   // Extracted
                        'LC' => 'bg-orange-500 text-white', // Lost Crown
                        'CR' => 'bg-purple-500 text-white', // Crown
                        'UE' => 'bg-yellow-400 text-white', // Unerupted
                    ];
                @endphp

                @foreach($leftLabels as $idx => $label)
                    @php
                        $status = $upper[$idx] ?? '';
                        $colorClass = $status ? ($conditionColors[$status] ?? 'bg-blue-600 text-white') : 'bg-white hover:bg-gray-200';
                    @endphp
                    <button
                        type="button"
                        class="tooth-btn w-10 h-10 rounded-full border border-gray-400 transition-colors duration-300 {{ $colorClass }}"
                        data-jaw="upper"
                        data-index="{{ $idx }}"
                        data-label="{{ $label }}"
                        data-status="{{ $status }}"
                        title="Upper Left {{ $label }} (pos {{ $idx }})"
                    >
                        {{ $label }}
                    </button>
                @endforeach

                <div class="w-8 flex items-center justify-center">
                    <div class="h-8 border-l-2 border-gray-700"></div>
                </div>

                @foreach($rightLabels as $idx => $label)
                    @php
                        $pos = $idx + count($leftLabels);
                        $status = $upper[$pos] ?? '';
                        $colorClass = $status ? ($conditionColors[$status] ?? 'bg-blue-600 text-white') : 'bg-white hover:bg-gray-200';
                    @endphp
                    <button
                        type="button"
                        class="tooth-btn w-10 h-10 rounded-full border border-gray-400 transition-colors duration-300 {{ $colorClass }}"
                        data-jaw="upper"
                        data-index="{{ $pos }}"
                        data-label="{{ $label }}"
                        data-status="{{ $status }}"
                        title="Upper Right {{ $label }} (pos {{ $pos }})"
                    >
                        {{ $label }}
                    </button>
                @endforeach
            </div>

            <!-- Lower Teeth -->
            <div class="flex justify-center space-x-3 mt-3">
                @foreach($leftLabels as $idx => $label)
                    @php
                        $status = $lower[$idx] ?? '';
                        $colorClass = $status ? ($conditionColors[$status] ?? 'bg-green-600 text-white') : 'bg-white hover:bg-gray-200';
                    @endphp
                    <button
                        type="button"
                        class="tooth-btn w-10 h-10 rounded-full border border-gray-400 transition-colors duration-300 {{ $colorClass }}"
                        data-jaw="lower"
                        data-index="{{ $idx }}"
                        data-label="{{ $label }}"
                        data-status="{{ $status }}"
                        title="Lower Left {{ $label }} (pos {{ $idx }})"
                    >
                        {{ $label }}
                    </button>
                @endforeach

                <div class="w-8 flex items-center justify-center">
                    <div class="h-8 border-l-2 border-gray-700"></div>
                </div>

                @foreach($rightLabels as $idx => $label)
                    @php
                        $pos = $idx + count($leftLabels);
                        $status = $lower[$pos] ?? '';
                        $colorClass = $status ? ($conditionColors[$status] ?? 'bg-green-600 text-white') : 'bg-white hover:bg-gray-200';
                    @endphp
                    <button
                        type="button"
                        class="tooth-btn w-10 h-10 rounded-full border border-gray-400 transition-colors duration-300 {{ $colorClass }}"
                        data-jaw="lower"
                        data-index="{{ $pos }}"
                        data-label="{{ $label }}"
                        data-status="{{ $status }}"
                        title="Lower Right {{ $label }} (pos {{ $pos }})"
                    >
                        {{ $label }}
                    </button>
                @endforeach
            </div>
        </div>

        <!-- Modal (view-only) -->
        <div id="tooth-modal" class="hidden fixed inset-0 bg-black bg-opacity-40 flex items-center justify-center z-50">
            <!-- added: wrapper div for detecting outside clicks -->
            <div id="modal-content" class="bg-white rounded-lg shadow-lg p-6 w-96 relative">
                <h3 class="text-lg font-semibold mb-4 text-gray-800">
                    Tooth <span id="modal-tooth-label">#</span>
                </h3>

                <div class="grid grid-cols-3 gap-3 mb-4">
                    @php
                        $statuses = ['C','M','E','LC','CR','UE'];
                        $statusColors = [
                            'C'  => 'bg-red-500 text-white',
                            'M'  => 'bg-blue-500 text-white',
                            'E'  => 'bg-green-500 text-white',
                            'LC' => 'bg-orange-500 text-white',
                            'CR' => 'bg-purple-500 text-white',
                            'UE' => 'bg-yellow-500 text-white',
                        ];
                    @endphp

                    @foreach($statuses as $status)
                        <button
                            type="button"
                            class="status-btn py-2 px-3 rounded shadow-sm bg-gray-200 text-gray-800"
                            data-status="{{ $status }}"
                            data-color="{{ $statusColors[$status] ?? 'bg-gray-200 text-gray-800' }}"
                            disabled
                        >
                            {{ $status }}
                        </button>
                    @endforeach
                </div>

                <div class="flex justify-end">
                    <button type="button" id="modal-close" class="px-4 py-2 bg-gray-300 rounded hover:bg-gray-400">Close</button>
                </div>
            </div>
        </div>

        <div class="mt-6 mb-4 bg-gray-300 rounded-lg p-1 flex justify-center">
            <h3 class="text-md font-semibold">Recommendation</h3>
        </div>
        <textarea class="w-full border p-2 rounded mb-1 bg-gray-100" readonly>{{ $record->recommendation ?? '' }}</textarea>

        <div class="mt-6 flex justify-end space-x-2">
            <a href="{{ route('medical-records') }}">
                <button class="px-4 py-2 bg-prims-azure-500 text-white rounded-lg hover:bg-prims-azure-100">
                    Back
                </button>
            </a>

            <!-- palitan na lang yung route nito -->
        <a href="{{ route('print-dental-record', $record->id) }}" target="_blank">
            <button class="px-4 py-2 bg-green-500 text-white rounded-lg hover:bg-green-600">
            Print
            </button>
        </a>    
        </div>

    </div>
</div>

<script>
(function () {
    const modal = document.getElementById('tooth-modal');
    const modalContent = document.getElementById('modal-content'); // added
    const modalLabel = document.getElementById('modal-tooth-label');
    const statusButtons = Array.from(document.querySelectorAll('.status-btn'));
    const toothButtons = Array.from(document.querySelectorAll('.tooth-btn'));

    function clearStatusButtonStyles(btn) {
        const color = (btn.dataset.color || '').trim();
        if (color) {
            const parts = color.split(/\s+/);
            btn.classList.remove(...parts);
        }
        btn.classList.add('bg-gray-200', 'text-gray-800');
        btn.classList.remove('ring-2', 'ring-offset-1', 'scale-105');
    }

    function applyActiveStatusStyle(btn) {
        btn.classList.remove('bg-gray-200', 'text-gray-800');
        const color = (btn.dataset.color || '').trim();
        if (color) {
            const parts = color.split(/\s+/);
            btn.classList.add(...parts);
        }
        btn.classList.add('ring-2', 'ring-offset-1', 'scale-105');
    }

    function openModal(label, status) {
        modalLabel.textContent = label || '#';
        statusButtons.forEach(btn => clearStatusButtonStyles(btn));
        if (status) {
            const target = statusButtons.find(b => b.dataset.status === status);
            if (target) applyActiveStatusStyle(target);
        }
        modal.classList.remove('hidden');
    }

    function closeModal() {
        modal.classList.add('hidden');
    }

    // added: close modal when clicking outside
    modal.addEventListener('click', (e) => {
        if (!modalContent.contains(e.target)) {
            closeModal();
        }
    });

    toothButtons.forEach(btn => {
        btn.addEventListener('click', () => {
            const label = btn.dataset.label || `${btn.dataset.jaw} ${btn.dataset.index}`;
            const status = btn.dataset.status || '';

            const jaw = btn.dataset.jaw;
            const index = parseInt(btn.dataset.index);
            const side = index <= 7 ? 'Left' : 'Right'; 
            const positionLabel = `${jaw.charAt(0).toUpperCase() + jaw.slice(1)} ${side}`;

            openModal(`${label} (${positionLabel})`, status);
        });
    });

    document.getElementById('modal-close').addEventListener('click', closeModal);

    document.addEventListener('keydown', (e) => {
        if (e.key === 'Escape' && !modal.classList.contains('hidden')) closeModal();
    });
})();
</script>