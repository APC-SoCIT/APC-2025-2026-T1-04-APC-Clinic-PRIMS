<div>
    <div x-data="{ openReport: false, duration: '' }" class="flex justify-end items-center p-3">
        <div class="flex items-center space-x-3">

            <!-- INVENTORY REPORT BUTTON -->
            <button
                @click="openReport = true"
                class="bg-white text-prims-azure-500 border-2 border-prims-azure-500 font-semibold px-5 py-2 rounded-lg shadow-sm hover:bg-prims-azure-50 transition-all duration-200">
                📊 Inventory Report
            </button>

            <!-- ADD NEW SUPPLY -->
            <button
                class="bg-prims-azure-500 hover:bg-prims-azure-600 text-white font-semibold px-5 py-2 rounded-lg shadow-md transition-all duration-200"
                onclick="window.location.href='{{ route('add-medicine') }}'">
                ➕ Add New Supply
            </button>
        </div>

        <!-- INVENTORY REPORT MODAL -->
        <div 
            x-show="openReport"
            class="fixed inset-0 bg-black bg-opacity-40 flex items-center justify-center z-50"
            x-transition>
            <div
                id="reportModalBox"
                class="bg-white rounded-xl shadow-xl p-6 w-96"
                @click.away="openReport = false">

                <h2 class="text-xl font-semibold text-gray-800 mb-4 text-center">
                    Generate Inventory Report
                </h2>

                <!-- Duration -->
                <div class="mb-4">
                    <label class="block text-sm font-medium text-gray-700 mb-2">Report Duration</label>
                    <div class="flex items-center space-x-4">
                        <label class="flex items-center space-x-2">
                            <input type="radio" name="duration" value="monthly" x-model="duration" class="text-prims-azure-500 focus:ring-prims-azure-400">
                            <span>Monthly</span>
                        </label>
                        <label class="flex items-center space-x-2">
                            <input type="radio" name="duration" value="annually" x-model="duration" class="text-prims-azure-500 focus:ring-prims-azure-400">
                            <span>Annually</span>
                        </label>
                    </div>
                </div>

                <!-- Month / Year Picker -->
                <div class="mb-4">
                    <label class="block text-sm font-medium text-gray-700 mb-2">Select Month and/or Year</label>

                    <!-- Month Picker -->
                    <template x-if="duration === 'monthly'">
                        <input 
                            type="month" 
                            name="month" 
                            id="reportMonth"
                            class="w-full border border-gray-300 text-gray-700 px-3 py-2 rounded focus:outline-none focus:ring-2 focus:ring-prims-azure-400 transition" />
                    </template>

                    <!-- Year Picker -->
                    <template x-if="duration === 'annually'">
                        <input 
                            type="number" 
                            name="year" 
                            id="reportYear"
                            min="2000" max="2100"
                            placeholder="Enter Year (e.g. 2025)"
                            class="w-full border border-gray-300 text-gray-700 px-3 py-2 rounded focus:outline-none focus:ring-2 focus:ring-prims-azure-400 transition" />
                    </template>
                </div>

                <!-- Sections -->
                <div class="mb-4">
                    <label class="block text-sm font-medium text-gray-700 mb-2">Include Sections</label>
                    <div class="space-y-2">
                        <label class="flex items-center space-x-2">
                            <input type="checkbox" class="section-checkbox text-prims-azure-500 focus:ring-prims-azure-400" value="Actual Stocks">
                            <span>Actual Stocks</span>
                        </label>
                        <label class="flex items-center space-x-2">
                            <input type="checkbox" class="section-checkbox text-prims-azure-500 focus:ring-prims-azure-400" value="General Issuance">
                            <span>General Issuance</span>
                        </label>
                        <label class="flex items-center space-x-2">
                            <input type="checkbox" class="section-checkbox text-prims-azure-500 focus:ring-prims-azure-400" value="Deliveries">
                            <span>Deliveries</span>
                        </label>
                    </div>
                </div>

                <!-- Buttons -->
                <div class="flex justify-end space-x-3 mt-6">
                    <form id="reportForm" action="{{ route('inventory.report') }}" method="POST" target="_blank" class="flex items-center space-x-3">
                        @csrf
                        <input type="hidden" name="duration" id="reportDuration">
                        <input type="hidden" name="month" id="reportMonthInput">
                        <input type="hidden" name="year" id="reportYearInput">
                        <button
                            type="button"
                            @click="openReport = false"
                            class="px-4 py-2 bg-gray-200 text-gray-700 rounded-lg hover:bg-gray-300 transition">
                            Cancel
                        </button>

                        <button
                            type="button"
                            id="generateReportBtn"
                            class="px-4 py-2 bg-prims-azure-500 text-white rounded-lg hover:bg-prims-azure-600 transition">
                            Generate
                        </button>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <div class="bg-white border-b border-gray-200 flex flex-wrap justify-center">
        <span class="text-prims-azure-500 uppercase font-semibold text-lg"> MEDICAL INVENTORY</span>
        <div class="bg-white rounded-b-md overflow-x-auto w-full p-2">
            <table class="w-[90%] bg-white border border-gray-200 rounded-lg shadow-md mx-auto">
                <thead class="bg-prims-yellow-1 text-black">
                    <tr>
                        <th class="px-4 py-2 text-sm font-bold uppercase border-b">Generic Name</th>
                        <th class="px-4 py-2 text-sm font-bold uppercase border-b">Brand</th>
                        <th class="px-4 py-2 text-sm font-bold uppercase border-b">Category</th>
                        <th class="px-4 py-2 text-sm font-bold uppercase border-b">Dosage Form</th>
                        <th class="px-4 py-2 text-sm font-bold uppercase border-b">Strength</th>
                        <th class="px-4 py-2 text-sm font-bold uppercase border-b">Date Supplied</th>
                        <th class="px-4 py-2 text-sm font-bold uppercase border-b">Expiration Date</th>
                        <th class="px-4 py-2 text-sm font-bold uppercase border-b">Quantity Received</th>
                        <th class="px-4 py-2 text-sm font-bold uppercase border-b">Remaining Stock</th>
                    </tr>
                </thead>
                <tbody>

                    @php
                        $groupedInventory = collect($inventory)->groupBy('supply_name')->map(function ($items) {
                            return [
                                'earliest_expiring' => $items->sortBy([
                                    ['expiration_date', 'asc'],  // Sort by expiration date (earliest first)
                                    ['created_at', 'asc']        // If same expiration, sort by creation date (earliest first)
                                ])->first(), // Get the first item after sorting
                                'total_remaining_stock' => $items->sum('remaining_stock') // Sum of remaining stock
                            ];
                        });
                    @endphp

                    @foreach ($groupedInventory as $supply_name => $data)
                        @php
                            $item = $data['earliest_expiring'];
                            $totalStock = $data['total_remaining_stock'];
                        @endphp
                        <tr class="bg-gray-50 hover:bg-gray-100 cursor-pointer text-center align-middle"
                            onclick="window.location.href='{{ route('inventory.show', ['id' => $item->id]) }}'">

                            <td class="px-4 py-2">{{ $item->supply_name }}</td>
                            <td class="px-4 py-2">{{ $item->brand ?? 'N/A' }}</td>
                            <td class="px-4 py-2">{{ $item->category }}</td>
                            <td class="px-4 py-2">{{ $item->dosage_form }}</td>
                            <td class="px-4 py-2">{{ $item->dosage_strength }}</td>
                            <td class="px-4 py-2">{{ $item->date_supplied }}</td>
                            <td class="relative group px-4 py-2
                                {{ now()->diffInDays($item->expiration_date, false) <= 14 && now()->diffInDays($item->expiration_date, false) >= 0 ? 'text-yellow-500 font-semibold' : '' }}
                                {{ \Carbon\Carbon::parse($item->expiration_date)->isPast() ? 'text-red-500 font-bold' : '' }}">

                                {{ $item->expiration_date ?? 'N/A' }}

                                @if (\Carbon\Carbon::parse($item->expiration_date)->isPast())
                                        <div class="absolute bottom-full mb-1 left-1/2 transform -translate-x-1/2 hidden group-hover:flex
                                                             bg-black text-red-300 text-xs rounded px-2 py-1 whitespace-nowrap z-50">
                                            Expired - Need to dispose
                                        </div>
                                @elseif (now()->diffInDays($item->expiration_date, false) <= 14 && now()->diffInDays($item->expiration_date, false) >= 0)
                                        <div class="absolute bottom-full mb-1 left-1/2 transform -translate-x-1/2 hidden group-hover:flex
                                                             bg-black text-yellow-300 text-xs rounded px-2 py-1 whitespace-nowrap z-50">
                                            Near Expiry ({{ round(now()->diffInDays($item->expiration_date)) }} days left)
                                        </div>
                                @endif
                            </td>
                            <td class="px-4 py-2">{{ $item->quantity_received }}</td>
                            <td class="px-4 py-2 font-semibold relative group
                                @if ($totalStock <= 25) text-red-500
                                @elseif ($totalStock <= 50) text-yellow-500
                                @endif">


                                {{ $item->remaining_stock }}
                                        <div class="absolute bottom-full mb-1 left-1/2 transform -translate-x-1/2 hidden group-hover:flex
                                                             bg-black text-white text-xs rounded px-2 py-1 whitespace-nowrap z-50">
                                            Total stock: {{ $totalStock }}
                                        </div>

                                @if ($totalStock <= 50 && $totalStock > 25)
                                        <div class="absolute bottom-full mb-1 left-1/2 transform -translate-x-1/2 hidden group-hover:flex
                                                             bg-black text-yellow-300 text-xs rounded px-2 py-1 whitespace-nowrap z-50">
                                            Please consider reordering
                                        </div>
                                @endif
                                @if ($totalStock <= 25)
                                        <div class="absolute bottom-full mb-1 left-1/2 transform -translate-x-1/2 hidden group-hover:flex
                                                             bg-black text-red-300 text-xs rounded px-2 py-1 whitespace-nowrap z-50">
                                            Low Stock - Need to reorder
                                        </div>
                                @endif
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>

        @if (session()->has('dispose-message'))
            <div x-data="{ show: true }" x-init="setTimeout(() => show = false, 3000)" x-show="show"
                wire:ignore
                class="bg-green-500 text-white px-4 py-2 rounded-md mb-4 transition-opacity duration-500 ease-in-out">
                {{ session('dispose-message') }}
            </div>
        @endif

        @if (session()->has('batch_deleted_no-stock'))
            <div x-data="{ show: true }" x-init="setTimeout(() => show = false, 3000)" x-show="show"
                wire:ignore
                class="bg-red-500 text-white px-4 py-2 rounded-md mb-4 transition-opacity duration-500 ease-in-out">
                {{ session('batch_deleted_no-stock') }}
            </div>
        @endif

        <span class="text-prims-azure-500 uppercase font-semibold text-lg pt-5">Out-of-Stock Supplies</span>
        <div class="bg-white rounded-b-md overflow-x-auto w-full mb-3 p-2">
            <table class="w-[90%] bg-white dark:bg-gray-800 border border-gray-300 dark:border-gray-700 rounded-lg shadow-md mx-auto">
                <thead class="bg-gray-300 dark:bg-gray-700 text-black dark:text-gray-300">
                    <tr>
                        <th class="px-4 py-2 text-sm font-bold uppercase border-b">Generic Name</th>
                        <th class="px-4 py-2 text-sm font-bold uppercase border-b">Brand</th>
                        <th class="px-4 py-2 text-sm font-bold uppercase border-b">Category</th>
                        <th class="px-4 py-2 text-sm font-bold uppercase border-b">Dosage Form</th>
                        <th class="px-4 py-2 text-sm font-bold uppercase border-b">Strength</th>
                    </tr>
                </thead>
                <tbody>

                    @foreach ($inventoryWithTrashed as $item)
                        <tr class="bg-gray-50 hover:bg-gray-100 text-center align-middle">
                            <td class="px-4 py-2">{{ $item->supply_name }}</td>
                            <td class="px-4 py-2">{{ $item->brand ?? 'N/A' }}</td>
                            <td class="px-4 py-2">{{ $item->category }}</td>
                            <td class="px-4 py-2">{{ $item->dosage_form }}</td>
                            <td class="px-4 py-2">{{ $item->dosage_strength }}</td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
