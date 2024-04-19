<?php

use App\Http\Controllers\ChirpController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\AdminLeaveController;
use App\Http\Controllers\EmployeeLeaveController;
use App\Http\Controllers\Api\DirectoryController;
use App\Http\Controllers\SuperAdmin\IndexController;
use App\Http\Controllers\Admin\AdminIndexController;
use App\Http\Controllers\Admin\AdminDepartmentController;
use App\Http\Controllers\Admin\AdminUserController;
use App\Http\Controllers\Admin\AdminLeavetypeController;
use App\Http\Controllers\SuperAdmin\DepartmentController;
use App\Http\Controllers\SuperAdmin\UserController;
use App\Http\Controllers\SuperAdmin\LeaveController;
use App\Http\Controllers\SuperAdmin\LeavetypeController;
use App\Http\Controllers\SuperAdmin\PermissionController;
use App\Http\Controllers\SuperAdmin\RoleController;
use Illuminate\Foundation\Application;
use Illuminate\Support\Facades\Route;
use Inertia\Inertia;

Route::get('/', function () {
    return Inertia::render('Welcome', [
        'canLogin' => Route::has('login'),
        'canRegister' => Route::has('register'),
        'laravelVersion' => Application::VERSION,
        'phpVersion' => PHP_VERSION,
    ]);
});

Route::get('/dashboard', function () {
    return Inertia::render('Dashboard', [
        'pageName' => 'Dashboard',
    ]);
})->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth', 'verified')
    ->group(function () {
        Route::resource('employee-leaves', EmployeeLeaveController::class);
    });

Route::middleware(['auth', 'role:admin'])
    ->name('normaladmin.')
    ->prefix('normaladmin')
    ->group(function() {
        Route::get('/admindashboard', [AdminIndexController::class, 'index'])->name('index');

        Route::resource('leaves', AdminLeaveController::class);
        Route::post('leaves/{adminLeave}/approve', [AdminLeaveController::class, 'approve'])->name('admin-leaves.approve');
        Route::post('leaves/{adminLeave}/reject', [AdminLeaveController::class, 'reject'])->name('admin-leaves.reject');

        Route::resource('adminusers', AdminUserController::class)->names([
            'index' => 'users.index',
            'destroy' => 'users.destroy',
        ]);
        Route::get('/users/{user}', [AdminUserController::class, 'show'])->name('users.show');/* 
        Route::delete('/users/{user}', [UserController::class, 'destroy'])->name('users.destroy'); */
    
        Route::resource('admindepartments', AdminDepartmentController::class)->names([
            'index' => 'departments.index',
            'create' => 'departments.create',
            'store' => 'departments.store',
            'show' => 'departments.show',
            'edit' => 'departments.edit',
            'update' => 'departments.update',
            'destroy' => 'departments.destroy',
        ]);
        Route::resource('adminleavetypes', AdminLeavetypeController::class)->names([
            'index' => 'leavetypes.index',
            'create' => 'leavetypes.create',
            'store' => 'leavetypes.store',
            'show' => 'leavetypes.show',
            'edit' => 'leavetypes.edit',
            'update' => 'leavetypes.update',
            'destroy' => 'leavetypes.destroy',
        ]);
        
    }); 


 Route::middleware(['auth', 'role:super-admin'])
    ->name('admin.')
    ->prefix('admin')
    ->group(function() {
        Route::get('/', [IndexController::class, 'index'])->name('index');
        Route::resource('leaves', LeaveController::class);
        Route::post('leaves/{adminLeave}/approve', [LeaveController::class, 'approve'])->name('superadmin-leaves.approve');
        Route::post('leaves/{adminLeave}/reject', [LeaveController::class, 'reject'])->name('superadmin-leaves.reject');

        Route::resource('roles', RoleController::class)->names([
            'index' => 'roles.index',
            'create' => 'roles.create',
            'store' => 'roles.store',
            'show' => 'roles.show',
            'edit' => 'roles.edit',
            'update' => 'roles.update',
            'destroy' => 'roles.destroy',
        ]);
        Route::resource('users', UserController::class)->names([
            'index' => 'users.index',
            'destroy' => 'users.destroy',
        ]);
        Route::get('/users/{user}', [UserController::class, 'show'])->name('users.show');
        Route::post('/users/{user}/assign-role', [UserController::class, 'assignRole'])->name('users.assign-role');
        Route::delete('/users/{user}/remove-role/{role}', [UserController::class, 'removeRole'])->name('users.remove-role');
        Route::post('/users/{user}/give-permission', [UserController::class, 'givePermission'])->name('users.give-permission');
        Route::delete('/users/{user}/revoke-permission/{permission}', [UserController::class, 'revokePermission'])->name('users.revoke-permission');
        Route::delete('/users/{user}', [UserController::class, 'destroy'])->name('users.destroy');
    
        Route::resource('departments', DepartmentController::class)->names([
            'index' => 'departments.index',
            'create' => 'departments.create',
            'store' => 'departments.store',
            'show' => 'departments.show',
            'edit' => 'departments.edit',
            'update' => 'departments.update',
            'destroy' => 'departments.destroy',
        ]);
        Route::resource('leavetypes', LeavetypeController::class)->names([
            'index' => 'leavetypes.index',
            'create' => 'leavetypes.create',
            'store' => 'leavetypes.store',
            'show' => 'leavetypes.show',
            'edit' => 'leavetypes.edit',
            'update' => 'leavetypes.update',
            'destroy' => 'leavetypes.destroy',
        ]);
        Route::resource('permissions', PermissionController::class)->names([
            'index' => 'permissions.index',
            'create' => 'permissions.create',
            'store' => 'permissions.store',
            'show' => 'permissions.show',
            'edit' => 'permissions.edit',
            'update' => 'permissions.update',
            'destroy' => 'permissions.destroy',
        ]);
        Route::post('/roles/{role}/permissions', [RoleController::class, 'givePermission'])->name('roles.permissions');
        Route::delete('/roles/{role}/permissions/{permission}', [RoleController::class, 'revokePermission'])->name('roles.permissions.revoke');
        Route::post('/permissions/{permission}/roles', [PermissionController::class, 'assignRole'])->name('permissions.roles');
        Route::delete('/permissions/{permission}/roles/{role}', [PermissionController::class, 'removeRole'])->name('permissions.roles.remove');
        
    }); 


Route::get('/departments', function () {
    return Inertia::render('SuperAdmin/Departments', [
        'pageName' => 'Departments',
    ]);
})->middleware(['auth', 'verified', 'role:admin|super-admin'])->name('departments');

Route::get('/leavetypes', function () {
    return Inertia::render('SuperAdmin/Leavetypes',[
        'pageName' => 'Leave Types',
    ]);
})->middleware(['auth', 'verified', 'role:admin|super-admin'])->name('leavetypes');

Route::get('/employeeform', function () {
    return Inertia::render('Forms/AddEmployeeForm');
})->middleware(['auth', 'verified', 'role:admin|super-admin'])->name('employeeform');

Route::get('/departmentform', function () {
    return Inertia::render('Forms/AddDepartmentForm');
})->middleware(['auth', 'verified', 'role:admin|super-admin'])->name('departmentform');

Route::get('/leavetypeform', function () {
    return Inertia::render('Forms/AddLeaveTypeForm');
})->middleware(['auth', 'verified', 'role:admin|super-admin'])->name('leavetypeform');

Route::resource('chirps', ChirpController::class)
    ->only(['index', 'store', 'update', 'destroy'])
    ->middleware(['auth', 'verified']);

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

require __DIR__.'/auth.php';


