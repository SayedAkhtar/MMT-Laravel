<?php

namespace App\Http\Controllers\Device;

use App\Http\Controllers\AppBaseController;
use App\Http\Requests\Device\FileUploadAPIRequest;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Auth;
use Spatie\MediaLibrary\MediaCollections\Exceptions\FileDoesNotExist;
use Spatie\MediaLibrary\MediaCollections\Exceptions\FileIsTooBig;

class FileUploadController extends AppBaseController
{
    /**
     * @param FileUploadAPIRequest $request
     *
     * @throws FileDoesNotExist
     * @throws FileIsTooBig
     *
     * @return JsonResponse
     */
    public function upload(FileUploadAPIRequest $request): JsonResponse
    {
        $files = $request->file('files');
        foreach ($files as $file) {
            $user = Auth::user();
            $user->addMedia($file)->toMediaCollection('user', config('app.media_disc'));
        }

        return $this->successResponse('File upload successfully.');
    }
}