<?php

namespace App\Http\Controllers\API\Client;

use App\Http\Controllers\AppBaseController;
use App\Http\Controllers\Controller;
use App\Models\Hospital;
use Illuminate\Http\Request;

class HomeController extends AppBaseController
{
    public function modules()
    {
        $hospitals = Hospital::query()->get()->limit(10)->orderByDesc('created_at');
        $data['hospitals'] = $hospitals->toArray();
        $this->successResponse($data);
    }
}
