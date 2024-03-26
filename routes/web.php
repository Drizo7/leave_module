<?php

use App\Http\Controllers\ChirpController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\Api\DirectoryController;
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
    return Inertia::render('Dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

Route::get('/employees', function () {
    return Inertia::render('Employees');
})->middleware(['auth', 'verified'])->name('employees');

Route::get('/departments', function () {
    return Inertia::render('Departments');
})->middleware(['auth', 'verified'])->name('departments');

Route::get('/leavetypes', function () {
    return Inertia::render('Leavetypes');
})->middleware(['auth', 'verified'])->name('leavetypes');

Route::get('/employeeform', function () {
    return Inertia::render('Forms/AddEmployeeForm');
})->middleware(['auth', 'verified'])->name('employeeform');

Route::get('/departmentform', function () {
    return Inertia::render('Forms/AddDepartmentForm');
})->middleware(['auth', 'verified'])->name('departmentform');

Route::get('/leavetypeform', function () {
    return Inertia::render('Forms/AddLeaveTypeForm');
})->middleware(['auth', 'verified'])->name('leavetypeform');

Route::resource('chirps', ChirpController::class)
    ->only(['index', 'store', 'update', 'destroy'])
    ->middleware(['auth', 'verified']);

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

require __DIR__.'/auth.php';
