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
        $next_step = $this->current_step;
        $response = "";
        switch ($this->type) {
            case 1:
                $response = "Your query is under review. Please check back for update.";
                if($this->current_step != 1){
                    $response = array_values(array_slice($this->getStepResponse(2), -1))[0]['doctor'];
                }
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
            'query_hash' => $this->query_hash,
            'specialization' => $this->specialization->name ?? "No Specialization Selected",
            'doctor_response' => $response,
            'payment_required' => (bool)$this->payment_required,
            'is_payment_done' => (bool)array_search('4', $this->responses->pluck('step')->toArray()),
            'query_step_name' => "Step $current_step of $total_step",
            'query_step_note' => $this->current_step == 1 ? 'Your query is being reviewed. You will receive a response soon.' : 'Proceed with next step',
            'is_completed' => (bool)$this->is_completed,
            'is_confirmed' => (bool)$this->confirmed_details,
            'current_step' => $this->current_step,
            'next_step' => $this->getNextStep(),
            'type' => $this->type,
            'created_at' => strtotime($this->created_at),
        ];
        return $data;

    }
}
