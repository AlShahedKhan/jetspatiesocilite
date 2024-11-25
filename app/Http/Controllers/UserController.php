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

        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
        ]);

        // Debugging Guards
        foreach ($request->roles as $roleName) {
            $role = Role::where('name', $roleName)->where('guard_name', 'sanctum')->first();
            if ($role) {
                Log::info("Assigning role to user:", [
                    'role' => $role->name,
                    'role_guard' => $role->guard_name,
                    'user_guard' => 'sanctum', // Explicitly stating the user guard
                ]);

                // Assign role if guards match
                $user->assignRole($role);
            } else {
                Log::error("Role not found or guard mismatch:", ['role_name' => $roleName]);
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
