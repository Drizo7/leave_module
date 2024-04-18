<?php

namespace App\Http\Controllers\SuperAdmin;

use App\Http\Controllers\Controller;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Inertia\Response;
use Inertia\Inertia;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;

class PermissionController extends Controller
{
    public function index(): Response
    {
        $permissions = Permission::all();
        return Inertia::render('SuperAdmin/Permissions/Index', [
            'pageName' => 'Permissions',
            'permissions' => $permissions,
        ]);
    }

    public function create(): Response
    {
        return Inertia::render('SuperAdmin/Permissions/Create', [
            'pageName' => 'Create Permissions',
        ]);
    }

    public function store(Request $request): RedirectResponse
    {
        $validated = $request->validate([
            'name' => 'required|string|min:3',
        ]);

        $permission = Permission::create($validated);

        return redirect()->route('admin.permissions.index')->with('message', 'Permission created.');
    }

    public function edit(Permission $permission): Response
    {
        $roles = Role::all();
        return Inertia::render('SuperAdmin/Permissions/Edit', [
            'permission' => $permission,
            'roles' => $roles,
        ]);
    }

    public function update(Request $request, Permission $permission): RedirectResponse
    {
        $validated = $request->validate([
            'name' => 'required|string|min:3',
        ]);

        $permission->update($validated);

        return redirect()->route('admin.permissions.index')->with('message', 'Permission updated.');
    }

    public function destroy(Permission $permission): RedirectResponse
    {
        $permission->delete();
        return back()->with('message', 'Permission deleted.');
    }

    public function assignRole(Request $request, Permission $permission): RedirectResponse
    {
        if ($permission->hasRole($request->role)) {
            return back()->with('message', 'Role exists.');
        }

        $permission->assignRole($request->role);

        return back()->with('message', 'Role assigned.');
    }

    public function removeRole(Permission $permission, Role $role): RedirectResponse
    {
        if ($permission->hasRole($role)) {
            $permission->removeRole($role);
            return back()->with('message', 'Role removed.');
        }

        return back()->with('message', 'Role does not exist.');
    }
}
