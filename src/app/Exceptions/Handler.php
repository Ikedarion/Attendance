<?php

namespace App\Exceptions;

use Illuminate\Auth\AuthenticationException;
use Illuminate\Foundation\Exceptions\Handler as ExceptionHandler;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Illuminate\Validation\ValidationException;
use Symfony\Component\HttpFoundation\Response as HttpResponse;
use Throwable;

class Handler extends ExceptionHandler
{
    /**
     * A list of the exception types that are not reported.
     *
     * @var array<int, class-string<Throwable>>
     */
    protected $dontReport = [
        //
    ];

    /**
     * A list of the inputs that are never flashed for validation exceptions.
     *
     * @var array<int, string>
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
            //
        });

        $this->renderable(function (Throwable $e, Request $request) {
            if ($request->is('api/*') || $request->ajax()) {
                Log::error('[API Error] ' . $request->method() . ': ' . $request->fullUrl());

                if ($this->isHttpException($e)) {
                    $message = $e->getMessage() ?: HttpResponse::$statusTexts[$e->getStatusCode()];
                    Log::error($message);

                    return response()->json([
                        'message' => $message
                    ], $e->getStatusCode());
                } elseif ($e instanceof ValidationException) {
                    Log::error($e->errors());

                    return $this->invalidJson($request, $e);
                } elseif ($e instanceof AuthenticationException) {
                    Log::error("Unauthenticated.");

                    return response()->json([
                        'message' => 'Unauthenticated.'
                    ], 401);
                } else {
                    return response()->json([
                        'message' => 'Internal Server Error'
                    ], 500);
                }
            }
        });
    }
}
