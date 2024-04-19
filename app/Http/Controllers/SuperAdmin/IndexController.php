<?php

namespace App\Http\Controllers\SuperAdmin;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Models\Department;
use App\Models\Leavetype;
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
        return Inertia::render('SuperAdmin/Index', [
            'pageName' => 'Super Admin Dashboard',
            'totalEmployees' => $totalEmployees,
            'totalDepartments' => $totalDepartments,
            'totalLeavetypes' => $totalLeavtypes,
            'users' => $users,]);
    }
}
