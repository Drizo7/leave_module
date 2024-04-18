<?php

namespace App\Http\Controllers\SuperAdmin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Gate;
use Inertia\Response;
use Inertia\Inertia;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;

class RoleController extends Controller
{
    public function index(): Response 
    {
        $roles = Role::all();
        return Inertia::render('SuperAdmin/Roles/Index', [
            'pageName' => 'Roles ',
            'roles' => $roles,
        ]);
    }
    
    public function create(): Response
    {
        return Inertia::render('SuperAdmin/Roles/Create', [
            'pageName' => 'Create Roles',
        ]);
    }
    
    public function store(Request $request): RedirectResponse
    {
        $validated = $request->validate([
            'name' => 'required|string|min:3',
        ]);
 
        Role::create($validated);
 
        return redirect(route('admin.roles.index'));
    }
    
    public function edit(Role $role): Response
    {
        $permissions = Permission::all();
        return Inertia::render('SuperAdmin/Roles/Edit', [
            'role' => $role,
            'permissions' => $permissions,
        ]);
    }

    public function update(Request $request, Role $role): RedirectResponse
    {
        $validated = $request->validate([
            'name' => ['required', 'min:3'],
        ]);

        $role->update($validated);

        return redirect()->route('admin.roles.index')->with('message', 'Role Updated successfully.');
    }

    public function destroy(Role $role): RedirectResponse
    {
        Gate::authorize('delete', $role);

        $role->delete();
        return redirect()->route('admin.roles.index');
    }

    public function givePermission(Request $request, Role $role): RedirectResponse
    {


        if ($role->hasPermissionTo($request->permission)) {
            return back()->with('message', 'Permission exists.');
        }

        $role->givePermissionTo($request->permission);


        return back()->with('message', 'Permission added.');
    }

    public function revokePermission(Role $role, Permission $permission): RedirectResponse
    {

        if ($role->hasPermissionTo($permission)) {
            $role->revokePermissionTo($permission);
            return back()->with('message', 'Permission revoked.');
        }

        return back()->with('message', 'Permission not exists.');
    }

}


    /* public function edit(Role $role): Response
    {
        return Inertia::render('SuperAdmin/Roles/Edit', [
            'pageName' => 'Edit Role',
            'role' => $role,
        ]);
    }
    public function update(Request $request, Role $role): RedirectResponse
        {
            $validated = $request->validate([
                'name' => 'required|string|min:3',
            ]);

            $role->update($validated);

            return redirect(route('admin.Roles/Index'));
        } */