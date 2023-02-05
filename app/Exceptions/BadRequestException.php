<?php

namespace App\Exceptions;

use App\Utils\ResponseUtil;
use Exception;
use Illuminate\Http\JsonResponse;
use Symfony\Component\HttpFoundation\Response;
use Throwable;

class BadRequestException extends Exception
{
    /**
     * @param string         $message
     * @param int            $code
     * @param Throwable|null $previous
     */
    public function __construct($message = '', $code = Response::HTTP_FORBIDDEN, Throwable $previous = null)
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
            'The request cannot be fulfilled due to bad syntax',
            $this->getMessage()
        ), $this->getCode());
    }
}
