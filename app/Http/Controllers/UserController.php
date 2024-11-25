<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Spatie\Permission\Models\Role;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Hash;

class UserController extends Controller
{
    public function index()
    {
        $users = User::all();
        return view('role-permission.users.index', [
            'users' => $users
        ]);
    }

    public function create()
    {
        $roles = Role::all();

        return view('role-permission.users.create', [
            'roles' => $roles
        ]);
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:users',
            'password' => 'required|string|min:8|max:255',
            'roles' => 'required|array',
            'roles.*' => 'exists:roles,name',
        ]);

        // Check if trying to assign a super-admin role
        if (in_array('super-admin', $request->roles)) {
            // Ensure only a super-admin can assign the super-admin role
            if (!auth()->user()->hasRole('super-admin')) {
                return redirect('/users')->with('status', 'Only a Super Admin can assign the Super Admin role.');
            }
        }

        // Create the user
        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
        ]);

        // Assign roles to the user
        foreach ($request->roles as $roleName) {
            $role = Role::where('name', $roleName)->where('guard_name', 'sanctum')->first();
            if ($role) {
                $user->assignRole($role);
            }
        }

        return redirect('/users')->with('status', 'User created successfully with roles');
    }


    public function edit(User $user)
    {
        $roles = Role::all();
        $userRoles = $user->roles->pluck('name')->all();
        return view('role-permission.users.edit', [
            'user' => $user,
            'roles' => $roles,
            'userRoles' => $userRoles
        ]);
    }

    public function update(Request $request, User $user)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:users,email,' . $user->id,
            'password' => 'nullable|string|min:8|max:255',
            'roles' => 'required|array',
            'roles.*' => 'exists:roles,name',
        ]);

        // Check if trying to update a super-admin
        if ($user->hasRole('super-admin')) {
            if (!auth()->user()->hasRole('super-admin')) {
                return redirect('/users')->with('status', 'Only a Super Admin can update another Super Admin.');
            }
        }

        $data = [
            'name' => $request->name,
            'email' => $request->email,
        ];

        if (!empty($request->password)) {
            $data['password'] = Hash::make($request->password);
        }

        // Update user
        $user->update($data);

        // Sync roles with the sanctum guard
        $roles = Role::whereIn('name', $request->roles)
            ->where('guard_name', 'sanctum')
            ->pluck('name')
            ->toArray();

        $user->syncRoles($roles);

        return redirect('/users')->with('status', 'User updated successfully with roles');
    }

    public function destroy(User $user)
    {
        // Prevent deletion of super-admins by non-super-admins
        if ($user->hasRole('super-admin') && !auth()->user()->hasRole('super-admin')) {
            return redirect('/users')->with('status', 'You cannot delete a super-admin user.');
        }

        // Proceed with deletion
        $user->delete();

        return redirect('/users')->with('status', 'User deleted successfully');
    }
}
