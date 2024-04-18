<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Models\Department;
use App\Models\Leavetype;
use Inertia\Response;
use Illuminate\Http\Request;
use Inertia\Inertia;

class AdminIndexController extends Controller
{
    public function index(): Response 
    {
        $totalEmployees = User::count();
        $totalDepartments = Department::count();
        $totalLeavtypes = Leavetype::count();
        return Inertia::render('Admin/Dashboard', [
            'pageName' => 'Admin Dashboard',
            'totalEmployees' => $totalEmployees,
            'totalDepartments' => $totalDepartments,
            'totalLeavetypes' => $totalLeavtypes,]);
    }
}
