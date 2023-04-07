<?php

namespace App\Http\Controllers\API\Client;

use App\Http\Controllers\AppBaseController;
use App\Http\Controllers\Controller;
use App\Http\Resources\Client\DoctorCollection;
use App\Http\Resources\Client\DoctorResource;
use App\Http\Resources\Client\HomeResource\DoctorHomeResource;
use App\Models\Doctor;
use App\Models\Hospital;
use App\Models\PatientTestimony;
use Illuminate\Http\Request;
use Illuminate\Support\Arr;
use Illuminate\Support\Facades\File;

class HomeController extends AppBaseController
{
    public function __construct()
    {

    }

    public function modules()
    {
        $files = File::allFiles(public_path('/img/banners/'));
        $livePath = [];
        foreach ($files as $img) {
            $livePath[] = asset('/img/banners/' . $img->getBasename());
        }
        $hospitals = Hospital::query()->orderByDesc('created_at')->limit(10)->get();
        $doctors = Doctor::with(['user', 'doctorSpecializations'])->orderByDesc('created_at')->limit(10)->get();
        $doctors = DoctorHomeResource::collection($doctors)->resolve();
        $stories = PatientTestimony::query()
            ->whereNotNull('images')
            ->select(['images', 'id'])
            ->orderByDesc('created_at')->limit(10)->get();
        foreach ($stories as $story){
            $data['stories'][] = ['id' => $story->id, 'thumbnail' => Arr::random($story->images)];
        }

        $data['hospitals'] = $hospitals;
        $data['doctors'] = $doctors;
        $data['banners'] = $livePath;
//7ebe63ba26c04c6181a83ee9a68a7b5c
        return $this->successResponse($data);
    }
}
