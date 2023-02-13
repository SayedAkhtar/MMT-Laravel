<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class HomeController extends Controller
{
    public function index(Request $request)
    {
//        if(!auth()){
//            return redirect(route('login'));
//        }else{
//            return redirect(route('dashboard'));
//        }
        return "hello";
    }

    public function dashboard()
    {
        return view('dashboard');
    }
}