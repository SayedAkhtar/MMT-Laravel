<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\AppBaseController;
use App\Models\AdminNotifications;
use App\Models\User;
use App\Notifications\FirebaseNotification;
use App\Traits\IsViewModule;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

class AdminNotificationsController extends AppBaseController
{
    use IsViewModule;
    protected $module;

    public function __construct()
    {
        $this->module = 'module/notification';
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $notifications = AdminNotifications::all();
        return $this->module_view('list', compact('notifications'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $users = User::where('user_type', User::TYPE_USER)
                        ->where('firebase_token', '!=', null)
                        ->where('firebase_token', '!=', '')
                        ->get();
        return $this->module_view('add', ['users' => $users]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $request->validate(['users.*' => 'required | exists:users,id', 'title' => 'required|string', 'body' => 'required|string']);
        if($request->has('all_users')){
            $users = User::where('firebase_token','!=', null)->get();
        }else{
            $users = User::whereIn('id', $request->input('users'))->get();
        }
        foreach($users as $user){
            try{
                if($request->has('url')){
                    $user->notify(new FirebaseNotification(
                        $request->input('title'), 
                        $request->input('body'),
                        $request->input('image', ''),
                        [
                            "click_action" => "FLUTTER_NOTIFICATION_CLICK",
                            "sound" => "default",
                            "status" => "done",
                            "screen" => "openUrl",
                            "url" => $request->input('url'),
                            "content_available" => "true"
                        ]
                    ));
                    
                }else{
                    $user->notify(new FirebaseNotification(
                        $request->input('title'), $request->input('body'))
                    );
                }
                
                // AdminNotifications::create([
                //     'user_id' => $user->id,
                //     'notification_title' => $request->input('title'),
                //     'notification_body' => $request->input('body'),
                //     'notification_url' => $request->input('url'),
                //     'status' => true,
                // ]);
            }catch(\Exception $e){
                Log::error($e->getMessage());
                dd($e);
                // AdminNotifications::create([
                //     'user_id' => $user->id,
                //     'notification_title' => $request->input('title'),
                //     'notification_body' => $request->input('body'),
                //     'notification_url' => $request->input('url'),
                //     'status' => false,
                // ]);
                return back()->with('error', 'Notifications Sending Failed');
            }
        }
        return back()->with('success', 'Notifications Sent');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\AdminNotifications  $adminNotifications
     * @return \Illuminate\Http\Response
     */
    public function show(AdminNotifications $adminNotifications)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\AdminNotifications  $adminNotifications
     * @return \Illuminate\Http\Response
     */
    public function edit(AdminNotifications $adminNotifications)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\AdminNotifications  $adminNotifications
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, AdminNotifications $adminNotifications)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\AdminNotifications  $adminNotifications
     * @return \Illuminate\Http\Response
     */
    public function destroy(AdminNotifications $adminNotifications)
    {
        //
    }
}
