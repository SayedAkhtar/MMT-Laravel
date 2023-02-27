<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Arr;
use Illuminate\Support\Facades\Auth;

class HomeController extends Controller
{
    public function index(Request $request)
    {
        if(!Auth::check()){
            return redirect(route('login'));
        }else {
            return redirect(route('dashboard'));
        }
    }

    public function dashboard()
    {
        return view('dashboard');
    }

    public function profile()
    {
        $user = User::find(Auth::id());
        $roles = implode(',', $user->getRoleNames()->toArray());
        return view('module/user/index', compact('user', 'roles'));
    }
}
