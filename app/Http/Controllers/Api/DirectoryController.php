<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class DirectoryController extends Controller
{
    //
    public function getCurrentDirectory()
    {
        $currentDirectory = getcwd();
        return response()->json($currentDirectory);
    }
}
