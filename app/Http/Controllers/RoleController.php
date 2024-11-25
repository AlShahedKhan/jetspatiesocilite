<?php

namespace App\Http\Controllers;

use App\Http\Requests\RoleRequest;
use App\Interfaces\CRUDinterface;
use App\Traits\RoleTrait;
use Spatie\Permission\Models\Role;

class RoleController extends Controller 
{
    use RoleTrait;
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

    public function store(RoleRequest $roleRequest)
    {
        $role = Role::create([
            'name' => $roleRequest->name
        ]);

        return redirect('roles')->with('status', 'Role created successfully');
    }

    public function edit(Role $role)
    {
        return view('role-permission.roles.edit', [
            'role' => $role
        ]);
    }

    public function update(RoleRequest $roleRequest, Role $role)
    {
        $role->update([
            'name' => $roleRequest->name
        ]);

        return redirect('roles')->with('status', 'Role Updated successfully');
    }

    public function destroy(Role $role)
    {
        $role->delete();
        return redirect('roles')->with('status', 'Role Deleted successfully');
    }
}
