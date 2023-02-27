<?php

namespace App\Http\Controllers\API\Client;

use App\Http\Controllers\AppBaseController;
use App\Http\Controllers\Controller;
use App\Http\Resources\Client\DoctorCollection;
use App\Models\Doctor;
use App\Models\Hospital;
use Illuminate\Http\Request;
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
        foreach ($files as $img){
            $livePath[] = asset('/img/banners/'.$img->getBasename());
        }
        $hospitals = Hospital::query()->orderByDesc('created_at')->limit(10)->get();
        $doctors = Doctor::with('user')->orderByDesc('created_at')->limit(10)->get();
        $doctors = DoctorCollection::make($doctors)->resolve();
        $data['hospitals'] = $hospitals;
        $data['doctors'] = $doctors['data'];
        $data['banners'] = $livePath;
        return $this->successResponse($data);
    }
}
