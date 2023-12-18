<?php

namespace App\Http\Controllers\API\Client;

use App\Http\Controllers\AppBaseController;
use App\Http\Resources\Client\HomeResource\DoctorHomeResource;
use App\Models\Doctor;
use App\Models\Faq;
use App\Models\Hospital;
use App\Models\PatientTestimony;
use App\Models\Settings;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class HomeController extends AppBaseController
{
    public function __construct()
    {

    }

    public function modules()
    {
        $banners = Settings::where('name', 'banners')->first();
        $files = explode(',', $banners);
        $livePath = [];
        if (!empty($banners)) {
            foreach ($files as $img) {
                $livePath[] = env('APP_URL') . Storage::url($img);
            }
        }

        $hospitals = Hospital::query()->where('is_active', 1)->orderByDesc('created_at')->limit(10)->get();
        $doctors = Doctor::with(['user', 'specializations', 'designations'])->where('is_active', 1)->orderByDesc('created_at')->limit(10)->get();
        $doctors = DoctorHomeResource::collection($doctors)->resolve();
        $stories = PatientTestimony::query()
            ->whereNotNull('images')
            ->select(['images', 'id'])
            ->orderByDesc('created_at')->limit(10)->get();
        $faq = Faq::query()->select(['question', 'answer'])->limit(10)->get();
        $processedTestimony = [];
        if (!empty($stories)) {
            foreach ($stories as $testimony) {
                $images = explode(',', $testimony->images);
                foreach ($images as $path) {
                    $processedTestimony[] = [
                        'type' => 'image',
                        'value' => env('APP_URL') . Storage::url($path),
                    ];
                }
            }
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
        $data['stories'] = $processedTestimony;
        $data['hospitals'] = $processedHospitals;
        $data['doctors'] = $doctors;
        $data['banners'] = $livePath;
        $data['faq'] = $faq->toArray();
        return $this->successResponse($data);
    }

    public function searchHospitalDoctor(Request $request)
    {
        $term = $request->input('term');
        if(app()->getLocale() != "en"){
            $locale = app()->getLocale();
            $hospitals = Hospital::query()->whereRaw("JSON_EXTRACT(name, '$.$locale') LIKE ?", ["%$term%"])->select(['id', 'name', 'address'])->get();
            $doctors = Doctor::with(['user', 'specializations'])->whereHas('user', function ($q) use ($term, $locale) {
                $q->whereRaw("JSON_EXTRACT(name, '$.$locale') LIKE ?", ["%$term%"]);
            })->get();
        }else{
            $hospitals = Hospital::query()->where('name', 'like', '%' . $term . '%')->select(['id', 'name', 'address'])->get();
            $doctors = Doctor::with(['user', 'specializations'])->whereHas('user', function ($q) use ($term) {
                $q->where('name', 'like', '%' . $term . '%');
            })->get();
        }
        
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
            $result['name'] = Str::title($doctor->user->name);
            $result['description'] = $doctor->specializations->pluck('name')->join(', ') . "\n" . Carbon::make($doctor->start_of_service)->diffInYears() . " yrs of Experience";
            $result['logo'] = $doctor->getMedia('avatar')->first()?->getUrl() ?? 'https://via.placeholder.com/640x480.png/00eeaa?text=No%20Image';
            $result['type'] = 'doctor';
            $results[] = $result;
        }
        return $this->successResponse($results);
    }

    public function getCountries(){
        $countries = \App\Models\Country::all();
        return $this->successResponse($countries);
    }
}
