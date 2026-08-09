<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\{ContactMessage, Course, Enrollment};
use App\Services\StatsService;

class DashboardController extends Controller
{

    public function index()
    {
      

        return view('admin.dashboard');
    }
}
