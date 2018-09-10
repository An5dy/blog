<?php

if (! function_exists('user')) {
    /**
     * 获取当前登陆的用户
     *
     * @author ze
     * @param null $guard
     * @return mixed
     */
    function user($guard = null)
    {
        return empty($guard) ? app('auth')->user() : app('auth')->guard($guard)->user();
    }
}

if (! function_exists('markdown')) {
    /**
     * 转换 markdown 格式文本
     *
     * @param $markdown
     * @param bool $markupEscaped
     * @return string
     */
    function markdown($markdown, $markupEscaped = true)
    {
        return Parsedown::instance()
            ->setMarkupEscaped($markupEscaped)
            ->text($markdown);
    }
}

if (! function_exists('is_admin')) {
    /**
     * 判断是否 admin 后台
     *
     * @param string $prefix
     * @return bool
     */
    function is_admin($prefix = 'admin')
    {
        $routePrefix = request()->route()->getPrefix();

        return strpos($routePrefix, $prefix) !== false ?: false;
    }
}

if (! function_exists('api_success')) {
    /**
     * 正确返回格式
     *
     * @param $data
     * @return array
     */
    function api_success($data = [])
    {
        return [
            'code' => \App\Extensions\Common\Code::SUCCESS,
            'message' => \App\Extensions\Common\Message::SUCCESS,
            'data' => $data,
        ];
    }
}

if (! function_exists('str_cut')) {
    /**
     * 指定字符串切割
     *
     * @param $str
     * @param $cut
     * @param $start
     * @return string
     */
    function str_cut($str, $cut, $start)
    {
        $arr = explode($cut, $str);
        $len = count($arr);

        if ($start < 0) {
            $arr = array_reverse($arr);
            $start = abs($start);
        }

        return $start > $len ? '' : $arr[$start - 1];
    }
}