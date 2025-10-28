<div>
    <div x-data="{ openReport: false, duration: '' }" class="flex justify-end items-center p-3">
        <div class="flex items-center space-x-3">

            <button
                @click="openReport = true"
                class="bg-white text-prims-azure-500 border-2 border-prims-azure-500 font-semibold px-5 py-2 rounded-lg shadow-sm hover:bg-prims-azure-50 transition-all duration-200">
                📊 Inventory Report
            </button>

            <button
                class="bg-prims-azure-500 hover:bg-prims-azure-600 text-white font-semibold px-5 py-2 rounded-lg shadow-md transition-all duration-200"
                onclick="window.location.href='{{ route('add-medicine') }}'">
                ➕ Add New Supply
            </button>
        </div>

        <div 
            x-show="openReport"
            x-transition:enter="transition ease-out duration-300"
            x-transition:enter-start="opacity-0"
            x-transition:enter-end="opacity-100"
            x-transition:leave="transition ease-in duration-200"
            x-transition:leave-start="opacity-100"
            x-transition:leave-end="opacity-0"
            class="fixed inset-0 bg-black bg-opacity-40 flex items-center justify-center z-50">
            <div
                id="reportModalBox"
                x-transition:enter="transition ease-out duration-300"
                x-transition:enter-start="opacity-0 translate-y-4 sm:translate-y-0 sm:scale-95"
                x-transition:enter-end="opacity-100 translate-y-0 sm:scale-100"
                x-transition:leave="transition ease-in duration-200"
                x-transition:leave-start="opacity-100 translate-y-0 sm:scale-100"
                x-transition:leave-end="opacity-0 translate-y-4 sm:translate-y-0 sm:scale-95"
                class="bg-white rounded-xl shadow-2xl p-8 w-full max-w-md mx-4"
                @click.away="openReport = false">

                <h2 class="text-2xl font-bold text-gray-800 mb-6 text-center border-b pb-3">
                    Generate Inventory Report
                </h2>

                <div class="mb-6 border p-4 rounded-lg bg-gray-50">
                    <label class="block text-sm font-bold text-gray-700 mb-3">1. Select Report Duration</label>
                    <div class="flex items-center space-x-6">
                        <label class="flex items-center space-x-2 cursor-pointer">
                            <input type="radio" name="duration" value="monthly" x-model="duration" class="text-prims-azure-500 focus:ring-prims-azure-400">
                            <span>Monthly</span>
                        </label>
                        <label class="flex items-center space-x-2 cursor-pointer">
                            <input type="radio" name="duration" value="annually" x-model="duration" class="text-prims-azure-500 focus:ring-prims-azure-400">
                            <span>Annually</span>
                        </label>
                    </div>
                </div>

                <div class="mb-6">
                    <label class="block text-sm font-bold text-gray-700 mb-2">2. Specify Date</label>

                    <template x-if="duration === 'monthly'">
                        <input 
                            type="month" 
                            name="month" 
                            id="reportMonth"
                            class="w-full border border-gray-300 text-gray-700 px-3 py-2 rounded-lg shadow-sm focus:outline-none focus:ring-2 focus:ring-prims-azure-400 transition" />
                    </template>

                    <template x-if="duration === 'annually'">
                        <input 
                            type="number" 
                            name="year" 
                            id="reportYear"
                            min="2000" max="2100"
                            placeholder="Enter Year (e.g. 2025)"
                            class="w-full border border-gray-300 text-gray-700 px-3 py-2 rounded-lg shadow-sm focus:outline-none focus:ring-2 focus:ring-prims-azure-400 transition" />
                    </template>
                </div>

                <div class="mb-8 border p-4 rounded-lg bg-gray-50">
                    <label class="block text-sm font-bold text-gray-700 mb-3">3. Include Sections</label>
                    <div class="grid grid-cols-2 gap-3">
                        <label class="flex items-center space-x-2 cursor-pointer">
                            <input type="checkbox" class="section-checkbox text-prims-azure-500 focus:ring-prims-azure-400 rounded" value="Actual Stocks">
                            <span>Actual Stocks</span>
                        </label>
                        <label class="flex items-center space-x-2 cursor-pointer">
                            <input type="checkbox" class="section-checkbox text-prims-azure-500 focus:ring-prims-azure-400 rounded" value="General Issuance">
                            <span>General Issuance</span>
                        </label>
                        <label class="flex items-center space-x-2 cursor-pointer">
                            <input type="checkbox" class="section-checkbox text-prims-azure-500 focus:ring-prims-azure-400 rounded" value="Deliveries">
                            <span>Deliveries</span>
                        </label>
                    </div>
                </div>

                <div class="flex justify-end space-x-3 mt-4">
                    <form id="reportForm" action="{{ route('inventory.report') }}" method="POST" target="_blank" class="flex items-center space-x-3">
                        @csrf
                        <input type="hidden" name="duration" id="reportDuration">
                        <input type="hidden" name="month" id="reportMonthInput">
                        <input type="hidden" name="year" id="reportYearInput">
                        <button
                            type="button"
                            @click="openReport = false"
                            class="px-5 py-2.5 bg-gray-200 text-gray-700 font-medium rounded-lg hover:bg-gray-300 transition">
                            Cancel
                        </button>

                        <button
                            type="button"
                            id="generateReportBtn"
                            class="px-5 py-2.5 bg-prims-azure-500 text-white font-medium rounded-lg hover:bg-prims-azure-600 transition shadow-md">
                            Generate Report
                        </button>
                    </form>
                </div>
            </div>
        </div>
    </div>

    {{-- Separator and Main Title --}}
    <div class="flex flex-col items-center pt-2 pb-6">
        <span class="text-prims-azure-500 uppercase font-extrabold text-xl tracking-wider border-b-2 border-prims-azure-500 pb-1"> MEDICAL INVENTORY</span>
    </div>

    <div class="w-[95%] mx-auto bg-white **p-4 border border-gray-200 rounded-xl shadow-lg** overflow-x-auto mb-10">
        <table class="w-full bg-white divide-y divide-gray-200 mx-auto rounded-lg overflow-hidden">
            <thead class="bg-prims-yellow-1 text-black">
                <tr>
                    <th class="px-4 py-3 text-sm font-bold uppercase border-b">Generic Name</th>
                    <th class="px-4 py-3 text-sm font-bold uppercase border-b">Brand</th>
                    <th class="px-4 py-3 text-sm font-bold uppercase border-b">Category</th>
                    <th class="px-4 py-3 text-sm font-bold uppercase border-b">Dosage Form</th>
                    <th class="px-4 py-3 text-sm font-bold uppercase border-b">Strength</th>
                    <th class="px-4 py-3 text-sm font-bold uppercase border-b">Date Supplied</th>
                    <th class="px-4 py-3 text-sm font-bold uppercase border-b">Expiration Date</th>
                    <th class="px-4 py-3 text-sm font-bold uppercase border-b">Quantity Received</th>
                    <th class="px-4 py-3 text-sm font-bold uppercase border-b">Remaining Stock</th>
                </tr>
            </thead>
            <tbody class="bg-white divide-y divide-gray-100">
                @php
                    $groupedInventory = collect($inventory)->groupBy('supply_name')->map(function ($items) {
                        return [
                            'earliest_expiring' => $items->sortBy([
                                ['expiration_date', 'asc'],
                                ['created_at', 'asc']
                            ])->first(),
                            'total_remaining_stock' => $items->sum('remaining_stock')
                        ];
                    });
                @endphp

                @foreach ($groupedInventory as $supply_name => $data)
                    @php
                        $item = $data['earliest_expiring'];
                        $totalStock = $data['total_remaining_stock'];
                    @endphp
                    <tr class="bg-white hover:bg-gray-100 cursor-pointer text-center align-middle"
                        onclick="window.location.href='{{ route('inventory.show', ['id' => $item->id]) }}'">

                        <td class="px-4 py-3">{{ $item->supply_name }}</td>
                        <td class="px-4 py-3">{{ $item->brand ?? 'N/A' }}</td>
                        <td class="px-4 py-3">{{ $item->category }}</td>
                        <td class="px-4 py-3">{{ $item->dosage_form }}</td>
                        <td class="px-4 py-3">{{ $item->dosage_strength }}</td>
                        <td class="px-4 py-3">{{ $item->date_supplied }}</td>
                        <td class="relative group px-4 py-3
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
                        <td class="px-4 py-3">{{ $item->quantity_received }}</td>
                        <td class="px-4 py-3 font-semibold relative group
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
            class="fixed bottom-5 right-5 bg-green-500 text-white px-6 py-3 rounded-xl shadow-lg transition-opacity duration-500 ease-in-out z-50">
            {{ session('dispose-message') }}
        </div>
    @endif

    @if (session()->has('batch_deleted_no-stock'))
        <div x-data="{ show: true }" x-init="setTimeout(() => show = false, 3000)" x-show="show"
            wire:ignore
            class="fixed bottom-5 right-5 bg-red-500 text-white px-6 py-3 rounded-xl shadow-lg transition-opacity duration-500 ease-in-out z-50">
            {{ session('batch_deleted_no-stock') }}
        </div>
    @endif

    {{-- Out-of-Stock Supplies Section --}}
    <div class="flex flex-col items-center pt-8 pb-4">
        <span class="text-prims-azure-500 uppercase font-extrabold text-xl tracking-wider border-b-2 border-prims-azure-500 pb-1">Out-of-Stock Supplies</span>
    </div>
    
    <div class="w-[95%] mx-auto bg-white **p-4 border border-gray-200 rounded-xl shadow-lg** overflow-x-auto mb-5">
        <table class="w-full bg-white dark:bg-gray-800 divide-y divide-gray-200 mx-auto rounded-lg overflow-hidden">
            <thead class="bg-gray-300 dark:bg-gray-700 text-black dark:text-gray-300">
                <tr>
                    <th class="px-4 py-3 text-sm font-bold uppercase border-b">Generic Name</th>
                    <th class="px-4 py-3 text-sm font-bold uppercase border-b">Brand</th>
                    <th class="px-4 py-3 text-sm font-bold uppercase border-b">Category</th>
                    <th class="px-4 py-3 text-sm font-bold uppercase border-b">Dosage Form</th>
                    <th class="px-4 py-3 text-sm font-bold uppercase border-b">Strength</th>
                </tr>
            </thead>
            <tbody class="bg-white divide-y divide-gray-100">

                @foreach ($inventoryWithTrashed as $item)
                    <tr class="bg-white hover:bg-gray-100 text-center align-middle">
                        <td class="px-4 py-3">{{ $item->supply_name }}</td>
                        <td class="px-4 py-3">{{ $item->brand ?? 'N/A' }}</td>
                        <td class="px-4 py-3">{{ $item->category }}</td>
                        <td class="px-4 py-3">{{ $item->dosage_form }}</td>
                        <td class="px-4 py-3">{{ $item->dosage_strength }}</td>
                    </tr>
                @endforeach
            </tbody>
        </table>
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