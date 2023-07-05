<?php

namespace App\Http\Resources\Client;

use App\Http\Resources\BaseAPIResource;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class TreatmentResource extends BaseAPIResource
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
        if($this->is_active == 1){
            return [
                'id' => $this->id,
                'name' => $this->name,
                'min_price' => $this->min_price,
                'max_price' => $this->max_price,
                'logo' => asset(Storage::url($this->logo)),
                'days_required' => $this->days_required,
                'recovery_time' => $this->recovery_time,
                'success_rate' => $this->success_rate,
                'covered' => $this->covered,
                'not_covered' => $this->not_covered,
            ];
        }
        
    }
}
