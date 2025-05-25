<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Inertia\Inertia;

class PagesController extends Controller
{
    public function home()
    {
        return Inertia::render('Welcome');
    }

    public function dashboard()
    {
        return Inertia::render('Dashboard');
    }
}
