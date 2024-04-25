<?php

namespace App\Http\Controllers\SuperAdmin;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Models\Department;
use App\Models\Leavetype;
use App\Models\AdminLeave;
use Inertia\Response;
use Inertia\Inertia;
use Illuminate\Http\Request;

class IndexController extends Controller
{
    public function index(): Response 
    {
        $totalEmployees = User::count();
        $totalDepartments = Department::count();
        $totalLeavtypes = Leavetype::count();
        $users = User::all();

        $leaves = AdminLeave::with('employeeLeave.user', 'approver')->get();

        $pendingLeaves = $leaves->where('status', 'pending')->count();
        $approvedLeaves = $leaves->where('status', 'approved')->count();
        $rejectedLeaves = $leaves->where('status', 'rejected')->count(); 

        return Inertia::render('SuperAdmin/Index', [
            'pageName' => 'Super Admin Dashboard',
            'totalEmployees' => $totalEmployees,
            'totalDepartments' => $totalDepartments,
            'totalLeavetypes' => $totalLeavtypes,
            'pendingLeaves' => $pendingLeaves,
            'approvedLeaves' => $approvedLeaves,
            'rejectedLeaves' => $rejectedLeaves,
            'users' => $users,]);
    }
}
