<?php

namespace App\Http\Controllers\API\Client;

use App\Exceptions\LoginFailedException;
use App\Http\Controllers\AppBaseController;
use App\Http\Controllers\Controller;
use App\Http\Resources\Client\HCFResource;
use App\Models\Query;
use App\Models\User;
use App\Notifications\FirebaseNotification;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\ValidationException;

class HcfController extends AppBaseController
{

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $queries = Query::with(['patient', 'specialization', 'doctor', 'hospital'])
                        ->where('coordinator_id', request()->user()->id)
                        ->get();
        return HCFResource::collection($queries);
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
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $query = Query::find($id);
        $status = json_decode($query->status, true) ?? [];
        return $this->successResponse($status);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        try {
            $request->validate(['status' => 'required', 'file' => 'sometimes']);
            $query = Query::find($id);
            $status = json_decode($query->status, true);
            $status = $status??[];
            $newStatus = ['status' => $request->input('status'), 'file' => $request->input('file'), 'timestamp' => Carbon::now()->timestamp];
            $status[] = $newStatus;
            $query->status = json_encode($status);
            $query->save();
            $query->notify(new FirebaseNotification("Status Updated by HCF", $request->input('status')));
            return $this->successResponse("Status Updated");
        } catch (\Exception $e) {
            return $this->errorResponse($e->getMessage());
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
