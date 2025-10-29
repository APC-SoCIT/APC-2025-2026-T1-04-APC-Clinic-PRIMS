<div class="p-6 bg-white rounded-lg shadow-md space-y-4">
    <h2 class="text-xl font-semibold mb-3">🩺 Manage Doctor Schedule</h2>

    <div class="grid grid-cols-3 gap-4">
        <div>
            <label class="block text-sm font-medium">Select Doctor</label>
            <select wire:model="selectedDoctor" class="w-full border rounded p-2">
                <option value="">-- choose doctor --</option>
                @foreach ($doctors as $doc)
                    <option value="{{ $doc->id }}">{{ $doc->email }}</option>
                @endforeach
            </select>
        </div>

        <div>
            <label class="block text-sm font-medium">Select Date</label>
            <input type="date" wire:model="selectedDate" class="w-full border rounded p-2">
        </div>

        <div>
            <label class="block text-sm font-medium">Select Time</label>
            <div class="flex gap-2 items-center">
                <input type="time" wire:model="customTime" class="w-full border rounded p-2">
                <button wire:click="addCustomTime" class="bg-blue-600 text-white px-3 rounded hover:bg-blue-700">Add</button>
            </div>
        </div>
    </div>

    @if (!empty($availableTimes))
        <div class="mt-4">
            <label class="block text-sm font-medium">Available Times</label>
            <div class="flex flex-wrap gap-2 mt-2">
                @foreach ($availableTimes as $time)
                    <span class="bg-gray-100 px-3 py-1 rounded-full text-sm flex items-center gap-2">
                        {{ $time }}
                        <button wire:click="removeTime('{{ $time }}')" class="text-red-500 hover:text-red-700 font-bold">×</button>
                    </span>
                @endforeach
            </div>
        </div>
    @endif

    <div class="mt-6 text-right">
        <button wire:click="saveSchedule" class="bg-green-600 text-white px-4 py-2 rounded hover:bg-green-700">
            Save Schedule
        </button>
    </div>

    @if (session()->has('message'))
        <div class="mt-4 p-3 bg-green-100 text-green-700 rounded">
            {{ session('message') }}
        </div>
    @endif
</div>
