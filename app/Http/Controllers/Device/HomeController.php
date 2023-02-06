<?php

namespace App\Http\Controllers\Device;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class HomeController extends Controller
{
    public function index(Request $request)
    {
        return view('static-sign-in');
    }

    public function dashboard()
    {
        return view('dashboard');
    }
}