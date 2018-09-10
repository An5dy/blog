<?php

namespace App\Contracts;

use Closure;

interface BlogCache
{
    /**
     * 设置缓存
     *
     * @param $key
     * @param Closure $callback
     * @param $expire
     * @param null $tag
     * @return mixed
     */
    public function remember($key, Closure $callback, $expire, $tag = null);

    /**
     * 永久永久存储
     *
     * @param $key
     * @param Closure $callback
     * @param null $tag
     * @return mixed
     */
    public function rememberForever($key, Closure $callback, $tag = null);

    /**
     * 删除指定缓存
     *
     * @param $key
     * @return mixed
     */
    public function forget($key);

    /**
     * 清空标签缓存
     *
     * @param null $tag
     * @return mixed
     */
    public function flush($tag = null);
}