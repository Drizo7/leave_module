<?php

namespace App\Http\Controllers\SuperAdmin;

use App\Http\Controllers\Controller;
use Inertia\Response;
use Inertia\Inertia;
use Illuminate\Http\Request;

class IndexController extends Controller
{
    public function index(): Response 
    {
        return Inertia::render('SuperAdmin/Index', [
            'pageName' => 'Super Admin Dashboard',]);
    }
}