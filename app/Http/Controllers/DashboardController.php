<?php

namespace App\Http\Controllers;

class DashboardController extends Controller
{
    public function index()
    {
        return view('pages.dashboard', ['title' => 'Dashboard']);
    }

    public function redirectToDashboard()
    {
        return redirect()->route('dashboard');
    }
}

