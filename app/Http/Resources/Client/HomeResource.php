<?php

namespace App\Http\Resources\Client;

use App\Http\Resources\BaseAPIResource;
use App\Models\Doctor;
use App\Models\Hospital;
use Illuminate\Http\Request;

class HomeResource extends BaseAPIResource
{

    /**
     * @param Request $request
     *
     * @return array
     */
    public function toArray($request)
    {
        $hospitals = Hospital::query()->orderByDesc('created_at')->limit(10)->get();
        $doctors = Doctor::with('user')->orderByDesc('created_at')->limit(10)->get();
//        foreach ($doctors as $doctor){
//            $doctor->
//        }
        return parent::toArray($request);
    }
}
