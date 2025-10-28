<x-app-layout>
    <div class="py-2 bg-gray-100 min-h-screen">
        <!-- Header -->
        <div class="max-w-[90rem] mx-auto px-4 sm:px-6 lg:px-8">
            <x-prims-sub-header>Dashboard</x-prims-sub-header>
        </div>

        <!-- Main content -->
        <div class="max-w-[90rem] mx-auto px-4 sm:px-6 lg:px-8 py-4" x-data="{ modalOpen:false, modalTitle:'', items:[] }">
            <!-- Greeting -->
            <div class="bg-white shadow-lg rounded-lg p-6 mb-6 flex justify-between items-center">
                <h2 class="text-2xl font-semibold text-gray-800">
                    Hello, {{ Auth::user()->full_name ?? Auth::user()->name }} 👋
                </h2>
                <p class="text-gray-500 text-sm">{{ now()->format('l, F j, Y') }}</p>
            </div>

            <!-- Two Column Layout -->
            <div class="grid grid-cols-1 lg:grid-cols-3 gap-6 mb-6">
                <!-- Left Column: Cards + Appointments -->
                <div class="lg:col-span-2 space-y-6">
                    <!-- Cards -->
                    <div class="grid grid-cols-1 sm:grid-cols-2 gap-4 justify-center">
                        <div class="p-3 sm:p-4 bg-white rounded-lg shadow-md flex flex-col items-center justify-center transition-transform duration-200 hover:scale-105">
                            <x-heroicon-s-calendar-days class="h-5 w-5 text-blue-500 mb-1" />
                            <h3 class="text-xs sm:text-sm font-semibold text-gray-700">Approved Appointments Today</h3>
                            <p class="text-2xl sm:text-3xl font-bold text-gray-900 mt-1">{{ $totalToday }}</p>
                        </div>

                        <div class="p-3 sm:p-4 bg-white rounded-lg shadow-md flex flex-col items-center justify-center transition-transform duration-200 hover:scale-105">
                            <x-heroicon-s-clock class="h-5 w-5 text-yellow-500 mb-1" />
                            <h3 class="text-xs sm:text-sm font-semibold text-gray-700">Pending Appointments This Month</h3>
                            <p class="text-2xl sm:text-3xl font-bold text-gray-900 mt-1">{{ $pendingRequests }}</p>
                        </div>
                    </div>

                    <!-- Appointments Table -->
                    <div class="bg-white rounded-lg shadow-md p-6">
                        <h3 class="text-lg font-semibold text-gray-800 mb-3 text-center">Appointments Scheduled for Today</h3>

                        @if($appointmentsToday->where('status','approved')->isEmpty())
                            <p class="text-gray-500 text-sm text-center py-4">
                                No approved appointments scheduled for today.
                            </p>
                        @else
                            <div class="overflow-y-auto max-h-80 border rounded">
                                <table class="min-w-full text-sm text-left">
                                    <thead class="bg-gray-100 text-gray-700 font-semibold sticky top-0 z-10">
                                        <tr>
                                            <th class="px-4 py-2 border">Patient</th>
                                            <th class="px-4 py-2 border">Time</th>
                                            <th class="px-4 py-2 border">Doctor</th>
                                            <th class="px-4 py-2 border">Status</th>
                                        </tr>
                                    </thead>
                                    <tbody class="text-gray-600">
                                        @foreach($appointmentsToday->where('status','approved') as $appt)
                                            <tr class="hover:bg-gray-50">
                                                <td class="px-4 py-2 border">
                                                    {{ optional($appt->patient->user)->name ?? ($appt->patient->first_name.' '.$appt->patient->last_name) ?? 'Unknown' }}
                                                </td>
                                                <td class="px-4 py-2 border">
                                                    {{ \Carbon\Carbon::parse($appt->appointment_date)->format('g:i A') }}
                                                </td>
                                                <td class="px-4 py-2 border">
                                                    {{ optional($appt->doctor)->full_name ?? 'N/A' }}
                                                </td>
                                                <td class="px-4 py-2 border">
                                                    <span class="px-2 py-1 text-xs rounded-full bg-green-100 text-green-600">Approved</span>
                                                </td>
                                            </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                            </div>
                            <div class="mt-4 text-center">
                                <a href="{{ route('calendar') }}" class="inline-block px-4 py-2 text-sm font-medium text-white bg-blue-600 rounded-lg hover:bg-blue-700">
                                    View All in Calendar
                                </a>
                            </div>
                        @endif
                    </div>
                </div>

                <!-- Right Column: Inventory -->
                <!-- Inventory Status Cards -->
                <div class="grid grid-cols-1 sm:grid-cols-2 gap-4 justify-center" x-data="{ openModal: false, modalCategory: '', items: [] }">
                    <div
                        class="p-5 bg-green-100 rounded-lg shadow-md flex flex-col items-center justify-center cursor-pointer"
                        @click="modalCategory='In Stock'; items=@json($inventoryDetails['in_stock']); openModal=true">
                        <h4 class="text-sm font-semibold text-gray-700">In Stock</h4>
                        <p class="text-2xl font-bold text-green-800 mt-1">{{ $inventoryCounts['in_stock'] ?? 0 }}</p>
                    </div>

                    <div
                        class="p-5 bg-yellow-100 rounded-lg shadow-md flex flex-col items-center justify-center cursor-pointer"
                        @click="modalCategory='Low Stock'; items=@json($inventoryDetails['low_stock']); openModal=true">
                        <h4 class="text-sm font-semibold text-gray-700">Low Stock</h4>
                        <p class="text-2xl font-bold text-yellow-800 mt-1">{{ $inventoryCounts['low_stock'] ?? 0 }}</p>
                    </div>

                    <div
                        class="p-5 bg-red-100 rounded-lg shadow-md flex flex-col items-center justify-center cursor-pointer"
                        @click="modalCategory='Out of Stock'; items=@json($inventoryDetails['out_of_stock']); openModal=true">
                        <h4 class="text-sm font-semibold text-gray-700">Out of Stock</h4>
                        <p class="text-2xl font-bold text-red-800 mt-1">{{ $inventoryCounts['out_of_stock'] ?? 0 }}</p>
                    </div>

                    <div
                        class="p-5 bg-gray-200 rounded-lg shadow-md flex flex-col items-center justify-center cursor-pointer"
                        @click="modalCategory='Expired'; items=@json($inventoryDetails['expired']); openModal=true">
                        <h4 class="text-sm font-semibold text-gray-700">Expired</h4>
                        <p class="text-2xl font-bold text-gray-800 mt-1">{{ $inventoryCounts['expired'] ?? 0 }}</p>
                    </div>

                    <!-- Modal -->
                    <div
                        x-show="openModal"
                        class="fixed inset-0 bg-black bg-opacity-40 flex items-center justify-center z-50"
                        x-transition>
                        <div class="bg-white rounded-xl shadow-xl p-6 w-96 max-h-[80vh] overflow-y-auto" @click.away="openModal=false">
                            <h2 class="text-xl font-semibold text-gray-800 mb-4 text-center" x-text="modalCategory + ' Items'"></h2>
                            <template x-if="items.length > 0">
                                <table class="w-full text-sm text-left border">
                                    <thead class="bg-gray-100 font-semibold">
                                        <tr>
                                            <th class="px-2 py-1 border">Name</th>
                                            <th class="px-2 py-1 border">Brand</th>
                                            <th class="px-2 py-1 border">Category</th>
                                            <th class="px-2 py-1 border">Qty</th>
                                            <th class="px-2 py-1 border">Remaining</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <template x-for="item in items" :key="item.id">
                                            <tr class="hover:bg-gray-50">
                                                <td class="px-2 py-1 border" x-text="item.supply.name"></td>
                                                <td class="px-2 py-1 border" x-text="item.supply.brand ?? 'N/A'"></td>
                                                <td class="px-2 py-1 border" x-text="item.supply.category"></td>
                                                <td class="px-2 py-1 border" x-text="item.quantity_received"></td>
                                                <td class="px-2 py-1 border" x-text="item.remaining_stock"></td>
                                            </tr>
                                        </template>
                                    </tbody>
                                </table>
                            </template>
                            <template x-if="items.length === 0">
                                <p class="text-center text-gray-500">No items found</p>
                            </template>
                        </div>
                    </div>
                </div>


                <!-- Modal -->
                <div x-show="modalOpen" x-cloak class="fixed inset-0 bg-black bg-opacity-50 flex items-center justify-center z-50">
                    <div class="bg-white rounded-lg w-11/12 md:w-2/3 lg:w-1/2 max-h-[80vh] overflow-y-auto p-6 relative">
                        <button @click="modalOpen=false" class="absolute top-3 right-3 text-gray-600 hover:text-gray-800">&times;</button>
                        <h3 class="text-lg font-semibold mb-4 text-center" x-text="modalTitle"></h3>

                        <template x-if="items.length">
                            <table class="min-w-full text-sm text-left border">
                                <thead class="bg-gray-100 text-gray-700 font-semibold sticky top-0 z-10">
                                    <tr>
                                        <th class="px-4 py-2 border">Item Name</th>
                                        <th class="px-4 py-2 border">Brand</th>
                                        <th class="px-4 py-2 border">Category</th>
                                        <th class="px-4 py-2 border">Dosage/Strength</th>
                                        <th class="px-4 py-2 border">Form</th>
                                        <th class="px-4 py-2 border">Remaining Qty</th>
                                        <th class="px-4 py-2 border">Expiration Date</th>
                                    </tr>
                                </thead>
                                <tbody class="text-gray-600">
                                    <template x-for="item in items" :key="item.id">
                                        <tr class="hover:bg-gray-50">
                                            <td class="px-4 py-2 border" x-text="item.supply.name"></td>
                                            <td class="px-4 py-2 border" x-text="item.supply.brand"></td>
                                            <td class="px-4 py-2 border" x-text="item.supply.category"></td>
                                            <td class="px-4 py-2 border" x-text="item.supply.dosage_strength"></td>
                                            <td class="px-4 py-2 border" x-text="item.supply.dosage_form"></td>
                                            <td class="px-4 py-2 border" x-text="item.remaining_stock"></td>
                                            <td class="px-4 py-2 border" x-text="item.expiration_date ? new Date(item.expiration_date).toLocaleDateString() : 'N/A'"></td>
                                        </tr>
                                    </template>
                                </tbody>
                            </table>
                        </template>

                        <template x-if="!items.length">
                            <p class="text-center text-gray-500 py-4">No items found.</p>
                        </template>
                    </div>
                </div>
            </div>

            <!-- Calendar Section (unchanged) -->
            <div class="bg-white rounded-lg shadow-md p-6 mb-6">
                <div class="flex justify-between items-center mb-4">
                    <h3 class="text-lg font-semibold text-gray-800">Clinic Schedule</h3>
                    <div class="space-x-2">
                        <button id="weekView" class="px-3 py-1 bg-blue-500 text-white rounded-md text-sm">Week</button>
                        <button id="monthView" class="px-3 py-1 bg-gray-300 text-gray-800 rounded-md text-sm">Month</button>
                    </div>
                </div>
                <div id="calendar" class="rounded-lg overflow-hidden border"></div>

                <!-- Legend -->
                <div class="flex items-center justify-center gap-6 text-sm text-gray-600 mt-4">
                    <div class="flex items-center"><span class="inline-block w-4 h-4 bg-green-500 rounded-sm mr-2"></span>Approved</div>
                    <div class="flex items-center"><span class="inline-block w-4 h-4 bg-blue-500 rounded-sm mr-2"></span>Completed</div>
                    <div class="flex items-center"><span class="inline-block w-4 h-4 bg-yellow-400 rounded-sm mr-2"></span>Pending</div>
                    <div class="flex items-center"><span class="inline-block w-4 h-4 bg-red-500 rounded-sm mr-2"></span>Cancelled</div>
                </div>
            </div>
        </div>
    </div>

    <!-- FullCalendar CSS + JS -->
    <link href="https://cdn.jsdelivr.net/npm/fullcalendar@6.1.11/index.global.min.css" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/fullcalendar@6.1.11/index.global.min.js"></script>

    <!-- AlpineJS for modal -->
    <script src="//unpkg.com/alpinejs" defer></script>

    <style>
        .fc-event {
            background-color: white !important;
            color: black !important;
            border-left: 6px solid;
            font-size: 0.85rem !important;
            font-weight: 600 !important;
            padding: 4px 6px !important;
            border-radius: 6px !important;
            display: flex;
            flex-direction: column;
            line-height: 1.2 !important;
            white-space: normal !important;
            overflow: hidden;
            text-overflow: ellipsis;
        }
        .fc-event-title {
            font-weight: 600 !important;
            color: black !important;
            overflow: hidden;
            text-overflow: ellipsis;
            white-space: nowrap;
        }
        .fc-event-time {
            font-weight: 500 !important;
            color: black !important;
            font-size: 0.7rem !important;
            overflow: hidden;
            text-overflow: ellipsis;
            white-space: nowrap;
        }
        .fc-daygrid-event, .fc-timegrid-event { min-height: 50px; }
        .fc .fc-scrollgrid { border-radius: 10px !important; }
    </style>

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            let calendarEl = document.getElementById('calendar');
            let weekBtn = document.getElementById('weekView');
            let monthBtn = document.getElementById('monthView');

            let calendar = new FullCalendar.Calendar(calendarEl, {
                initialView: 'timeGridWeek',
                headerToolbar: false,
                slotMinTime: '07:00:00',
                slotMaxTime: '20:00:00',
                nowIndicator: true,
                height: 700,
                eventContent: function(arg) {
                    let patient = arg.event.extendedProps.patient || arg.event.title || 'N/A';
                    let doctor = arg.event.extendedProps.doctor || 'N/A';
                    let time = arg.event.start.toLocaleTimeString([], {hour:'2-digit',minute:'2-digit'});
                    return { html: `<div style="display:flex;flex-direction:column;overflow:hidden;">
                        <span class="fc-event-title" title="${patient}">${patient}</span>
                        <span class="fc-event-time" title="Dr. ${doctor} | ${time}">Dr. ${doctor} | ${time}</span>
                    </div>` };
                },
                eventDidMount: function(info) {
                    const status = info.event.extendedProps.status;
                    let borderColor = '#22c55e'; // green for approved
                    if(status==='completed') borderColor = '#22c55e';
                    else if(status==='pending') borderColor = '#facc15';
                    else if(status==='cancelled') borderColor = '#ef4444';
                    info.el.style.borderLeft = `6px solid ${borderColor}`;
                    info.el.style.backgroundColor = 'white';
                    info.el.style.color = 'black';
                },
                events: @json($calendarEvents),
            });

            calendar.render();

            weekBtn.addEventListener('click', () => {
                calendar.changeView('timeGridWeek');
                weekBtn.classList.add('bg-blue-500', 'text-white');
                monthBtn.classList.remove('bg-blue-500', 'text-white');
                monthBtn.classList.add('bg-gray-300', 'text-gray-800');
            });

            monthBtn.addEventListener('click', () => {
                calendar.changeView('dayGridMonth');
                monthBtn.classList.add('bg-blue-500', 'text-white');
                weekBtn.classList.remove('bg-blue-500', 'text-white');
                weekBtn.classList.add('bg-gray-300', 'text-gray-800');
            });
        });
    </script>
</x-app-layout>
