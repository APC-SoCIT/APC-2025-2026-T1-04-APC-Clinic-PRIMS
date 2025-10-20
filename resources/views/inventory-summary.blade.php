<x-app-layout>
    @php
        // Ensure $sections exists to avoid "undefined variable" errors
        $sections = $sections ?? ['Actual Stocks', 'General Issuance', 'Delivered'];
        $duration = $duration ?? 'monthly';
    @endphp

    <div class="flex-1 py-6">
        <div class="w-[90%] mx-auto">
            <!-- Header -->
            <div class="flex items-center gap-2 mb-6">
                <x-prims-sub-header>
                    <a href="{{ route('medical-inventory') }}" class="pr-3">&lt;</a>
                </x-prims-sub-header>
                <div class="flex-1">
                    <x-prims-sub-header>Inventory Summary</x-prims-sub-header>
                </div>
            </div>

            <!-- Filters & Generate PDF -->
            <div class="bg-white p-6 rounded-lg shadow-md mb-6">
                <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
                    <!-- Duration -->
                    <div>
                        <label class="block font-semibold mb-1">Duration</label>
                        <select id="duration" class="w-full border border-gray-300 rounded px-3 py-2">
                            <option value="monthly" {{ $duration == 'monthly' ? 'selected' : '' }}>Monthly</option>
                            <option value="annually" {{ $duration == 'annually' ? 'selected' : '' }}>Annually</option>
                        </select>
                    </div>

                    <!-- Sections -->
                    <div>
                        <label class="block font-semibold mb-1">Sections</label>
                        <div class="flex flex-col space-y-2">
                            @foreach(['Actual Stocks', 'General Issuance', 'Delivered'] as $section)
                                <label class="inline-flex items-center">
                                    <input type="checkbox" value="{{ $section }}" 
                                        class="form-checkbox text-prims-azure-500" 
                                        {{ in_array($section, $sections) ? 'checked' : '' }}>
                                    <span class="ml-2">{{ $section }}</span>
                                </label>
                            @endforeach
                        </div>
                    </div>

                    <!-- Generate PDF Button -->
                    <!-- Generate PDF Button -->
                    <div class="flex items-end">
                        <form id="generatePdfForm" action="{{ route('inventory.report') }}" method="GET" target="_blank" class="w-full">
                            <input type="hidden" name="duration" id="pdfDuration" value="{{ $duration }}">
                            <input type="hidden" name="sections[]" id="pdfSections" value="">
                            <button type="submit" 
                                class="w-full bg-prims-azure-500 text-white px-5 py-2 rounded-lg hover:bg-prims-azure-600 transition">
                                📄 Generate PDF
                            </button>
                        </form>
                    </div>
                </div>
            </div>

            <!-- Inventory Table -->
            <div class="overflow-x-auto bg-white rounded-lg shadow-md mb-6">
                <table class="w-full border border-gray-200 rounded-lg">
                    <thead class="bg-prims-yellow-1 text-black">
                        <tr>
                            <th class="px-4 py-2 text-left font-semibold">Generic Name</th>
                            <th class="px-4 py-2 text-left font-semibold">Category</th>
                            <th class="px-4 py-2 text-left font-semibold">Dosage Form</th>
                            <th class="px-4 py-2 text-left font-semibold">Strength</th>
                            <th class="px-4 py-2 text-left font-semibold">Remaining Stock</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($medicines as $medicine)
                            <tr class="hover:bg-gray-50 cursor-pointer border-b"
                                onclick="window.location.href='{{ route('inventory.show', ['id' => $medicine->id]) }}'">
                                <td class="px-4 py-2">{{ $medicine->name ?? 'N/A' }}</td>
                                <td class="px-4 py-2">{{ $medicine->category ?? 'N/A' }}</td>
                                <td class="px-4 py-2">{{ $medicine->dosage_form ?? 'N/A' }}</td>
                                <td class="px-4 py-2">{{ $medicine->dosage_strength ?? 'N/A' }}</td>
                                <td class="px-4 py-2">{{ $medicine->remaining_stock ?? 0 }}</td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>
    
<script>
    const form = document.getElementById('generatePdfForm');
    const durationInput = document.getElementById('pdfDuration');
    const sectionsInput = document.getElementById('pdfSections');

    document.getElementById('generatePdfBtn')?.addEventListener('click', function(e) {
        e.preventDefault(); // prevent default button click

        // Update hidden inputs
        durationInput.value = document.getElementById('duration').value;
        const selectedSections = Array.from(document.querySelectorAll('input[type="checkbox"]:checked'))
            .map(cb => cb.value);

        if(selectedSections.length === 0){
            alert('Please select at least one section.');
            return;
        }

        // Remove previous hidden inputs
        document.querySelectorAll('input[name="sections[]"]').forEach(el => el.remove());

        // Add hidden inputs for each section
        selectedSections.forEach(sec => {
            const input = document.createElement('input');
            input.type = 'hidden';
            input.name = 'sections[]';
            input.value = sec;
            form.appendChild(input);
        });

        // Submit form
        form.submit();
    });
</script>

</x-app-layout>
