<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Doctor;
use App\Models\Hospital;
use App\Models\PatientDetails;
use App\Models\Query;
use App\Models\QueryResponse;
use App\Models\Settings;
use App\Models\Specialization;
use App\Models\User;
use App\Models\VideoConsultation;
use App\Notifications\FirebaseNotification;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;
use Kreait\Firebase\Messaging\CloudMessage;
use Kreait\Firebase\Messaging\Notification;
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
        $total_hospitals = Hospital::count();
        $total_doctors = Doctor::count();
        $open_queries = Query::where('is_completed', 0)->where('current_step', 1)->count();
        $active_queries = Query::where('is_completed', 0)->where('current_step', '>', 1)->count();
        $confirmed_queries = Query::query()->where('confirmed_details', '!=', null)->count();
        $closed_queries = Query::where('is_completed', 1)->count();
        $teleconsultation = VideoConsultation::where('payment_status', 'completed')->count();
        $active_teleconsultation = VideoConsultation::where('payment_status', 'completed')->where('is_active', 1)->where('is_completed', 0)->count();
        $specializations = Specialization::count();
        $ticket_confirmation = QueryResponse::where('step', 5)
                                ->whereNotNull('response')
                                ->get()
                                ->each(function($response){
                                    $r = json_decode($response, true);
                                    if(!empty($r['tickets'])){
                                        return true;
                                    }
                                })->count();
        $last_queries = Query::latest()->take(10)->get();
        $new_users = User::where('user_type', User::TYPE_USER)->whereDate('created_at', '>', date('d-m-Y', strtotime('-3 months')))->get()->count();
        // $vil_count
        $user_chart_options = [
            'chart_title' => 'Users by months',
            'report_type' => 'group_by_date',
            'model' => 'App\Models\User',
            'group_by_field' => 'created_at',
            'group_by_period' => 'month',
            'chart_type' => 'bar',
        ];
        $user_chart = new LaravelChart($user_chart_options);
        $city_query_count = ['Not Specified' => 0];
        $country_query_count = ['Not Specified' => 0];
        //->whereMonth('created_at', '>', date('m', strtotime('-3 month')))
        $query = Query::with('responses')->get();
        foreach($query as $q){
            $v = $q->responses->where('step', 3)->first();
            if(!empty($v['response'])){
                $res = json_decode($v['response'], true);
                if(empty($city_query_count[$res['city']])){
                    $city_query_count[$res['city']] = 1;
                }else{
                    $city_query_count[$res['city']] = $city_query_count[$res['city']]+1;
                }
                if(empty($country_query_count[$res['country']])){
                    $country_query_count[$res['country']] = 1;
                }else{
                     $country_query_count[$res['country']] = $country_query_count[$res['country']]+1;
                }
            }else{
                $city_query_count['Not Specified'] = $city_query_count['Not Specified']+1;
                $country_query_count['Not Specified'] = $country_query_count['Not Specified']+1;
            }
        }

        $doctor_teleconsultation_count = 0;
        $language_query_count = [];
        $language_query = Query::with(['patient' => function($q){
                                    $q->with('languages');
                                }])
                                ->get();
        foreach($language_query as $q){
            if(!empty($q->patient->languages)){
                foreach($q->patient->languages as $language){
                    if(empty($language_query_count[$language->name])){
                        $language_query_count[$language->name] = 1;
                    }else{
                        $language_query_count[$language->name] = $language_query_count[$language->name]+1;
                    }
                }
            }
        }
        $chart_data = json_encode(['cityQueryCount' => $city_query_count, 'countryQueryCount' => $country_query_count, 'languageQueryCount' => $language_query_count]);

        return view('dashboard', compact('user_chart','chart_data', 'total_hospitals', 'total_doctors', 'open_queries', 'active_queries', 'confirmed_queries', 'closed_queries', 'teleconsultation', 'active_teleconsultation', 'specializations', 'ticket_confirmation', 'last_queries', 'new_users'));
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

    public function sendNotifications(String $channelName){
        $messaging = app('firebase.messaging');
        $consultation = VideoConsultation::where('channel_name', $channelName)->first();
        $user = PatientDetails::with('user')->where('id', $consultation->patient_id)->first()->user;
        $user->notify(new FirebaseNotification("Message Notification", "You have recieved message from teleconsultaion MMT-".$consultation->id, "", ['click_action' => 'messages', 'page_action' => 'active_chat']));
        // $notification = Notification::create("New Title", "New Body");
        // $message = CloudMessage::withTarget('token', $device_tokens);
        // $message->withNotification($notification);
        // $report = $messaging->send($message);
        // dump($report);
        return response(201);
    }

    public function switchLanguage(Request $request){
        $validated = $request->validate(['language' => 'string| in:en,ru,ar,bn']);
        session(['language' => $validated['language']]);
        return response()->json([],201);
    }
}
