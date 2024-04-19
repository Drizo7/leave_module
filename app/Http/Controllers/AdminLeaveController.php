<?php

namespace App\Http\Controllers;

use App\Models\AdminLeave;
use Illuminate\Http\Request;
use Inertia\Inertia;
use Illuminate\Support\Facades\Auth;

class AdminLeaveController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Inertia\Response
     */
    public function index()
    {
        $leaves = AdminLeave::with('employeeLeave.user', 'approver')->get();

        \Log::info('Retrieved leaves:', $leaves->toArray());

            return Inertia::render('Admin/Leave/Index', [
                'leaves' => $leaves->toArray(),
                'pageName' => 'Leave Requests',
            ]);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\AdminLeave  $adminLeave
     * @return \Inertia\Response
     */
    public function show(AdminLeave $adminLeave)
    {
        return Inertia::render('Admin/LeaveShow', [
            'leave' => $adminLeave->load('employee', 'approver')->toArray(),
        ]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\AdminLeave  $adminLeave
     * @return \Illuminate\Http\RedirectResponse
     */
    public function update(Request $request, AdminLeave $adminLeave)
    {
        $validatedData = $request->validate([
            'status' => 'required|in:pending,approved,rejected',
            'approver_id' => 'required|exists:users,id',
        ]);

        $adminLeave->update($validatedData);

        return redirect()->route('normaladmin.leaves.index');
    }

    /**
     * Approve the specified leave request.
     *
     * @param  \App\Models\AdminLeave  $adminLeave
     * @return \Illuminate\Http\RedirectResponse
     */
    public function approve(AdminLeave $adminLeave)
    {
        $adminLeave->update([
            'status' => 'approved',
            'approver_id' => Auth::id(),
        ]);

        return redirect()->route('normaladmin.leaves.index');
    }

    /**
     * Reject the specified leave request.
     *
     * @param  \App\Models\AdminLeave  $adminLeave
     * @return \Illuminate\Http\RedirectResponse
     */
    public function reject(AdminLeave $adminLeave)
    {
        $adminLeave->update([
            'status' => 'rejected',
            'approver_id' => Auth::id(),
        ]);

        return redirect()->route('normaladmin.leaves.index');
    }
}