<?php

namespace App\Exceptions;

use App\Utils\ResponseUtil;
use Exception;
use Illuminate\Http\JsonResponse;
use Symfony\Component\HttpFoundation\Response;
use Throwable;

class FailedSoftDeleteException extends Exception
{
    /**
     * @param string         $message
     * @param int            $code
     * @param Throwable|null $previous
     */
    public function __construct($message = '', $code = Response::HTTP_INTERNAL_SERVER_ERROR, Throwable $previous = null)
    {
        parent::__construct($message, $code, $previous);
    }

    /**
     * @return JsonResponse
     */
    public function render(): JsonResponse
    {
        return response()->json(ResponseUtil::generateError(
            'FAILURE',
            'Data can not be deleted due to internal server error',
            []
        ), $this->getCode());
    }
}
