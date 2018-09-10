<?php

namespace App\Extensions\Cache;

use Closure;
use App\Contracts\BlogCache;

class CacheAble implements BlogCache
{
    /**
     * 缓存
     *
     * @param $key
     * @param Closure $callback
     * @param $expire
     * @param null $tag
     */
    public function remember($key, Closure $callback, $expire, $tag = null)
    {
        if (isset($tag)) {
            return cache()->tags($tag)->remember($key, $expire, $callback);
        } else {
            return cache()->remember($key, $expire, $callback);
        }
    }

    /**
     * 永久缓存
     *
     * @param $key
     * @param Closure $callback
     * @param null $tag
     */
    public function rememberForever($key, Closure $callback, $tag = null)
    {
        if (isset($tag)) {
            return cache()->tags($tag)->rememberForever($key, $callback);
        } else {
            return cache()->rememberForever($key, $callback);
        }
    }

    /**
     * 删除指定 key 缓存
     *
     * @param $key
     */
    public function forget($key)
    {
        return cache()->forget($key);
    }

    /**
     * 删除指定 tag 缓存
     *
     * @param null $tag
     */
    public function flush($tag = null)
    {
        if (isset($tag)) {
            return cache()->tags($tag)->flush();
        } else {
            return cache()->flush();
        }
    }
}