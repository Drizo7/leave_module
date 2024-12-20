<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Department;
use Illuminate\Http\Request;
use Inertia\Response;
use Inertia\Inertia;
use Illuminate\Support\Facades\Gate;
use Illuminate\Http\RedirectResponse;

class AdminDepartmentController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $departments = Department::all();
        return Inertia::render('Admin/Departments/Index', [
            'pageName' => 'Departments ',
            'departments' => $departments,
            'message' => session('message'),
        ]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return Inertia::render('Admin/Departments/Create', [
            'pageName' => 'Create Departments',
        ]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request): RedirectResponse
    {
        $validated = $request->validate([
            'name' => 'required|string|min:3',
            'shortcode' => 'required|string|min:2',
            'hod' => 'required|string|min:2',
        ]);
 
        Department::create($validated);
 
        return redirect()->route('normaladmin.departments.index')->with('message', 'Department was created successfully!');
    }

    /**
     * Display the specified resource.
     */
    public function show(Department $department)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Department $department)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Department $department)
    {
        $validated = $request->validate([
            'name' => ['required', 'min:3'],
        ]);

        $department->update($validated);

        return redirect()->route('normaladmin.departments.index')->with('message', 'Department was updated successfully.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Department $department): RedirectResponse
    {
        Gate::authorize('delete', $department);

        $department->delete();
        return redirect()->route('normaladmin.departments.index')->with('message', 'Department was deleted successfully.');
    }
}