</div>

<script>
document.addEventListener('DOMContentLoaded', function () {
    const generateBtn = document.getElementById('generateReportBtn');
    if (!generateBtn) return;

    generateBtn.addEventListener('click', function () {
        const modalRoot = document.getElementById('reportModalBox') || document;

        const selectedDuration = modalRoot.querySelector('input[name="duration"]:checked')?.value;
        const selectedMonth = modalRoot.querySelector('#reportMonth')?.value;
        const selectedYear = modalRoot.querySelector('#reportYear')?.value;
        const selectedSections = Array.from(modalRoot.querySelectorAll('.section-checkbox:checked'))
            .map(cb => cb.value);

        if (!selectedDuration) {
            alert('Please select a report duration.');
            return;
        }

        if (selectedSections.length === 0) {
            alert('Please select at least one section to include.');
            return;
        }

        // Check proper input
        if (selectedDuration === 'monthly' && !selectedMonth) {
            alert('Please select a month.');
            return;
        }
        if (selectedDuration === 'annually' && !selectedYear) {
            alert('Please enter a year.');
            return;
        }

        // Hidden form values
        document.getElementById('reportDuration').value = selectedDuration;
        document.getElementById('reportMonthInput').value = selectedMonth || '';
        document.getElementById('reportYearInput').value = selectedYear || '';

        // Remove old section inputs
        document.querySelectorAll('#reportForm input[name="sections[]"]').forEach(e => e.remove());

        // Add selected sections
        selectedSections.forEach(section => {
            const input = document.createElement('input');
            input.type = 'hidden';
            input.name = 'sections[]';
            input.value = section;
            document.getElementById('reportForm').appendChild(input);
        });

        // Submit
        document.getElementById('reportForm').submit();
    });
});
</script>
