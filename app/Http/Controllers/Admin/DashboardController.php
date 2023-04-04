<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Middleware\EnsureAdminIsVerified;


class DashboardController extends Controller
{
    
    public function __construct()
    {
    
       $this-> middleware(['auth:admin', EnsureAdminIsVerified::class]);
    }

    public function index()
    {
        return view('admin.dashboard');
    }
}

