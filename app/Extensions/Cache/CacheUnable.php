<?php

namespace App\Extensions\Cache;

use Closure;
use App\Contracts\BlogCache;

class CacheUnable implements BlogCache
{
    public function setTag($tag)
    {
        // TODO: Implement setTag() method.
    }

    public function setExpire($expire)
    {
        // TODO: Implement setExpire() method.
    }

    public function remember($key, Closure $callback, $expire = null, $tag = null)
    {
        return $callback();
    }

    public function rememberForever($key, Closure $callback, $tag = null)
    {
        return $callback();
    }

    public function forget($key)
    {
        return cache()->forget($key);
    }

    public function flush($tag = null)
    {
        return cache()->tags($tag ?? $this->tag)->flush();
    }
}