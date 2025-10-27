<x-app-layout>
<div class="max-w-2xl mx-auto mt-10 bg-white rounded-2xl shadow-lg p-6 space-y-6">
  <h1 class="text-2xl font-bold text-gray-800">Assign User Role</h1>
  <p class="text-gray-600">Search for a user and assign them a predefined role.</p>

  <!-- Search Form -->
  <form method="GET" action="{{ route('admin') }}" class="flex gap-2">
    <input
      type="text"
      name="query"
      class="w-full border border-gray-300 rounded-lg px-3 py-2 focus:ring focus:ring-blue-200 focus:outline-none"
      placeholder="Search user by email or name..."
      value="{{ request('query') }}"
    />
    <button
      type="submit"
      class="bg-blue-600 hover:bg-blue-700 text-white font-semibold px-4 py-2 rounded-lg transition-colors"
    >
      Search
    </button>
  </form>

  <!-- Success Message -->
  @if(session('success'))
    <div class="bg-green-100 text-green-800 p-3 rounded-lg">
      {{ session('success') }}
    </div>
  @endif

  <!-- Search Results -->
  @if(isset($users) && $users->count())
    <div class="divide-y divide-gray-200">
      @foreach($users as $user)
        <div class="py-3 flex justify-between items-center">
          <div>
            <p class="font-medium text-gray-800">{{ $user->full_name ?? 'Unknown' }}</p>
            <p class="text-sm text-gray-500">{{ $user->email }}</p>
            <p class="text-sm text-gray-600 mt-1">
              Current Role: <span class="font-medium">{{ $user->getRoleNames()->implode(', ') ?: 'None' }}</span>
            </p>
          </div>

          <form action="{{ route('admin.assignRole', $user->id) }}" method="POST" class="flex gap-2 items-center">
            @csrf
            @php
              $availableRoles = ['admin', 'clinic staff', 'doctor', 'dentist'];
            @endphp
            <select name="role" class="border-gray-300 rounded-lg px-2 py-1">
              @foreach($availableRoles as $role)
                <option value="{{ $role }}" @if($user->hasRole($role)) selected @endif>
                  {{ ucfirst($role) }}
                </option>
              @endforeach
            </select>
            <button
              type="submit"
              class="bg-blue-600 hover:bg-blue-700 text-white text-sm font-medium px-3 py-1.5 rounded-lg transition"
            >
              Save
            </button>
          </form>
        </div>
      @endforeach
    </div>
  @elseif(request('query'))
    <p class="text-gray-500">No users found.</p>
  @endif
</div>
</x-app-layout>
