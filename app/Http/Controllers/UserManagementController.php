<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rule;

class UserManagementController extends Controller
{
    /**
     * Display all staff/admin users.
     */
    public function index()
    {
        $users = User::whereIn('role', [
                'admin',
                'management',
                'staff',
            ])
            ->orderBy('name')
            ->get();

        return view('users.index', compact('users'));
    }


    /**
     * Show create user form.
     */
    public function create()
    {
        return view('users.create');
    }


    /**
     * Store new user.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => [
                'required',
                'string',
                'max:255',
            ],

            'email' => [
                'required',
                'email',
                'max:255',
                'unique:users,email',
            ],

            'password' => [
                'required',
                'string',
                'min:8',
                'confirmed',
            ],

            'role' => [
                'required',
                Rule::in([
                    'admin',
                    'management',
                    'staff',
                ]),
            ],
        ]);

        User::create([
            'name' => $validated['name'],
            'email' => $validated['email'],
            'password' => Hash::make($validated['password']),
            'role' => $validated['role'],
        ]);

        return redirect()
            ->route('users.index')
            ->with('success', 'User account created successfully.');
    }


    /**
     * Show edit form.
     */
    public function edit(User $user)
    {
        return view('users.edit', compact('user'));
    }


    /**
     * Update user.
     */
    public function update(Request $request, User $user)
    {
        $validated = $request->validate([
            'name' => [
                'required',
                'string',
                'max:255',
            ],

            'email' => [
                'required',
                'email',
                'max:255',
                Rule::unique('users', 'email')->ignore($user->id),
            ],

            'role' => [
                'required',
                Rule::in([
                    'admin',
                    'management',
                    'staff',
                ]),
            ],

            'password' => [
                'nullable',
                'string',
                'min:8',
                'confirmed',
            ],
        ]);

        /*
         * Prevent admin from accidentally changing
         * their own account to another role.
         */
        if (
            auth()->id() === $user->id &&
            $validated['role'] !== 'admin'
        ) {
            return back()
                ->withInput()
                ->with('error', 'You cannot remove your own administrator role.');
        }

        $user->name = $validated['name'];
        $user->email = $validated['email'];
        $user->role = $validated['role'];

        if (!empty($validated['password'])) {
            $user->password = Hash::make($validated['password']);
        }

        $user->save();

        return redirect()
            ->route('users.index')
            ->with('success', 'User account updated successfully.');
    }


    /**
     * Delete user.
     */
    public function destroy(User $user)
    {
        /*
         * Never allow an admin to delete themselves.
         */
        if (auth()->id() === $user->id) {
            return back()
                ->with('error', 'You cannot delete your own account.');
        }

        $user->delete();

        return redirect()
            ->route('users.index')
            ->with('success', 'User account deleted successfully.');
    }
}