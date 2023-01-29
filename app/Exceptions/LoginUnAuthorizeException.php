<?php

namespace App\Exceptions;

use App\Utils\ResponseUtil;
use Exception;
use Illuminate\Http\JsonResponse;
use Symfony\Component\HttpFoundation\Response;
use Throwable;

class LoginUnAuthorizeException extends Exception
{
    /**
     * @param string         $message
     * @param int            $code
     * @param Throwable|null $previous
     */
    public function __construct($message = '', $code = Response::HTTP_UNAUTHORIZED, Throwable $previous = null)
    {
        parent::__construct($message, $code, $previous);
    }

    /**
     * @return JsonResponse
     */
    public function render(): JsonResponse
    {
        return response()->json(ResponseUtil::generateError(
            'UNAUTHORIZED',
            'You are not authorized to access the request',
            $this->getMessage()
        ), $this->getCode());
    }
}
