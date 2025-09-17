<div class="overflow-x-auto py-4">
    <table class="w-full bg-white dark:bg-gray-800 border border-gray-200 dark:border-gray-700 rounded-lg shadow-lg">
        <thead class="bg-gray-100 dark:bg-gray-700 text-gray-700 dark:text-gray-300">
            <tr>
                <th class="text-left px-6 py-3 text-sm font-medium uppercase border-b dark:border-gray-600">#</th>
                <th class="text-left px-6 py-3 text-sm font-medium uppercase border-b dark:border-gray-600">Student Number</th>
                <th class="text-left px-6 py-3 text-sm font-medium uppercase border-b dark:border-gray-600">Date</th>
                <th class="text-left px-6 py-3 text-sm font-medium uppercase border-b dark:border-gray-600">Time</th>
                <th class="text-left px-6 py-3 text-sm font-medium uppercase border-b dark:border-gray-600">Nurse/Doctor</th>
                <th class="text-left px-6 py-3 text-sm font-medium uppercase border-b dark:border-gray-600">Status</th>
            </tr>
        </thead>
        <tbody class="text-gray-700 dark:text-gray-300">
            @foreach ($appointmentHistory as $appointment)
                <tr class="hover:bg-gray-50 dark:hover:bg-gray-600">
                    <td class="px-6 py-4 border-b dark:border-gray-600">{{ $appointment->id }}</td>
                    <td class="px-6 py-4 border-b dark:border-gray-600">{{ $appointment->student_number }}</td>
                    <td class="px-6 py-4 border-b dark:border-gray-600">{{ $appointment->date }}</td>
                    <td class="px-6 py-4 border-b dark:border-gray-600">{{ $appointment->time }}</td>
                    <td class="px-6 py-4 border-b dark:border-gray-600">{{ $appointment->nurse_doctor }}</td>
                    <td class="px-6 py-4 border-b dark:border-gray-600">
                        <span class="px-3 py-1 text-xs font-semibold">{{ $appointment->status }}</span>
                    </td>
                </tr>
            @endforeach
        </tbody>
    </table>
</div>

                