<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Inertia\Response;
use Illuminate\Http\Request;
use Inertia\Inertia;

class AdminIndexController extends Controller
{
    public function index(): Response 
    {
        return Inertia::render('Admin/Dashboard', [
            'pageName' => 'Admin Dashboard',]);
    }
}
