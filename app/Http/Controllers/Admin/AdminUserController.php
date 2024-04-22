<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Inertia\Response;
use Inertia\Inertia;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;
use Illuminate\Http\RedirectResponse;

class AdminUserController extends Controller
{
    public function index()
    {
        $users = User::all();
        return Inertia::render('Admin/Employees/Index', [
            'pageName' => 'Employees ',
            'users' => $users,
        ]);
    }

    public function show(User $user)
    {
        \Log::info('Retrieved user:', $user->toArray());

        return Inertia::render('Admin/Employees/Show', [
            'user' => $user->toArray(),
        ]);
    }

    public function assignRole(Request $request, User $user): RedirectResponse
    {
        if ($user->hasRole($request->role)) {
            return redirect()->back()->with('message', 'Role exists.');
        }

        $user->assignRole($request->role);
        return redirect()->back()->with('message', 'Role assigned.');
    }

    public function removeRole(User $user, Role $role): RedirectResponse
    {
        if ($user->hasRole($role)) {
            $user->removeRole($role);
            return redirect()->back()->with('message', 'Role removed.');
        }

        return redirect()->back()->with('message', 'Role not exists.');
    }

    public function givePermission(Request $request, User $user): RedirectResponse
    {
        if ($user->hasPermissionTo($request->permission)) {
            return redirect()->back()->with('message', 'Permission exists.');
        }

        $user->givePermissionTo($request->permission);
        return redirect()->back()->with('message', 'Permission added.');
    }

    public function revokePermission(User $user, Permission $permission): RedirectResponse
    {
        if ($user->hasPermissionTo($permission)) {
            $user->revokePermissionTo($permission);
            return redirect()->back()->with('message', 'Permission revoked.');
        }

        return redirect()->back()->with('message', 'Permission does not exists.');
    }

    public function destroy(User $user): RedirectResponse
    {
        if ($user->hasRole('admin')) {
            return redirect()->back()->with('message', 'You are an admin and cannot be deleted.');
        }

        $user->delete();
        return redirect()->back()->with('message', 'User deleted.');
    }
}
