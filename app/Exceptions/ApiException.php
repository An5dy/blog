<?php

namespace App\Exceptions;

use Exception;
use Throwable;

class ApiException extends Exception
{
    protected $message;

    protected $code;

    public function __construct($message = "", $code = 0, Throwable $previous = null)
    {
        parent::__construct($message, $code, $previous);
        $this->message = $message;
        $this->code = $code;
    }

    /**
     * 错误处理
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function render()
    {
        return response()->json([
            'code' => $this->code,
            'message' => $this->message
        ]);
    }
}
