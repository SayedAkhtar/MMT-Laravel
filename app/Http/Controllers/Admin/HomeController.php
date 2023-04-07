<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class HomeController extends Controller
{
    public function index(Request $request)
    {
        if (!Auth::check()) {
            return redirect(route('login'));
        } else {
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

    public function ajaxSearch(string $table, Request $request)
    {
        $column = $request->get('column') ?? 'name';
        $term = $request->get('term');
        try {
            if ($table == 'doctors') {
                return response()->json(["data" => User::query()->join('doctors', 'doctors.user_id', 'users.id')->selectRaw("doctors.id as id, $column as name")->where($column, 'like', '%' . $term . '%')->limit(10)->get()->toArray()]);
            }
            return response()->json(["data" => DB::table($table)->selectRaw("id, $column as name")->where($column, 'like', '%' . $term . '%')->limit(10)->get()->toArray()]);
        } catch (\Exception $e) {
        }
        return response()->json(["data" => []])->status(404);
    }
}
