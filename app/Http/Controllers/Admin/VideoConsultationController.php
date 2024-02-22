<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Models\VideoConsultation;
use App\Traits\IsViewModule;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class VideoConsultationController extends Controller
{
    use IsViewModule;

    protected $module;

    public function __construct()
    {
        $this->module = 'module/video-consultation';
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $consultation = VideoConsultation::with(['doctor', 'patient'])->whereHas('doctor')->orderByDesc('created_at')->get();
        // dd($consultation);
        return $this->module_view('list', compact('consultation'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param \App\Models\VideoConsultation $videoConsultation
     * @return \Illuminate\Http\Response
     */
    public function show(VideoConsultation $videoConsultation)
    {
        $videoConsultation->scheduled_at = Carbon::parse($videoConsultation->scheduled_at)->format('Y-m-d H:m:i');
        return $this->module_view('edit', ['consultation' => $videoConsultation]);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param \App\Models\VideoConsultation $videoConsultation
     * @return \Illuminate\Http\Response
     */
    public function edit(VideoConsultation $videoConsultation)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     * @param \App\Models\VideoConsultation $videoConsultation
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, VideoConsultation $videoConsultation)
    {
        if ($request->has('status')) {
            if ($request->input('status') == 'completed' && !$videoConsultation->is_active) {
                return back()->withErrors("To close a call it should be open first");
            }
            if ($request->input('status') == 'completed') {
                $videoConsultation->is_active = true;
                $videoConsultation->is_completed = true;
            }
            if ($request->input('status') == 'active') {
                $videoConsultation->is_active = true;
            }
            $videoConsultation->save();
            return back()->with('success', 'Consultation updated successfully');
        }
        if ($request->has('scheduled_at')) {
            $videoConsultation->scheduled_at = Carbon::parse($request->input('scheduled_at'))->timestamp;
            $videoConsultation->save();
            return back()->with('success', 'Date updated successfully');
        }
        return back()->withErrors('Something wrong happened please try again.');
    }

    public function startConsultation($id)
    {
        $string = base64_decode($id);
        $channel_name = explode('#', $string)[0];
        $user = last(explode('#', $string));
        $user_name = "User";
        $consultation = VideoConsultation::where('channel_name', $channel_name)->first();
        if($user == 2){
            $user_name = "Admin";
        }elseif($user == 3){
            $user_name = "MMT HCF";
        }
        elseif($user== 4){
            $user_name == "Doctor";
        }
        // $users = User::where('id', '<>', Auth::id())->get();
        return view('agora-chat', ['user_id' => $user, 'channel_name' => $consultation->channel_name, "user_name" => $user_name]);
    }
}
