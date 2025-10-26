<div class="p-4 my-4 mx-6 bg-white rounded-lg shadow">
        <!-- Header -->
        <div class="flex items-center justify-between">
            <h1 class="m-4 text-2xl font-semibold text-gray-800">Clinic Account Management</h1>
            <input 
                type="text" 
                wire:model.live="search" 
                placeholder="Search by name or APC email...     ⌕" 
                class="border-gray-300 rounded-lg px-4 py-2 w-full sm:w-72 focus:ring-2 focus:ring-blue-400 outline-none">
            <button 
                wire:click="openModal" 
                class="flex justify-end m-4 bg-blue-600 text-white px-4 py-2 rounded-lg hover:bg-blue-700 transition">
                + Add Doctor
            </button>
        </div>

        <!-- One Modal -->
        @if($modalOpen)
        <div class="fixed inset-0 z-50 flex items-center justify-center bg-black bg-opacity-50">
            <div class="bg-white p-6 rounded-lg shadow w-96">
                @if(!$isConfirmStep)
                    <!-- Step 1: Enter Email -->
                    <h2 class="text-xl font-semibold mb-4">Add Doctor (Enter APC Email)</h2>
                    <input type="text" wire:model.lazy="email" placeholder="Enter APC email..." class="border rounded px-4 py-2 w-full mb-4">
                    <div class="flex justify-end gap-2">
                        <button wire:click="submitEmail" class="bg-green-600 text-white px-4 py-2 rounded hover:bg-green-700 transition">Submit</button>
                        <button wire:click="closeModal" class="bg-gray-400 text-white px-4 py-2 rounded hover:bg-gray-500 transition">Cancel</button>
                    </div>
                @else
                    <!-- Step 2: Confirm Info -->
                    <h2 class="text-xl font-semibold mb-4">Confirm Doctor Info</h2>
                    <p><strong>First Name:</strong> {{ $doctorInfo['first_name'] }}</p>
                    <p><strong>Last Name:</strong> {{ $doctorInfo['last_name'] }}</p>
                    <p><strong>Email:</strong> {{ $doctorInfo['email'] }}</p>
                    <p><strong>Role:</strong> {{ $doctorInfo['role'] }}</p>

                    <div class="mt-4 flex justify-end gap-2">
                        <button wire:click="closeModal" class="bg-gray-400 text-white px-4 py-2 rounded hover:bg-gray-500 transition">Cancel</button>
                        <button wire:click="confirmAddDoctor" class="bg-blue-600 text-white px-4 py-2 rounded hover:bg-blue-700 transition">Add</button>
                    </div>
                @endif
            </div>
        </div>
        @endif

        <!-- Success Modal -->
        @if($showSuccessModal)
        <div class="fixed inset-0 bg-gray-500 bg-opacity-50 flex justify-center items-center">
            <div class="bg-white p-8 rounded-lg shadow-lg text-center">
                <h3 class="text-3xl font-bold pb-3">Thank you!</h3>
                <p class="text-center">{{ $successMessage }}</p>
                <div class="mt-4 flex justify-center">
                    <x-prims-sub-button1 wire:click="closeSuccessModal">OK</x-prims-sub-button1>
                </div>
            </div>
        </div>
        @endif

    <!-- Search -->
    <!-- <div class="m-4 flex justify-center">
        <input type="text" wire:model.live="search" placeholder="Search by name or APC number... ⌕" class="border border-gray-300 rounded-lg px-4 py-2 w-full sm:w-72 focus:ring-2 focus:ring-blue-400 outline-none">
    </div> -->
    {{-- Table --}}
    <div class="m-4 bg-white rounded-lg shadow overflow">
        <div class="bg-blue-50 grid grid-cols-6 gap-2 p-2 text-center">
            <div class="font-semibold text-gray-600 uppercase tracking-wider">
                First Name
            </div>
            <div class="font-semibold text-gray-600 uppercase tracking-wider">
                Last Name
            </div>
            <div class="font-semibold text-gray-600 uppercase tracking-wider">
                APC Email
            </div>
            <div class="font-semibold text-gray-600 uppercase tracking-wider">
                Role
            </div>
            <div class="font-semibold text-gray-600 uppercase tracking-wider">
                Status
            </div>
            <div class="font-semibold text-gray-600 uppercase tracking-wider">
                Actions
            </div>
        </div>

        @forelse ($doctors as $doctor)
            <div class="grid grid-cols-6 gap-2 p-2 border border-gray-100 hover:bg-gray-50 transition">
                <div class="text-gray-900 font-medium ml-16">{{ $doctor['first_name'] ?? '-' }}</div>
                <div class="text-gray-900 font-medium ml-16">{{ $doctor['last_name'] ?? '-' }}</div>
                <div class="text-gray-700 ml-17">{{ $doctor['email'] }}</div>
                <div class="text-gray-700 ml-23">{{ ucfirst($doctor['role']) }}</div>
                <div class="flex items-center justify-center">
                    @if ($doctor['status'] === 'Active')
                        <span class="px-3 py-1 text-sm font-semibold bg-green-100 text-green-700 rounded-full">Active</span>
                    @else
                        <span class="px-3 py-1 text-sm font-semibold bg-gray-200 text-gray-700 rounded-full">Inactive</span>
                    @endif
                </div>
                <div class="relative flex items-center justify-center" x-data="{ open: false }">
                    <!-- 3 dots button -->
                    <button @click="open = !open" @click.away="open = false" class="text-gray-600 hover:text-gray-900">
                        <img src="{{ asset('/img/menu-H-dots.svg') }}" alt="Menu" class="w-5 h-5 opacity-70 hover:opacity-100 transition">
                    </button>

                    <!-- Dropdown -->
                    <div
                        x-show="open"
                        x-transition
                        class="absolute right-0 mt-2 w-40 bg-white border border-gray-200 rounded-lg shadow-lg z-50"
                    >
                        <ul class="py-1 text-sm text-gray-700">
                            @if ($doctor['status'] === 'Active')
                                <li>
                                    <button
                                        wire:click="setInactive('{{ $doctor['email'] }}')"
                                        class="block w-full text-left px-4 py-2 hover:bg-gray-100 text-yellow-600"
                                    >
                                        ⚠️ Set to Inactive
                                    </button>
                                </li>
                            @else
                                <li>
                                    <button
                                        wire:click="setActive('{{ $doctor['email'] }}')"
                                        class="block w-full text-left px-4 py-2 hover:bg-gray-100 text-green-600"
                                    >
                                        ✅ Set to Active
                                    </button>
                                </li>
                            @endif
                            <li>
                                <button
                                    wire:click="deleteDoctor('{{ $doctor['email'] }}')"
                                    class="block w-full text-left px-4 py-2 hover:bg-gray-100 text-gray-500"
                                >
                                    🗑️ Delete
                                </button>
                            </li>
                        </ul>
                    </div>
                </div>

            </div>
        @empty
            <div class="text-center py-6 text-gray-500">
                No doctors found.
            </div>
        @endforelse
    </div>
</div>