<div class="p-6 bg-white dark:bg-gray-800 overflow-hidden shadow-lg sm:rounded-lg mt-5">
    <!-- Search bar -->
    <div class="flex gap-6 pb-5 justify-end">
        <input type="text" id="searchInput" placeholder="Search records..." class="px-4 py-2 border rounded-lg w-1/3">

        <a href="/staff/dental-form">
            <button id="addRecordButton" class="px-4 py-2 bg-prims-azure-500 text-white rounded-lg hover:bg-prims-azure-100">
                Add Record
            </button>
        </a>
    </div>

    <div class="overflow-x-auto bg-white shadow-md rounded-lg">
        <table id="DentalRecordsTable" class="w-full min-w-full divide-y divide-gray-200">
            <thead style="background-color: #F4BF4F;">
                <tr>
                    <th class="px-6 py-3 text-left text-sm uppercase tracking-wider">
                        APC ID Number
                    </th>
                    <th class="px-6 py-3 text-left text-sm uppercase tracking-wider">
                        Last Name
                    </th>
                    <th class="px-6 py-3 text-left text-sm uppercase tracking-wider">
                        First Name
                    </th>
                    <th class="px-6 py-3 text-center text-sm uppercase tracking-wider">
                        Middle Initial
                    </th>
                    <th class="px-6 py-3 text-left text-sm uppercase tracking-wider">
                        Email
                    </th>
                    <th class="px-6 py-3 text-left text-sm uppercase tracking-wider">
                        Last Visited
                    </th>
                    <th class="px-6 py-3 text-left text-sm uppercase tracking-wider">
                        Actions
                    </th>
                </tr>
            </thead>
        </table>
    </div>
    