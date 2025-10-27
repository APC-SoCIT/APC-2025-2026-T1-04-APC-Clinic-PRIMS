<div class="max-w-2xl mx-auto mt-10 bg-white rounded-2xl shadow-lg p-6 space-y-6">
  <h1 class="text-2xl font-bold text-gray-800">Assign User Role</h1>
  <p class="text-gray-600">Search for a user and assign them a predefined role.</p>

  <!-- Search Form -->
  <form method="GET" action="{{ route('admin.roles.search') }}" class="flex gap-2">
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

  <!-- User Details + Role Assignment -->
  @if(isset($user))
  <div class="border-t pt-4 space-y-3">
    <h2 class="text-lg font-semibold text-gray-700">User Information</h2>
    <div class="space-y-1">
      <p><span class="font-medium">Name:</span> {{ $user->name }}</p>
      <p><span class="font-medium">Email:</span> {{ $user->email }}</p>
      <p><span class="font-medium">Current Role:</span> <span class="inline-block bg-gray-200 text-gray-800 text-sm px-2 py-1 rounded-md">{{ $user->getRoleNames()->first() ?? 'None' }}</span></p>
    </div>

    <form method="POST" action="{{ route('admin.roles.assign') }}" class="space-y-3 mt-4">
      @csrf
      <input type="hidden" name="user_id" value="{{ $user->id }}" />

      <label for="role" class="block text-gray-700 font-medium">Assign Role</label>
      <select
        id="role"
        name="role"
        class="w-full border border-gray-300 rounded-lg px-3 py-2 focus:ring focus:ring-blue-200 focus:outline-none"
      >
        <option value="Admin">Admin</option>
        <option value="Nurse">Nurse</option>
        <option value="Doctor">Doctor</option>
        <option value="Dentist">Dentist</option>
      </select>

      <button
        type="submit"
        class="w-full bg-green-600 hover:bg-green-700 text-white font-semibold px-4 py-2 rounded-lg transition-colors"
      >
        Save Changes
      </button>
    </form>
  </div>
  @endif

  <!-- Success Message -->
  @if(session('success'))
  <div class="bg-green-100 text-green-800 border border-green-300 px-4 py-3 rounded-lg">
    {{ session('success') }}
  </div>
  @endif
</div>