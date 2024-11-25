<?php

namespace App\Http\Controllers;

use App\Http\Requests\PermissionRequest;
use Spatie\Permission\Models\Permission;

class PermissionController extends Controller
{
    public function index()
    {
        $permissions = Permission::all();
        return view('role-permission.permission.index', [
            'permissions' => $permissions
        ]);
    }

    public function create()
    {
        return view('role-permission.permission.create');
    }

    public function store(PermissionRequest $permissionRequest)
    {
        $permission = Permission::create([
            'name' => $permissionRequest->name
        ]);
        return redirect('permissions')->with('status', 'Permission created successfully');
    }

    public function edit(Permission $permission)
    {
        return view('role-permission.permission.edit', [
            'permission' => $permission
        ]);
    }

    public function update(PermissionRequest $permissionRequest, Permission $permission)
    {
        $permission->update([
            'name' => $permissionRequest->name
        ]);
        return redirect('permissions')->with('status', 'Permission Updated successfully');
    }

    public function destroy(Permission $permission)
    {
        try {
            $permission->delete();
            return redirect('permissions')->with('status', 'Permission Deleted successfully');
        } catch (\Exception $e) {
            \Log::error('Error deleting permission:', ['error' => $e->getMessage()]);
            return redirect('permissions')->with('error', 'Failed to delete permission: ' . $e->getMessage());
        }
    }
}
