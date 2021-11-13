<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Employee;
use App\Models\Position;
use App\Models\Presence;
use App\Models\User;

class DashboardController extends Controller
{
    public function index()
    {
        return view('dashboard.index', [
            'employee' => Employee::count(),
            'position' => Position::count(),
            'presence' => Presence::count(),
            'user' => User::count()
        ]);
    }
}
