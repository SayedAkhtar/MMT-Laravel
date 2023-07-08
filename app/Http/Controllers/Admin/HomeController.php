<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Settings;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;
use LaravelDaily\LaravelCharts\Classes\LaravelChart;


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
        $chart_options = [
            'chart_title' => 'Users by months',
            'report_type' => 'group_by_date',
            'model' => 'App\Models\User',
            'group_by_field' => 'created_at',
            'group_by_period' => 'month',
            'chart_type' => 'bar',
        ];
        $chart1 = new LaravelChart($chart_options);

        return view('dashboard', compact('chart1'));
    }

    public function profile()
    {
        $user = User::find(Auth::id());
        $roles = implode(',', $user->getRoleNames()->toArray());
        return view('module/user/index', compact('user', 'roles'));
    }

    public function settings()
    {
        $settings = Settings::all();
        $transformedSettings = [];
        foreach ($settings as $setting) {
            if (in_array($setting['name'], ['hcf_english', 'hcf_russian', 'hcf_hindi', 'hcf_arabic'])) {
                $transformedSettings[$setting['name']] = User::where('id', $setting['value'])->first();
            } else {
                $transformedSettings[$setting['name']] = $setting['value'];
            }
        }
        return view('module/settings/index', ['settings' => $transformedSettings]);
    }

    public function ajaxSearch(string $table, Request $request)
    {
        $column = $request->get('column') ?? 'name';
        $term = $request->get('term');
        try {
            if ($table == 'doctors') {
                return response()->json(["data" => User::query()
                    ->join('doctors', 'doctors.user_id', 'users.id')
                    ->selectRaw("doctors.id as id, $column as name")
                    ->where($column, 'like', '%' . $term . '%')
                    ->where('doctors.is_active', true)
                    ->get()->toArray()]);
            }
            if ($table == 'patient') {
                return response()->json(["data" => User::query()
                    ->selectRaw("id, $column as name")
                    ->where($column, 'like', '%' . $term . '%')
                    ->where('user_type', User::TYPE_USER)
                    ->get()->toArray()]);
            }
            if ($table == 'hcf') {
                return response()->json(["data" => User::query()
                    ->selectRaw("id, $column as name")
                    ->where($column, 'like', '%' . $term . '%')
                    ->where('user_type', User::TYPE_HCF)
                    ->get()->toArray()]);
            }
            if ($table == 'states') {
                return response()->json(["data" => DB::table('states')
                    ->selectRaw("id, $column as name")
                    ->when($request->has('country_id'), function ($q) use ($request) {
                        if (count(explode(',', $request->country_id)) > 0) {
                            $q->whereIn('country_id', explode(',', $request->country_id));
                        } else {
                            $q->where('country_id', '=', $request->country_id);
                        }
                    })
                    ->where($column, 'like', '%' . $term . '%')
                    ->when(Schema::hasColumn($table, 'is_active'), function ($q) {
                        $q->where('is_active', true);
                    })
                    ->get()->toArray()]);
            }
            if ($table == 'cities') {
                return response()->json(["data" => DB::table('cities')
                    ->selectRaw("id, $column as name")
                    ->when($request->has('country_id'), function ($q) use ($request) {
                        if (count(explode(',', $request->country_id)) > 0) {
                            $q->whereIn('country_id', explode(',', $request->country_id));
                        } else {
                            $q->where('country_id', '=', $request->country_id);
                        }
                    })
                    ->when(!empty($request->state_id), function ($q) use ($request) {
                        if (count(explode(',', $request->state_id)) > 0) {
                            $q->whereIn('state_id', explode(',', $request->state_id));
                        } else {
                            $q->where('state_id', '=', $request->state_id);
                        }
                    })
                    ->where($column, 'like', '%' . $term . '%')
                    ->when(Schema::hasColumn($table, 'is_active'), function ($q) {
                        $q->where('is_active', true);
                    })
                    ->get()->toArray()]);
            }
            return response()->json(["data" => DB::table($table)
                ->selectRaw("id, $column as name")
                ->where($column, 'like', '%' . $term . '%')
                ->when(($request->has('patient_id') && !empty($request->patient_id)), function ($q) use ($request, $table) {
                    if(Schema::hasColumn($table, 'patient_id')) {
                        $q->where('patient_id', $request->patient_id);
                    }
                })
                ->when(Schema::hasColumn($table, 'is_active'), function ($q) {
                    $q->where('is_active', true);
                })
                ->get()->toArray()]);
        } catch (\Exception $e) {
            dump($e->getMessage());
        }
        return response()->json(["data" => []])->status(404);
    }

    public function privacyPolicy(){
        return view('module.settings.privacy-policy');
    }
}
