<?php

namespace App\Http\Controllers\API\Client;

use App\Http\Controllers\AppBaseController;
use App\Http\Requests\Device\FileUploadAPIRequest;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\Auth;
use Spatie\MediaLibrary\MediaCollections\Exceptions\FileDoesNotExist;
use Spatie\MediaLibrary\MediaCollections\Exceptions\FileIsTooBig;

class FileUploadController extends AppBaseController
{
    /**
     * @param FileUploadAPIRequest $request
     *
     * @return JsonResponse
     * @throws FileIsTooBig*@throws \Exception
     *
     * @throws FileDoesNotExist
     * @throws \Exception
     */
    public function upload(Request $request)
    {
        $request->validate([
            'files' => ['required'],
            'files.*' => ['mimes:png,jpeg,jpg,pdf', 'max:10240'],
            'model' => ['required'],
            'model_id' => ['required'],
            'collection' => ['sometimes'],
        ]);
        $files = $request->file('files');
        $model = $request->input('model');
        foreach ($files as $file) {
            if (empty($model)) {
                $user = Auth::user();
                $user->addMedia($file)->toMediaCollection('user', config('app.media_disc'));
            } else {
                $modelpath = "App\Models\\$model";
                $model = App::make($modelpath);
                $model = $model->findOrFail($request->model_id);
                $collection = strtolower($request->collection ?? $request->model);
                $model->addMedia($file)->toMediaCollection($collection, config('app.media_disc'));
            }
        }

        return $this->successResponse('File upload successfully.');
    }
}
