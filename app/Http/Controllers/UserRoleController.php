<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\User;

class UserRoleController extends Controller
{
    public function index(Request $request)
    {
        $user = auth()->user();

        if (!$user || !$user->hasRole('admin')) {
            abort(403);
        }

        $query = $request->input('query');
        $users = collect(); // empty collection by default

        if ($query) {
            $users = User::query()
                ->with(['roles', 'patient', 'clinicstaff'])
                ->where('email', 'like', "%{$query}%")
                ->orWhereHas('patient', function ($q) use ($query) {
                    $q->where('first_name', 'like', "%{$query}%")
                      ->orWhere('last_name', 'like', "%{$query}%");
                })
                ->orWhereHas('clinicstaff', function ($q) use ($query) {
                    $q->where('clinic_staff_fname', 'like', "%{$query}%")
                      ->orWhere('clinic_staff_lname', 'like', "%{$query}%");
                })
                ->get();
        }

        return view('admin-view', compact('users', 'query'));
    }

    public function assignRole(Request $request, User $user)
    {
        $request->validate([
            'role' => 'required|string|exists:roles,name',
        ]);

        // Remove any existing roles (doctor, nurse, dentist, etc.)
        $user->syncRoles([$request->role]);

        return redirect()->back()->with('success', "{$user->full_name}'s role updated to {$request->role}!");
    }

}
