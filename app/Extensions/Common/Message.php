<?php

namespace App\Extensions\Common;

class Message
{
    const SUCCESS               = '操作成功';// 操作成功
    const VALIDATE_FAIL         = '表单认证失败';// 表单认证失败
    const OAUTH_FAIL            = '登录失败或超时';// 登录失败或超时
    const OAUTH_REFRESH_FAIL    = '令牌刷新失败';// 令牌刷新失败
    const AUTH_FAIL             = '用户名或密码错误';// 用户名或密码错误
    const NOT_FOUND             = '查询失败';// 查询失败
    const FAIL                  = '操作失败';// 操作失败
}