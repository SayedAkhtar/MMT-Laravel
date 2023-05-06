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
        $data = [
            'id' => $this->id,
            'specialization' => $this->specialization->name,
            'doctor_response' => !empty($this->activeQuery) ? $this->activeQuery->doctor_response : '',
            'is_payment_required' => !empty($this->activeQuery) && (bool)$this->activeQuery->is_payment_required,
            'is_payment_done' => !empty($this->activeQuery) && (bool)$this->activeQuery->is_payment_done,
            'query_step_name' => !empty($this->activeQuery) ? 'Step 1 of 5' : 'Step 2 of 5',
            'query_step_note' => !empty($this->activeQuery) ? ($this->activeQuery->doctor_response ? 'Proceed with next step' : 'Awaiting Doctor\'s response') : 'Query is under observation by MyMedTrip Admin, You will receive a doctor\'s response soon.',
            'created_at' => Carbon::make($this->created_at)->format('M d, Y | h:m a'),
        ];
        return $data;

    }
}
