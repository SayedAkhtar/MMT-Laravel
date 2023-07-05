<?php

namespace App\Http\Resources\Client;

use App\Http\Resources\BaseAPIResource;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class DoctorResource extends BaseAPIResource
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
        $hospital = [];
        if (!empty($this->hospitals)) {
            foreach ($this->hospitals as $e) {
                $hospital[] = ['id' => $e->id, 'name' => $e->name];
            }
        }
        $time_slot = !empty($this->time_slots)?json_decode($this->time_slots, true):[];
        $data = [];
        if (!empty($time_slot)) {
            foreach ($time_slot as $key => $value) {
                foreach ($value as $v) {
                    $data[] = [
                        "name" => Str::headline($key) . " " . $v,
                        "utc" => Carbon::parse($key . " " . $v)->getTimestamp()
                    ];
                }
            }
        }
        if($this->is_active == 1){
            return [
                'id' => $this->id,
                'name' => $this->user->name,
                'phone' => $this->user->phone,
                'email' => $this->user->email,
                'image' => $this->getMedia('avatar')->first() ? $this->getMedia('avatar')->first()->getUrl() : '',
                'start_of_service' => $this->start_of_service,
                'experience' => \Carbon\Carbon::make($this->start_of_service)->diffInYears(),
                'awards' => array_filter(explode('|', $this->awards), function($element){if(!empty($element)){return trim($element);}}),
                'description' => $this->description,
                'designation' => $this->designations->pluck('name'),
                'qualification' => $this->qualifications->pluck('name'),
                'faq' => $this->faq,
                'time_slots' => $data,
                'specialization' => $this->specializations->pluck('name'),
                'hospitals' => $hospital,
                'price' => (int)$this->price,
            ];
        }
        
    }
}
