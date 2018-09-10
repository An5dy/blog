<?php

namespace App\Exceptions;

use Exception;
use App\Extensions\Common\Code;
use App\Extensions\Common\Message;
use Illuminate\Database\QueryException;
use GuzzleHttp\Exception\ClientException;
use GuzzleHttp\Exception\ServerException;
use Illuminate\Auth\AuthenticationException;
use Illuminate\Validation\ValidationException;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Foundation\Exceptions\Handler as ExceptionHandler;

class Handler extends ExceptionHandler
{
    /**
     * A list of the exception types that are not reported.
     *
     * @var array
     */
    protected $dontReport = [
        //
    ];

    /**
     * A list of the inputs that are never flashed for validation exceptions.
     *
     * @var array
     */
    protected $dontFlash = [
        'password',
        'password_confirmation',
    ];

    /**
     * Report or log an exception.
     *
     * @param  \Exception  $exception
     * @return void
     */
    public function report(Exception $exception)
    {
        parent::report($exception);
    }

    /**
     * Render an exception into an HTTP response.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Exception  $exception
     * @return \Illuminate\Http\Response
     */
    public function render($request, Exception $exception)
    {
        if ($exception instanceof ModelNotFoundException) {
            return response()->json([
                'code' => Code::NOT_FOUND,
                'message' => Message::NOT_FOUND,
            ]);
        } else if ($exception instanceof QueryException) {
            return response()->json([
                'code' => Code::FAIL,
                'message' => Message::FAIL,
            ]);
        } else if ($exception instanceof AuthenticationException) {
            return response()->json([
                'code' => Code::OAUTH_FAIL,
                'message' => Message::OAUTH_FAIL,
            ]);
        } else if ($exception instanceof ValidationException) {
            return response()->json([
                'code' => Code::VALIDATE_FAIL,
                'message' => collect($exception->errors())->flatten()->first(),
            ]);
        }

        return parent::render($request, $exception);
    }
}
