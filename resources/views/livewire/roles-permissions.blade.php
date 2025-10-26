<div class="p-4 my-4 mx-6 bg-white rounded-lg shadow">
    <!-- Header -->
    <div class="flex items-center justify-between">
        <h2 class="m-4 text-2xl font-semibold text-gray-800">Roles & Permissions</h2>
    </div>

    <!-- Permissions Grid -->
    <div class="m-4 space-y-8 border rounded-lg p-4">
        @foreach ($permissions as $category => $actions)
            <!-- Category Header + Roles Header on Same Row -->
            <div>
                <div class="grid grid-cols-5 gap-2 mb-2 font-semibold text-gray-600 border-b pb-2">
                    <h3 class="text-lg font-semibold text-gray-700 uppercase">
                        {{ str_replace('_', ' ', $category) }}
                    </h3>
                    @foreach ($roles as $role)
                        <div class="text-center capitalize">{{ $role }}</div>
                    @endforeach
                </div>

                <!-- Actions Grid -->
                @foreach ($actions as $action => $roleAccess)
                    <div class="grid grid-cols-5 gap-2 py-2 border-b border-gray-200 items-center hover:bg-gray-50 transition">
                        <div class="font-medium text-gray-800">{{ str_replace('_', ' ', ucfirst($action)) }}</div>

                        @foreach ($roles as $role)
                            <div class="text-center">
                                <input 
                                    type="checkbox" 
                                    wire:click="togglePermission('{{ $category }}', '{{ $action }}', '{{ $role }}')"
                                    @checked($permissions[$category][$action][$role])
                                    class="h-5 w-5 text-blue-600 rounded focus:ring-blue-500"
                                >
                            </div>
                        @endforeach
                    </div>
                @endforeach
            </div>
        @endforeach
    </div>

</div>
