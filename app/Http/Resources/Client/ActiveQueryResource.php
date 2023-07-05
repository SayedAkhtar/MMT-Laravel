<?php

namespace App\Http\Resources\Client;

use App\Http\Resources\BaseAPIResource;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;

class ActiveQueryResource extends BaseAPIResource
{
    /**
     * @param Request $request
     *
     * @return array
     */
    public function toArray($request): array
    {
        $fieldsFilter = $request->get('fields');
        if (!empty($fieldsFilter) || $request->get('include')) {
            return $this->resource->toArray();
        }
        $total_step = 5;
        $current_step = $this->current_step;
        $response = "";
        switch ($this->type) {
            case 1:
                $response = $this->current_step != 1 ? $this->getStepResponse(2)['doctor'] : "No doctor's received yet";
                $total_step = $this->payment_required ? 5 : 4;
                break;
            case 2:
                $response = "Your medical visa query is under process. Please wait for further instructions";
                $total_step = $this->payment_required ? 3 : 2;
                $current_step = $this->current_step - 2;
                break;
            default;
        }
        $data = [
            'id' => $this->id,
            'specialization' => $this->specialization->name ?? "No Specialization Selected",
            'doctor_response' => $response,
            'payment_required' => (bool)$this->payment_required,
            'is_payment_done' => (bool)array_search('4', $this->responses->pluck('step')->toArray()),
            'query_step_name' => "Step $current_step of $total_step",
            'query_step_note' => $this->current_step == 1 ? 'Your query is being reviewed. You will receive a response soon.' : 'Proceed with next step',
            'is_completed' => (bool)$this->is_completed,
            'is_confirmed' => (bool)$this->confirmed_details,
            'current_step' => $this->current_step,
            'type' => $this->type,
            'created_at' => Carbon::make($this->created_at)->format('M d, Y | h:m a'),
        ];
        return $data;

    }
}
