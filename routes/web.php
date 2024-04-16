<?php

use App\Http\Controllers\ChirpController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\Api\DirectoryController;
use App\Http\Controllers\Admin\IndexController;
use App\Http\Controllers\Admin\PermissionController;
use App\Http\Controllers\Admin\RoleController;
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

Route::get('/admindashboard', function () {
    return Inertia::render('Admin/Dashboard', [
        'pageName' => 'Admin Dashboard',
    ]);
})->middleware(['auth', 'verified', 'role:admin'])->name('admindashboard');

 Route::middleware(['auth', 'role:super-admin'])
    ->name('admin.')
    ->prefix('admin')
    ->group(function() {
        Route::get('/', [IndexController::class, 'index'])->name('index');
        Route::resource('roles', RoleController::class)->names([
            'index' => 'roles.index',
            'create' => 'roles.create',
            'store' => 'roles.store',
            'show' => 'roles.show',
            'edit' => 'roles.edit',
            'update' => 'roles.update',
            'destroy' => 'roles.destroy',
        ]);
        /* Route::get('/createpermissions', [RoleController::class, 'create'])->name('permissions.create');
        Route::post('/storepermissions', [RoleController::class, 'store'])->name('permissions.store'); */
        Route::resource('permissions', PermissionController::class)->names([
            'index' => 'permissions.index',
            'create' => 'permissions.create',
            'store' => 'permissions.store',
            'show' => 'permissions.show',
            'edit' => 'permissions.edit',
            'update' => 'permissions.update',
            'destroy' => 'permissions.destroy',
        ]);
    }); 

Route::get('/employees', function () {
    return Inertia::render('SuperAdmin/Employees', [
        'pageName' => 'Employees',
    ]);
})->middleware(['auth', 'verified', 'role:admin|super-admin'])->name('employees');

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


