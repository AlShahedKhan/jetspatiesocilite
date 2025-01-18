<?php

namespace App\Traits;

use Illuminate\Support\Facades\DB;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;
use App\Http\Requests\givePermissionToRoleRequest;

trait RoleTrait
{
    public function addPermissionToRole(Role $role)
    {
        $permission = Permission::all();

         // Check if the role is 'super-admin'
        //  if ($role->name === 'super-admin') {
        //     // Only allow super-admin to modify super-admin role permissions
        //     if (!auth()->user()->hasRole('super-admin')) {
        //         return redirect('/roles')->with('status', 'Only a Super Admin can manage Super Admin role permissions.');
        //     }
        // }

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

    public function givePermissionToRole(givePermissionToRoleRequest $request, Role $role)
    {
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
