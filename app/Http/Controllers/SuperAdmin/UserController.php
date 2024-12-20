<?php

namespace App\Http\Controllers\SuperAdmin;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Inertia\Response;
use Inertia\Inertia;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;
use Illuminate\Http\RedirectResponse;

class UserController extends Controller
{
    public function index()
    {
        $users = User::all();
        return Inertia::render('SuperAdmin/Employees/Index', [
            'pageName' => 'Employees ',
            'users' => $users,
            'message' => session('message'),
        ]);
    }

    public function show(User $user)
    {
        return Inertia::render('SuperAdmin/Employees/Roles', [
            'user' => $user->load('roles', 'permissions'),
            'roles' => Role::all(),
            'permissions' => Permission::all(),
        ]);
    }

    public function assignRole(Request $request, User $user): RedirectResponse
    {
        if ($user->hasRole($request->role)) {
            return redirect()->back()->with('message', 'Role already exists.');
        }

        $user->assignRole($request->role);
        return redirect()->back()->with('message', 'Role was assigned successfully.');
    }

    public function removeRole(User $user, Role $role): RedirectResponse
    {
        if ($user->hasRole($role)) {
            $user->removeRole($role);
            return redirect()->back()->with('message', 'Role was removed successfully.');
        }

        return redirect()->back()->with('message', 'Role does not exist.');
    }

    public function givePermission(Request $request, User $user): RedirectResponse
    {
        if ($user->hasPermissionTo($request->permission)) {
            return redirect()->back()->with('message', 'Permission already exists.');
        }

        $user->givePermissionTo($request->permission);
        return redirect()->back()->with('message', 'Permission was added successfully.');
    }

    public function revokePermission(User $user, Permission $permission): RedirectResponse
    {
        if ($user->hasPermissionTo($permission)) {
            $user->revokePermissionTo($permission);
            return redirect()->back()->with('message', 'Permission was revoked successfully.');
        }

        return redirect()->back()->with('message', 'Permission does not exists.');
    }

    public function destroy(User $user): RedirectResponse
    {
        if ($user->hasRole('admin')) {
            return redirect()->back()->with('message', 'You are an admin and cannot be deleted.');
        }

        $user->delete();
        return redirect()->back()->with('message', 'User was deleted successfully.');
    }
}
