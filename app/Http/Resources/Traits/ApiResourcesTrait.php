<?php

namespace App\Http\Resources\Traits;

use App\Extensions\Common\Code;
use App\Extensions\Common\Message;

trait ApiResourcesTrait
{
    /**
     * 自定义返回字段
     *
     * @return array
     */
    public function with($request)
    {
        return [
            'code' => Code::SUCCESS,
            'msg' => Message::SUCCESS,
        ];
    }
}