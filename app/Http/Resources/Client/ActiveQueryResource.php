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
        $data = [];
        if ($this->activeQuery != null && $this->activeQuery->doctor_response != null) {
            $data = [
                'id' => $this->id,
                'name' => $this->name,
                'specialization' => $this->specialization->name,
                'doctor_response' => $this->activeQuery->doctor_response,
                'is_payment_required' => (bool)$this->activeQuery->is_payment_required,
                'is_payment_done' => (bool)$this->activeQuery->is_payment_done,
                'created_at' => Carbon::make($this->created_at)->format('M d, Y | h:m a'),
            ];
        }
        return $data;

    }
}
