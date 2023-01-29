<?php

namespace App\Exceptions;

use App\Utils\ResponseUtil;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Foundation\Exceptions\Handler as ExceptionHandler;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Validation\ValidationException;
use Spatie\Permission\Exceptions\UnauthorizedException;
use Symfony\Component\HttpFoundation\Response as ResponseAlias;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;
use Throwable;

class Handler extends ExceptionHandler
{
    /**
     * A list of the exception types that are not reported.
     *
     * @var array
     */
    protected $dontReport = [
    ];

    /**
     * A list of the inputs that are never flashed for validation exceptions.
     *
     * @var array
     */
    protected $dontFlash = [
        'current_password',
        'password',
        'password_confirmation',
    ];

    /**
     * Register the exception handling callbacks for the application.
     *
     * @return void
     */
    public function register()
    {
        $this->reportable(function (Throwable $e) {
        });
    }

    /**
     * @return string[]
     */
    public function customExceptions(): array
    {
        return [
            BadRequestException::class,
            ChangePasswordFailureException::class,
            DuplicateDataException::class,
            FailedSoftDeleteException::class,
            FailureResponseException::class,
            InsufficientParametersException::class,
            InvalidParamsException::class,
            LoginFailedException::class,
            LoginUnAuthorizeException::class,
            UnAuthorizedRequestException::class,
            UsernamePasswordWrongException::class,
        ];
    }

    /**
     * @param Request   $request
     * @param Throwable $e
     *
     * @throws Throwable
     *
     * @return JsonResponse|Response|ResponseAlias
     */
    public function render($request, Throwable $e)
    {
        \Log::error($e->getTraceAsString());
        if ($e instanceof ModelNotFoundException && $request->expectsJson()) {
            return response()->json(ResponseUtil::generateError(
                'RECORD_NOT_FOUND',
                'Record not found with specified criteria.',
                'Record not found with specified criteria.'
            ), ResponseAlias::HTTP_NOT_FOUND);
        }

        if ($e instanceof ValidationException && $request->expectsJson()) {
            $firstError = collect($e->errors())->first();

            return response()->json(ResponseUtil::generateError(
                'VALIDATION_ERROR',
                'Invalid Data, Validation Failed',
                $firstError[0]
            ), ResponseAlias::HTTP_BAD_REQUEST);
        }

        if ($e instanceof UnauthorizedException && $request->expectsJson()) {
            return response()->json(ResponseUtil::generateError(
                'UNAUTHORIZED',
                'User does not have the right permissions.',
                'User does not have the right permissions.',
            ), ResponseAlias::HTTP_FORBIDDEN);
        }

        if ($e instanceof NotFoundHttpException && $request->expectsJson()) {
            return response()->json(ResponseUtil::generateError(
                ResponseAlias::HTTP_NOT_FOUND,
                'Not Found',
                'Not Found',
            ), ResponseAlias::HTTP_NOT_FOUND);
        }

        if ($request->expectsJson() && !in_array(get_class($e), $this->customExceptions())) {
            return response()->json([
                'STATUS' => ResponseAlias::HTTP_UNPROCESSABLE_ENTITY,
                'MESSAGE' => $e->getMessage(),
                'ERROR' => $e->getMessage(),
            ], ResponseAlias::HTTP_UNPROCESSABLE_ENTITY);
        }

        return parent::render($request, $e);
    }
}
