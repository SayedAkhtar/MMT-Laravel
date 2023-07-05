<?php

namespace App\Http\Resources\Client;

use App\Http\Resources\BaseAPIResource;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;

class QueryResource extends BaseAPIResource
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
        $allQuery = [
            'id' => $this->id,
            'name' => $this->patient->name,
            'specialization' => $this->specialization->name ?? "Not Selected",
            'created_at' => Carbon::make($this->created_at ?? now())->format('M d, Y | h:m a'),
            'is_completed' => (bool)$this->is_completed,
//            'completed_at' => $this->when($this->completed_at != null, Carbon::make($this->completed_at)->format('M d, Y | h:m a')),
        ];
        return $allQuery;
    }
}
