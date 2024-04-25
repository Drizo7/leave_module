<?php

namespace App\Http\Controllers;

use App\Models\EmployeeLeave;
use App\Models\AdminLeave;
use App\Models\Leavetype;
use Illuminate\Http\Request;
use Inertia\Inertia;
use Illuminate\Support\Facades\Auth;

class EmployeeLeaveController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Inertia\Response
     */
    public function index()
    {
        $leaves = Auth::user()->employeeLeaves()->get();

        $pendingLeaves = $leaves->where('status', 'pending')->count();
        $approvedLeaves = $leaves->where('status', 'approved')->count();
        $rejectedLeaves = $leaves->where('status', 'rejected')->count(); 
        
        \Log::info('Pending Leaves: ' . $pendingLeaves);
        \Log::info('Approved Leaves: ' . $approvedLeaves);
        \Log::info('Rejected Leaves: ' . $rejectedLeaves);

        return Inertia::render('Leave/Index', [
            'leaves' => $leaves->toArray(),
            'pageName' => 'Leave Requests',
            'pendingLeaves' => $pendingLeaves,
            'approvedLeaves' => $approvedLeaves,
            'rejectedLeaves' => $rejectedLeaves,
            'message' => session('message'),
        ]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Inertia\Response
     */
    public function create()
    {
        $leaveTypes = Leavetype::all();

        return Inertia::render('Leave/Apply', [
            'pageName' => 'Apply for Leave',
            'leaveTypes' => $leaveTypes,
        ]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function store(Request $request)
    {
        // Validate the incoming request data
        $validatedData = $request->validate([
            'type' => 'required',
            'start_date' => 'required|date',
            'end_date' => 'required|date|after_or_equal:start_date',
            'reason' => 'required',
        ]);

        // Add the authenticated user's ID to the validated data
        $validatedData['user_id'] = Auth::id();

        $validatedData['leave_id'] = EmployeeLeave::max('leave_id') + 1;

        // Create an EmployeeLeave record
        $employeeLeave = EmployeeLeave::create($validatedData);

        // Create an AdminLeave record corresponding to the EmployeeLeave
        AdminLeave::create([
            'employee_id' => $employeeLeave->user_id,
            'leave_id' => $employeeLeave->id,
            'type' => $employeeLeave->type,
            'start_date' => $employeeLeave->start_date,
            'end_date' => $employeeLeave->end_date,
            'reason' => $employeeLeave->reason,
            'status' => 'pending',
        ]);

        // Redirect the user to the index page for employee leaves
        return redirect()->route('employee-leaves.index')->with('message', 'Leave was applied successfully.');
    }

}