<?php

namespace App\Http\Controllers\API\Client;

use App\Http\Controllers\AppBaseController;
use App\Models\Payment;
use App\Models\VideoConsultation;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;

;

class VideoConsultationController extends AppBaseController
{
    public function index()
    {
        $result = VideoConsultation::query()->whereHas('patient', function ($query) {
            $query->where('user_id', Auth::id());
        })->get()->each(function ($r) {
            $r->agora_id = env('AGORA_APP_ID');
            $r->scheduled_at = Carbon::createFromTimestampUTC($r->scheduled_at)->format('d M,Y h:m a');
        });
        if ($result) {
            return $this->successResponse($result);
        } else {
            return $this->errorResponse("No Data", 404);
        }
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'doctor_id' => 'required|exists:doctors,id',
            'patient_id' => 'required|exists:patient_details,id',
            'scheduled_at' => 'required|integer'
        ]);
        try {
            $result = VideoConsultation::create([
                'doctor_id' => $validated['doctor_id'],
                'channel_name' => Str::uuid(),
                'patient_id' => $validated['patient_id'],
                'scheduled_at' => $validated['scheduled_at'],
                'payment_id' => 1,
                'payment_status' => Payment::SUCCESS,
            ]);
            if ($result) {
                return $this->successResponse($result);
            }
        } catch (\Exception $e) {
            return $this->errorResponse($e->getMessage());
        }

    }
}
