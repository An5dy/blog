<?php

namespace App\Extensions\Common;

class Code
{
    const SUCCESS               = '2000';// 操作成功
    const VALIDATE_FAIL         = '4000';// 表单认证失败
    const OAUTH_FAIL            = '4001';// 登录失败或超时
    const OAUTH_REFRESH_FAIL    = '4002';// 令牌刷新失败
    const AUTH_FAIL             = '4003';// 用户名或密码错误
    const NOT_FOUND             = '4004';// 查询失败
    const FAIL                  = '5000';// 操作失败
}