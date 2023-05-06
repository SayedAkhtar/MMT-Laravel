<?php

namespace App\Http\Controllers\API\Client;

use App\Http\Controllers\AppBaseController;
use App\Http\Resources\Client\HomeResource\DoctorHomeResource;
use App\Models\Doctor;
use App\Models\Hospital;
use App\Models\PatientTestimony;
use Illuminate\Http\Request;
use Illuminate\Support\Arr;
use Illuminate\Support\Carbon;
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
        $doctors = Doctor::with(['user', 'specializations'])->orderByDesc('created_at')->limit(10)->get();
        $doctors = DoctorHomeResource::collection($doctors)->resolve();
        $stories = PatientTestimony::query()
            ->whereNotNull('images')
            ->select(['images', 'id'])
            ->orderByDesc('created_at')->limit(10)->get();
        foreach ($stories as $story) {
            $data['stories'][] = ['id' => $story->id, 'thumbnail' => Arr::random($story->images)];
        }
        $processedHospitals = [];
        foreach ($hospitals as $temp) {
            $processedHospitals[] = [
                'id' => $temp->id,
                'name' => $temp->name,
                'logo' => $temp->getMedia('logo')->first()?->getUrl('thumbnail'),
                'address' => $temp->address,
            ];
        }
        $data['hospitals'] = $processedHospitals;
        $data['doctors'] = $doctors;
        $data['banners'] = $livePath;
        return $this->successResponse($data);
    }

    public function searchHospitalDoctor(Request $request)
    {
        $term = $request->input('term');
        $hospitals = Hospital::query()->where('name', 'like', '%' . $term . '%')->select(['id', 'name', 'address'])->get();
        $doctors = Doctor::with(['user', 'specializations'])->whereHas('user', function ($q) use ($term) {
            $q->where('name', 'like', '%' . $term . '%');
        })->get();
        $results = [];
        foreach ($hospitals as $hospital) {
            $result['id'] = $hospital->id;
            $result['name'] = $hospital->name;
            $result['description'] = $hospital->address;
            $result['logo'] = $hospital->getMedia('logo')->first()?->getUrl() ?? 'https://via.placeholder.com/640x480.png/00eeaa?text=No%20Image';
            $result['type'] = 'hospital';
            $results[] = $result;
        }
        foreach ($doctors as $doctor) {
            $result['id'] = $doctor->id;
            $result['name'] = $doctor->user->name;
            $result['description'] = $doctor->specializations->pluck('name')->join(', ') . ' \n ' . Carbon::make($doctor->start_of_service)->diffInYears() . " yrs of Experience";
            $result['logo'] = $doctor->getMedia('avatar')->first()?->getUrl() ?? 'https://via.placeholder.com/640x480.png/00eeaa?text=No%20Image';
            $result['type'] = 'doctor';
            $results[] = $result;
        }
        return $this->successResponse($results);
    }
}
