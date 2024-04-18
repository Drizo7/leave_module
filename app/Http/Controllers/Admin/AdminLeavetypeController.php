<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Leavetype;
use Illuminate\Http\Request;
use Inertia\Response;
use Inertia\Inertia;
use Illuminate\Http\RedirectResponse;

class AdminLeavetypeController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $leavetypes = Leavetype::all();
        return Inertia::render('Admin/Leavetypes/Index', [
            'pageName' => 'Leavetypes ',
            'leavetypes' => $leavetypes,
        ]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return Inertia::render('Admin/Leavetypes/Create', [
            'pageName' => 'Create Leavetypes',
        ]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|min:3',
            'description' => 'required|string|min:2',
        ]);
 
        Leavetype::create($validated);
 
        return redirect(route('normaladmin.leavetypes.index'));
    }

    /**
     * Display the specified resource.
     */
    public function show(Leavetype $leavetype)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Leavetype $leavetype)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Leavetype $leavetype)
    {
        $validated = $request->validate([
            'name' => ['required', 'min:3'],
        ]);

        $leavetype->update($validated);

        return redirect()->route('normaladmin.leavetypes.index')->with('message', 'Leavetype updated successfully.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Leavetype $leavetype)
    {
        Gate::authorize('delete', $leavetype);

        $leavetype->delete();
        return redirect()->route('normaladmin.leavetypes.index');
    }
}
