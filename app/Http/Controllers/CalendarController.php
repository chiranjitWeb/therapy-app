<?php

namespace App\Http\Controllers;

class CalendarController extends Controller
{
    public function board()
    {
        return view('pages.calendar', ['title' => 'Calendar']);
    }
}

