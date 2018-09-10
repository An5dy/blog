<?php

namespace App\Http\Controllers\Api;

use App\Extensions\Common\Code;
use App\Extensions\Common\Message;
use App\Http\Controllers\Controller;

class ApiController extends Controller
{
    /**
     * 成功返回
     *
     * @param array $data
     * @return \Illuminate\Http\JsonResponse
     */
    public function successResponseWithJson(array $data = [])
    {
        return response()->json([
            'code' => Code::SUCCESS,
            'message' => Message::SUCCESS,
            'data' => $data,
        ]);
    }

    /**
     * 失败返回
     *
     * @param array $data
     * @return \Illuminate\Http\JsonResponse
     */
    public function failResponseWithJson(array $data = [])
    {
        return response()->json([
            'code' => Code::FAIL,
            'message' => Message::FAIL,
            'data' => $data,
        ]);
    }
}
