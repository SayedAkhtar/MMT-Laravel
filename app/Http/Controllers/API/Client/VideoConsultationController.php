<?php

namespace App\Http\Controllers\API\Client;

use App\Http\Controllers\AppBaseController;
use App\Models\Payment;
use App\Models\VideoConsultation;
use Illuminate\Http\Request;

;

class VideoConsultationController extends AppBaseController
{
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
