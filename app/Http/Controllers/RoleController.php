<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;

class RoleController extends Controller
{
    public function index()
    {
        $roles = Role::all();
        return view('role-permission.roles.index', [
            'roles' => $roles
        ]);
    }

    public function create()
    {
        return view('role-permission.roles.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => [
                'required',
                'string',
                'unique:roles,name'
            ]
        ]);

        $role = Role::create([
            'name' => $request->name
        ]);

        return redirect('roles')->with('status', 'Role created successfully');
    }

    public function edit(Role $role)
    {
        return view('role-permission.roles.edit', [
            'role' => $role
        ]);
    }

    public function update(Request $request, Role $role)
    {
        $request->validate([
            'name' => [
                'required',
                'string',
                'unique:roles,name'
            ]
        ]);

        $role->update([
            'name' => $request->name
        ]);

        return redirect('roles')->with('status', 'Role Updated successfully');
    }

    public function destroy(Role $role)
    {
        $role->delete();
        return redirect('roles')->with('status', 'Role Deleted successfully');
    }

    public function addPermissionToRole(Role $role)
    {
        $permission = Permission::all();

        $rolePermissions = DB::table('role_has_permissions')
            ->where('role_has_permissions.role_id', $role->id)
            ->pluck('role_has_permissions.permission_id', 'role_has_permissions.permission_id')
            ->all();

        return view('role-permission.roles.add-permission', [
            'role' => $role,
            'permission' => $permission,
            'rolePermissions' => $rolePermissions
        ]);
    }

    public function givePermissionToRole(Request $request, Role $role)
    {
        $request->validate([
            'permission' => [
                'required',
                'array',
                'exists:permissions,name',
            ],
        ]);

        // Check if the role is 'super-admin'
        if ($role->name === 'super-admin') {
            // Only allow super-admin to modify super-admin role permissions
            if (!auth()->user()->hasRole('super-admin')) {
                return redirect('/roles')->with('status', 'Only a Super Admin can manage Super Admin role permissions.');
            }
        }

        // Assign permissions to the role
        $role->syncPermissions($request->permission);

        return back()->with('status', 'Permission Added to Role successfully');
    }
}
